<?php

declare(strict_types=1);

namespace OCA\nShell\Db;

class Session {
    private string $uid;
    private string $sessionId;
    private int $createdAt;
    private int $expiresAt;

    public function __construct(string $uid, string $sessionId, int $createdAt, int $expiresAt) {
        $this->uid = $uid;
        $this->sessionId = $sessionId;
        $this->createdAt = $createdAt;
        $this->expiresAt = $expiresAt;
    }

    public function getUid(): string {
        return $this->uid;
    }

    public function getSessionId(): string {
        return $this->sessionId;
    }

    public function getCreatedAt(): int {
        return $this->createdAt;
    }

    public function getExpiresAt(): int {
        return $this->expiresAt;
    }
}
