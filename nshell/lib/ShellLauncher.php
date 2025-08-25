<?php

/**
 * nShell Shell Launcher
 *
 * @package nShell
 */

namespace nShell;

/**
 * Prepares and launches the shell process.
 */
class ShellLauncher
{
    /**
     * Launches a shell process.
     *
     * @param string $command The shell command to execute.
     * @param array $env Environment variables for the command.
     * @return array|false An array containing the process resource and pipes, or false on failure.
     */
    public function launch(string $command = '/bin/sh', array $env = []): array|false
    {
        $descriptorSpec = [
            0 => ['pipe', 'r'], // stdin
            1 => ['pipe', 'w'], // stdout
            2 => ['pipe', 'w'], // stderr
        ];

        $pipes = [];
        $process = proc_open($command, $descriptorSpec, $pipes, null, $env);

        if (is_resource($process)) {
            return [
                'process' => $process,
                'pipes' => $pipes,
            ];
        }

        return false;
    }
}
