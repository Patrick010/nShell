<?php

return [
    'routes' => [
        // User-facing terminal page
        ['name' => 'terminal#index', 'url' => '/terminal', 'verb' => 'GET'],

        // Admin save action
        ['name' => 'admin#saveGroup', 'url' => '/admin/save-group', 'verb' => 'POST'],

        // API routes for the terminal session
        ['name' => 'terminal#createSession', 'url' => '/session', 'verb' => 'POST'],
        ['name' => 'terminal#handleIO', 'url' => '/session/{sessionId}/io', 'verb' => 'POST'],
    ]
];
