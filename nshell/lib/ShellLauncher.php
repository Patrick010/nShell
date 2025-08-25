<?php

namespace OCA\nShell;

class ShellLauncher
{
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
