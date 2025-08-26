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


}
