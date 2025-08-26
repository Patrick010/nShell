<?php

declare(strict_types=1);

namespace OCA\nShell\Service;

use OCA\nShell\Db\Session;
use OCP\IDBConnection;
use Psr\Log\LoggerInterface;

class SessionManager {

    private IDBConnection $db;
    private LoggerInterface $logger;
    private const SESSION_LIFETIME = 3600; // 1 hour
    private const TABLE = 'n_shell_sessions';

    public function __construct(IDBConnection $db, LoggerInterface $logger) {
        $this->db = $db;
        $this->logger = $logger;
    }

    public function create(string $uid): Session {
        $sessionId = uniqid('nshell_');
        $createdAt = time();
        $expiresAt = $createdAt + self::SESSION_LIFETIME;

        $qb = $this->db->getQueryBuilder();
        $qb->insert(self::TABLE)
            ->values([
                'uid' => $qb->createNamedParameter($uid),
                'session_id' => $qb->createNamedParameter($sessionId),
                'created_at' => $qb->createNamedParameter($createdAt),
                'expires_at' => $qb->createNamedParameter($expiresAt)
            ])
            ->execute();

        $this->logger->debug('Session created: ' . $sessionId);
        return new Session($uid, $sessionId, $createdAt, $expiresAt);
    }

    public function get(string $sessionId): ?Session {
        $qb = $this->db->getQueryBuilder();
        $result = $qb->select('uid', 'session_id', 'created_at', 'expires_at')
            ->from(self::TABLE)
            ->where($qb->expr()->eq('session_id', $qb->createNamedParameter($sessionId)))
            ->executeQuery();

        $row = $result->fetch(); // Replaced fetchAssociative() with fetch()
        $result->closeCursor(); // Free the cursor

        if ($row === false) {
            return null;
        }

        return new Session(
            $row['uid'],
            $row['session_id'],
            (int)$row['created_at'],
            (int)$row['expires_at']
        );
    }

    public function delete(string $sessionId): void {
        $qb = $this->db->getQueryBuilder();
        $qb->delete(self::TABLE)
            ->where($qb->expr()->eq('session_id', $qb->createNamedParameter($sessionId)))
            ->execute();
        $this->logger->debug('Session deleted: ' . $sessionId);
    }
}