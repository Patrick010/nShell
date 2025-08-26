<?php

declare(strict_types=1);

namespace OCA\nShell\Db;

use OCP\AppFramework\Db\Entity;

class Session extends Entity {
    /** @var string */
    public $id;
    /** @var string */
    public $userId;
    /** @var int */
    public $createdAt;
    /** @var int|null */
    public $lastActivity = null;

    public function __construct() {
        $this->addType('created_at', 'datetime');
        $this->addType('last_activity', 'datetime');
    }
}
