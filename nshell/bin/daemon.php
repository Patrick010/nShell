<?php

/**
 * nShell WebSocket Daemon
 *
 * This script is run from the command line to start the WebSocket server.
 */

// This assumes a Composer autoloader is available. If not, manual `require` statements
// for the library and our own classes would be needed.
require_once __DIR__ . '/../vendor/autoload.php';

use OCA\nShell\Service\ShellProcessManager;
use WebSocket\Server;
use WebSocket\Connection;

// --- Setup ---
$host = '127.0.0.1';
$port = 8080;

$processManager = new ShellProcessManager();
$server = new Server([
    'host' => $host,
    'port' => $port,
    'timeout' => 2, // Timeout in seconds to allow the loop to run
]);

echo "nShell WebSocket Daemon starting on ws://$host:$port\n";

// --- Main Loop ---
while (true) {
    // Check for new connections, messages, and disconnections
    $server->tick();

    // Handle new connections
    foreach ($server->getNewClients() as $client) {
        // The session ID is expected to be passed in the path, e.g., ws://.../nshell_xxxx
        $sessionId = trim($client->getPath(), '/');
        if (strpos($sessionId, 'nshell_') === 0) {
            echo "Client connected for session: $sessionId\n";
            // Here, we would validate the session against the database if needed
            // For now, we assume the session was created by the controller
            $processManager->startProcess($sessionId);
            $client->sessionId = $sessionId; // Tag the connection object with the session ID
        } else {
            echo "Invalid session ID in connection path. Closing connection.\n";
            $client->close();
        }
    }

    // Handle disconnected clients
    foreach ($server->getDisconnectedClients() as $client) {
        if (isset($client->sessionId)) {
            echo "Client disconnected for session: {$client->sessionId}\n";
            $processManager->stopProcess($client->sessionId);
        }
    }

    // Handle incoming messages
    foreach ($server->getChangedClients() as $client) {
        if (isset($client->sessionId)) {
            while ($message = $client->receive()) {
                $processManager->handleInput($client->sessionId, $message);
            }
        }
    }

    // Poll all active shell processes for output and send to clients
    foreach ($processManager->getActiveSessions() as $sessionId) {
        $output = $processManager->readOutput($sessionId);
        if (!empty($output)) {
            // Find the client associated with this session and send the output
            foreach ($server->getClients() as $client) {
                if (isset($client->sessionId) && $client->sessionId === $sessionId) {
                    $client->send($output);
                    break;
                }
            }
        }
    }

    // Small sleep to prevent pegging the CPU
    usleep(10000); // 10ms
}
