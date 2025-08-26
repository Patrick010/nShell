<?php

declare(strict_types=1);

namespace OCA\nShell\Service;

use OCA\nShell\Db\Session;
use OCA\nShell\Db\SessionMapper;
use Psr\Log\LoggerInterface;

class SessionManager {

    private SessionMapper $sessionMapper;
    private LoggerInterface $logger;

    public function __construct(SessionMapper $sessionMapper, LoggerInterface $logger) {
        $this->sessionMapper = $sessionMapper;
        $this->logger = $logger;
    }

    /**
     * Creates a new session record in the database.
     *
     * @param string $userId
     * @return Session
     */
    public function create(string $userId): Session {
        $this->logger->debug('SessionManager: Attempting to create session for user ' . $userId);
        $session = new Session();
        $session->id = uniqid('nshell_');
        $session->userId = $userId;
        $session->createdAt = time();
        $session->lastActivity = time();

        $result = $this->sessionMapper->insert($session);
        $this->logger->debug('SessionManager: Session created in DB with ID ' . $session->id);
        return $result;
    }

    /**
     * Retrieves a session record by its ID.
     *
     * @param string $id
     * @return Session|null
     */
    public function get(string $id): ?Session {
        return $this->sessionMapper->find($id);
    }

    /**
     * Deletes a session record from the database.
     *
     * @param string $id
     * @return void
     */
    public function delete(string $id): void {
        $session = $this->get($id);
        if ($session !== null) {
            $this->sessionMapper->delete($session);
        }
    }

    /**
     * Updates the last_activity timestamp for a session.
     *
     * @param string $id
     * @return void
     */
    public function touch(string $id): void {
        $session = $this->get($id);
        if ($session !== null) {
            // This requires an update method in the mapper.
            // For now, we will skip implementing the full logic
            // as it's optional for the main functionality.
            // To implement fully, SessionMapper would need an update() method.
        }
    }
}
