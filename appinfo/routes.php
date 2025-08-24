<?php

return [
    'routes' => [
        // The name is generated from the controller name and the method name
        ['name' => 'terminal#createSession', 'url' => '/session', 'verb' => 'POST'],
        ['name' => 'terminal#handleIO', 'url' => '/session/{sessionId}/io', 'verb' => 'POST'],
    ]
];
