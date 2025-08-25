<?php

return [
    'routes' => [
        // The name is generated from the controller name and the method name
        // Page routes
        ['name' => 'terminal#index', 'url' => '/terminal', 'verb' => 'GET'],

        // API routes
        ['name' => 'terminal#createSession', 'url' => '/session', 'verb' => 'POST'],
        ['name' => 'terminal#handleIO', 'url' => '/session/{sessionId}/io', 'verb' => 'POST'],
        ['name' => 'admin#saveSettings', 'url' => '/settings', 'verb' => 'POST'],
    ]
];
