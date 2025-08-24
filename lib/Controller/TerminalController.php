<?php

namespace nShell\Controller;

use nShell\SessionManager;
use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\JSONResponse;
use OCP\IRequest;

class TerminalController extends Controller {

    private SessionManager $sessionManager;

    public function __construct(
        string $appName,
        IRequest $request,
        SessionManager $sessionManager
    ) {
        parent::__construct($appName, $request);
        $this->sessionManager = $sessionManager;
    }

    /**
     * @NoAdminRequired
     * @NoCSRFRequired
     */
    public function createSession(): JSONResponse {
        // Logic to create a session will go here.
        return new JSONResponse(['status' => 'success', 'message' => 'Session creation placeholder']);
    }

    /**
     * @NoAdminRequired
     * @NoCSRFRequired
     */
    public function handleIO(string $sessionId, string $input): JSONResponse {
        // Logic to handle input/output will go here.
        return new JSONResponse(['status' => 'success', 'output' => 'IO placeholder for ' . $sessionId]);
    }
}
