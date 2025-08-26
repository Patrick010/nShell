<?php

declare(strict_types=1);

namespace OCA\nShell\Service;

use OCA\nShell\Db\Session;
use OCA\nShell\Db\SessionMapper;
use Psr\Log\LoggerInterface;

class SessionManager {

    private SessionMapper $sessionMapper;
    private LoggerInterface $logger;
    private const SESSION_LIFETIME = 3600; // 1 hour

    public function __construct(SessionMapper $sessionMapper, LoggerInterface $logger) {
        $this->sessionMapper = $sessionMapper;
        $this->logger = $logger;
    }

    /**
     * Creates a new session record in the database.
     *
     * @param string $uid
     * @return Session
     */
    public function create(string $uid): Session {
        $this->logger->debug('SessionManager: Creating session for user ' . $uid);

        $session = new Session();
        $session->uid = $uid;
        $session->sessionId = uniqid('nshell_');
        $session->createdAt = time();
        $session->expiresAt = time() + self::SESSION_LIFETIME;

        $this->sessionMapper->insert($session);
        $this->logger->debug('SessionManager: Session created in DB with session_id ' . $session->sessionId);
        return $session;
    }

    /**
     * Retrieves a session record by its public session ID.
     *
     * @param string $sessionId
     * @return Session|null
     */
    public function get(string $sessionId): ?Session {
        return $this->sessionMapper->findBySessionId($sessionId);
    }

    /**
     * Deletes a session record from the database.
     *
     * @param string $sessionId
     * @return void
     */
    public function delete(string $sessionId): void {
        $session = $this->get($sessionId);
        if ($session !== null) {
            $this->sessionMapper->delete($session);
        }
    }
}
