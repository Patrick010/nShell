<?php

declare(strict_types=1);

namespace OCA\nShell\Db;

use OCP\AppFramework\Db\Entity;

class Session extends Entity {
    public string $id;
    public string $userId;
    public int $createdAt;
    public ?int $lastActivity = null;

    public function __construct() {
        $this->addType('created_at', 'datetime');
        $this->addType('last_activity', 'datetime');
    }
}
