<?php

declare(strict_types=1);

namespace OCA\nShell\Db;

use OCP\AppFramework\Db\Entity;
use OCP\AppFramework\Db\QBMapper;
use OCP\IDBConnection;

class SessionMapper extends QBMapper {

    public function __construct(IDBConnection $db) {
        parent::__construct($db, 'nshell_sessions', Session::class);
    }

    /**
     * Find a session by its public session ID
     *
     * @param string $sessionId
     * @return Session|null
     */
    public function findBySessionId(string $sessionId): ?Session {
        $qb = $this->db->getQueryBuilder();
        $qb->select('*')
            ->from($this->tableName)
            ->where($qb->expr()->eq('session_id', $qb->createNamedParameter($sessionId)));

        return $this->findOne($qb);
    }

    public function insert(Entity $entity): Entity {
        if (!$entity instanceof Session) {
            throw new \InvalidArgumentException('Expected instance of Session');
        }

        $qb = $this->db->getQueryBuilder();
        $qb->insert($this->tableName)
            ->values([
                'uid' => $qb->createNamedParameter($entity->getUid()),
                'session_id' => $qb->createNamedParameter($entity->getSessionId()),
                'created_at' => $qb->createNamedParameter($entity->getCreatedAt()),
                'expires_at' => $qb->createNamedParameter($entity->getExpiresAt())
            ]);
        $qb->execute();

        $entity->setId((int)$this->db->lastInsertId());
        return $entity;
    }
}
