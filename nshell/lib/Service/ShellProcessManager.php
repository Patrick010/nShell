<?php

declare(strict_types=1);

namespace OCA\nShell\Service;

use Exception;

class ShellProcessManager {
    /**
     * @var ShellProcess[]
     */
    private array $processes = [];

    public function startProcess(string $sessionId): void {
        if (isset($this->processes[$sessionId])) {
            throw new Exception("Session already exists: $sessionId");
        }
        // For now, hardcode the shell. This will be configurable later.
        $this->processes[$sessionId] = new ShellProcess('/bin/rbash');
    }

    public function stopProcess(string $sessionId): void {
        if (isset($this->processes[$sessionId])) {
            $this->processes[$sessionId]->close();
            unset($this->processes[$sessionId]);
        }
    }

    public function getProcess(string $sessionId): ?ShellProcess {
        return $this->processes[$sessionId] ?? null;
    }

    public function handleInput(string $sessionId, string $input): void {
        $process = $this->getProcess($sessionId);
        if ($process === null) {
            throw new Exception("Process not found for session: $sessionId");
        }
        $process->write($input);
    }

    public function readOutput(string $sessionId): string {
        $process = $this->getProcess($sessionId);
        if ($process === null) {
            throw new Exception("Process not found for session: $sessionId");
        }
        return $process->read();
    }

    public function getActiveSessions(): array {
        return array_keys($this->processes);
    }

    public function cleanup(): void {
        foreach ($this->processes as $sessionId => $process) {
            if (!$process->isRunning()) {
                $this->stopProcess($sessionId);
            }
        }
    }
}
