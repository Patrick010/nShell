<?php

declare(strict_types=1);

namespace OCA\nShell\Db;

use OCP\AppFramework\Db\Entity;

class Session extends Entity {
    /** @var int */
    public $id;
    /** @var string */
    public $uid;
    /** @var string */
    public $sessionId;
    /** @var int */
    public $createdAt;
    /** @var int */
    public $expiresAt;
}
