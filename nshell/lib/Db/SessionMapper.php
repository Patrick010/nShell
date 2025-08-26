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
}
