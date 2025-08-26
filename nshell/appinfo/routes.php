<?php

return [
    'routes' => [
        // User-facing terminal page
        ['name' => 'terminal#index', 'url' => '/terminal', 'verb' => 'GET'],

        // Admin save action
        ['name' => 'admin#saveGroup', 'url' => '/admin/save-group', 'verb' => 'POST'],

        // API routes for the terminal session
        ['name' => 'terminal#start', 'url' => '/start', 'verb' => 'POST'],
        ['name' => 'terminal#stop', 'url' => '/stop/{sessionId}', 'verb' => 'POST'],
    ]
];
