<?php

declare(strict_types=1);

namespace OCA\nShell\Db;

use OCP\AppFramework\Db\Entity;
use OCP\DB\Types;

class Session extends Entity {
    protected $uid;
    protected $sessionId;
    protected $createdAt;
    protected $expiresAt;

    public function __construct() {
        $this->addType('created_at', Types::INTEGER);
        $this->addType('expires_at', Types::INTEGER);
    }
}
