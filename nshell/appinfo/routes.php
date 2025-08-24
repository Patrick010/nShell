<?php

return [
    'routes' => [
        // Page route
        ['name' => 'page#dispatch', 'url' => '/', 'verb' => 'GET'],

        // API routes
        ['name' => 'page#saveSettings', 'url' => '/settings', 'verb' => 'POST'],
        ['name' => 'page#createSession', 'url' => '/session', 'verb' => 'POST'],
        ['name' => 'page#handleIO', 'url' => '/session/{sessionId}/io', 'verb' => 'POST'],
    ]
];
