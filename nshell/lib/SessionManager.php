<?php

namespace OCA\nShell;

class SessionManager
{
    private array $sessions = [];
    private ShellLauncher $shellLauncher;

    public function __construct(ShellLauncher $shellLauncher)
    {
        $this->shellLauncher = $shellLauncher;
    }

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

    public function getSession(string $sessionId): ?array
    {
        return $this->sessions[$sessionId] ?? null;
    }

    public function killSession(string $sessionId): bool
    {
        $session = $this->getSession($sessionId);
        if ($session === null) {
            return false;
        }

        fclose($session['pipes'][0]);
        fclose($session['pipes'][1]);
        fclose($session['pipes'][2]);

        proc_terminate($session['process']);
        proc_close($session['process']);

        unset($this->sessions[$sessionId]);

        return true;
    }
}
