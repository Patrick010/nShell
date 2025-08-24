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

class PageController extends Controller {

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
    public function dispatch(): TemplateResponse {
        $user = $this->userSession->getUser();
        $isAdmin = $this->groupManager->isAdmin($user->getUID());

        if ($isAdmin) {
            $allGroups = $this->groupManager->search('');
            $groupNames = array_map(function($group) {
                return $group->getGID();
            }, $allGroups);

            $params = [
                'groups' => $groupNames,
                'current_allowed_group' => $this->configService->getAllowedGroup()
            ];
            return new TemplateResponse('nshell', 'admin', $params);
        } else {
            $allowedGroup = $this->configService->getAllowedGroup();
            if ($allowedGroup && $this->groupManager->isInGroup($user, $allowedGroup)) {
                return new TemplateResponse('nshell', 'terminal');
            } else {
                return new TemplateResponse('nshell', 'not_allowed', [], 'guest');
            }
        }
    }

    /**
     * @NoAdminRequired
     * @NoCSRFRequired
     */
    public function saveSettings(string $allowedGroup = ''): TemplateResponse {
        // A simple controller method to handle the form submission from the admin page.
        // In a real app, this would have more robust validation and error handling.
        $this->configService->setAllowedGroup($allowedGroup);
        return $this->dispatch(); // Redisplay the page with updated settings
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
