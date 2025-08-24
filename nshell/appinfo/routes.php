<?php

return [
    'routes' => [
        // Page routes
        ['name' => 'terminal#index', 'url' => '/', 'verb' => 'GET'],
        ['name' => 'admin#index', 'url' => '/settings', 'verb' => 'GET'],

        // API routes
        ['name' => 'terminal#createSession', 'url' => '/session', 'verb' => 'POST'],
        ['name' => 'terminal#handleIO', 'url' => '/session/{sessionId}/io', 'verb' => 'POST'],
        ['name' => 'admin#saveSettings', 'url' => '/settings', 'verb' => 'POST'],
    ]
];
