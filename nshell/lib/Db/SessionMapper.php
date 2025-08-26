<?php

declare(strict_types=1);

namespace OCA\nShell\Db;

use OCP\AppFramework\Db\QBMapper;
use OCP\IDBConnection;

class SessionMapper extends QBMapper {

    public function __construct(IDBConnection $db) {
        parent::__construct($db, 'nshell_sessions', Session::class);
    }

    /**
     * Find a session by its ID
     *
     * @param string $id
     * @return Session|null
     */
    public function find(string $id): ?Session {
        $qb = $this->db->getQueryBuilder();
        $qb->select('*')
            ->from($this->tableName)
            ->where($qb->expr()->eq('id', $qb->createNamedParameter($id)));

        return $this->findOne($qb);
    }

    /**
     * Insert a new session into the database
     *
     * @param Session $session
     * @return Session
     */
    public function insert(Session $session): Session {
        $qb = $this->db->getQueryBuilder();
        $qb->insert($this->tableName)
            ->values([
                'id' => $qb->createNamedParameter($session->id),
                'user_id' => $qb->createNamedParameter($session->userId),
                'created_at' => $qb->createNamedParameter($session->createdAt),
                'last_activity' => $qb->createNamedParameter($session->lastActivity)
            ]);
        $qb->execute();
        return $session;
    }

    /**
     * Delete a session from the database
     *
     * @param Session $session
     * @return void
     */
    public function delete(Session $session): void {
        $qb = $this->db->getQueryBuilder();
        $qb->delete($this->tableName)
            ->where($qb->expr()->eq('id', $qb->createNamedParameter($session->id)));
        $qb->execute();
    }
}
