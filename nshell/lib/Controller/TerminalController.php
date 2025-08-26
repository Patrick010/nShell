<?php

namespace OCA\nShell\Controller;

use OCA\nShell\Service\ConfigService;
use OCA\nShell\Service\SessionManager;
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
     */
    public function start(): JSONResponse {
        $user = $this->userSession->getUser();
        if ($user === null) {
            return new JSONResponse(['error' => 'User not logged in'], 401);
        }
        $session = $this->sessionManager->create($user->getUID());

        // Here we would also trigger the ShellProcessManager to start a process
        // For now, we just create the DB record.

        return new JSONResponse(['sessionId' => $session->id]);
    }

    /**
     * @NoAdminRequired
     */
    public function stop(string $sessionId): JSONResponse {
        $user = $this->userSession->getUser();
        if ($user === null) {
            return new JSONResponse(['error' => 'User not logged in'], 401);
        }

        $session = $this->sessionManager->get($sessionId);
        if ($session === null || $session->userId !== $user->getUID()) {
            return new JSONResponse(['error' => 'Session not found or permission denied'], 404);
        }

        $this->sessionManager->delete($sessionId);

        // Here we would also trigger the ShellProcessManager to stop a process

        return new JSONResponse(['status' => 'success']);
    }
}
