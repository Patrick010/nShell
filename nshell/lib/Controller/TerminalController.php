<?php

namespace OCA\nShell\Controller;

use OCA\nShell\Service\ConfigService;
use OCA\nShell\SessionManager;
use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\JSONResponse;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\IGroupManager;
use OCP\IRequest;
use OCP\IUserSession;

class TerminalController extends Controller {

    private IUserSession $userSession;
    private IGroupManager $groupManager;
    private ConfigService $configService;
    private SessionManager $sessionManager;

    public function __construct(
        string $appName,
        IRequest $request,
        IUserSession $userSession,
        IGroupManager $groupManager,
        ConfigService $configService,
        SessionManager $sessionManager
    ) {
        parent::__construct($appName, $request);
        $this->userSession = $userSession;
        $this->groupManager = $groupManager;
        $this->configService = $configService;
        $this->sessionManager = $sessionManager;
    }

    /**
     * @NoAdminRequired
     * @NoCSRFRequired
     */
    public function index(): TemplateResponse {
        $user = $this->userSession->getUser();
        $isAdmin = $this->groupManager->isAdmin($user->getUID());

        if ($isAdmin) {
            // Admins should use the admin settings page to get a terminal
            return new TemplateResponse('nshell', 'admin_terminal_info', [], 'guest');
        }

        $allowedGroup = $this->configService->getAllowedGroup();
        if (!empty($allowedGroup) && $this->groupManager->isInGroup($user->getUID(), $allowedGroup)) {
            return new TemplateResponse('nshell', 'terminal');
        } else {
            return new TemplateResponse('nshell', 'not_allowed', [], 'guest');
        }
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
            return new JSONResponse(['status' => 'error', 'message' => 'Session not found', 'output' => 'Error: Session not found.'], 404);
        }

        $stdin = $session['pipes'][0];
        $stdout = $session['pipes'][1];

        if (!empty($input)) {
            fwrite($stdin, $input);
        }

        stream_set_blocking($stdout, false);
        $output = '';
        while ($line = fgets($stdout)) {
            $output .= $line;
        }

        return new JSONResponse(['status' => 'success', 'output' => $output]);
    }
}
