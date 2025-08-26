<?php

declare(strict_types=1);

namespace OCA\nShell\Service;

use Exception;

class ShellProcess {
    private $process;
    private array $pipes;
    private string $cwd;

    public function __construct(string $command = '/bin/bash', string $cwd = '/tmp') {
        $this->cwd = $cwd;
        $descriptorSpec = [
            0 => ['pipe', 'r'], // stdin
            1 => ['pipe', 'w'], // stdout
            2 => ['pipe', 'w'], // stderr
        ];

        $this->process = proc_open($command, $descriptorSpec, $this->pipes, $this->cwd);

        if (!is_resource($this->process)) {
            throw new Exception('Failed to open shell process.');
        }

        // Set pipes to non-blocking mode to prevent hanging
        stream_set_blocking($this->pipes[1], false);
        stream_set_blocking($this->pipes[2], false);
    }

    public function write(string $input): void {
        fwrite($this->pipes[0], $input);
    }

    public function read(): string {
        $output = '';
        $stdout = stream_get_contents($this->pipes[1]);
        if ($stdout !== false) {
            $output .= $stdout;
        }

        $stderr = stream_get_contents($this->pipes[2]);
        if ($stderr !== false) {
            $output .= $stderr;
        }

        return $output;
    }

    public function isRunning(): bool {
        if (!is_resource($this->process)) {
            return false;
        }
        $status = proc_get_status($this->process);
        return $status['running'];
    }

    public function close(): void {
        if (is_resource($this->process)) {
            fclose($this->pipes[0]);
            fclose($this->pipes[1]);
            fclose($this->pipes[2]);
            proc_close($this->process);
        }
    }
}
