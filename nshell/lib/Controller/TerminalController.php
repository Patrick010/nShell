<?php

namespace OCA\nShell\Controller;

use OCA\nShell\SessionManager;
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
        $sessionId = $this->sessionManager->createSession();
        if ($sessionId) {
            return new JSONResponse(['status' => 'success', 'sessionId' => $sessionId]);
        }
        return new JSONResponse(['status' => 'error', 'message' => 'Failed to create session'], 500);
    }

    /**
     * @NoAdminRequired
     * @NoCSRFRequired
     */
    public function handleIO(string $sessionId, string $input = ''): JSONResponse {
        $session = $this->sessionManager->getSession($sessionId);
        if ($session === null) {
            return new JSONResponse(['status' => 'error', 'message' => 'Session not found'], 404);
        }

        $stdin = $session['pipes'][0];
        $stdout = $session['pipes'][1];

        // Write user input to the shell's stdin
        if (!empty($input)) {
            fwrite($stdin, $input);
        }

        // Set the stdout stream to be non-blocking
        stream_set_blocking($stdout, false);

        // Read any output from the shell
        $output = '';
        while ($line = fgets($stdout)) {
            $output .= $line;
        }

        return new JSONResponse(['status' => 'success', 'output' => $output]);
    }
}
