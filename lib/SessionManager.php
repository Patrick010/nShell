<?php

/**
 * nShell Session Management
 *
 * @package nShell
 */

namespace nShell;

/**
 * Manages the lifecycle of user shell sessions.
 */
class SessionManager
{
    /**
     * @var array<string, mixed>
     */
    private array $sessions = [];

    private ShellLauncher $shellLauncher;

    public function __construct(ShellLauncher $shellLauncher)
    {
        $this->shellLauncher = $shellLauncher;
    }

    /**
     * Creates a new shell session.
     *
     * @return string|false The new session ID, or false on failure.
     */
    public function createSession(): string|false
    {
        $shell = $this->shellLauncher->launch();

        if ($shell === false) {
            return false;
        }

        $sessionId = uniqid('nshell_');
        $this->sessions[$sessionId] = $shell;

        return $sessionId;
    }

    /**
     * Gets a session by its ID.
     *
     * @param string $sessionId
     * @return array|null The session data, or null if not found.
     */
    public function getSession(string $sessionId): ?array
    {
        return $this->sessions[$sessionId] ?? null;
    }

    /**
     * Terminates a session by its ID.
     *
     * @param string $sessionId
     * @return bool True on success, false if session not found.
     */
    public function killSession(string $sessionId): bool
    {
        $session = $this->getSession($sessionId);
        if ($session === null) {
            return false;
        }

        // Close pipes
        fclose($session['pipes'][0]);
        fclose($session['pipes'][1]);
        fclose($session['pipes'][2]);

        // Terminate process
        proc_terminate($session['process']);
        proc_close($session['process']);

        unset($this->sessions[$sessionId]);

        return true;
    }
}
