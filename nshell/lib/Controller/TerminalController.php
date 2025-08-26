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
            // Admins see the admin settings page
            return new TemplateResponse('nshell', 'admin', [], 'guest');
        }

        $allowedGroup = $this->configService->getAllowedGroup();
        if (!empty($allowedGroup) && $this->groupManager->isInGroup($user->getUID(), $allowedGroup)) {
            return new TemplateResponse('nshell', 'terminal');
        } else {
            return new TemplateResponse('nshell', 'not_allowed', [], 'guest');
        }
    }

    private function isAuthorized(IUserSession $userSession): bool {
        $user = $userSession->getUser();
        if ($user === null) {
            return false;
        }

        // Admin users are always authorized
        if ($this->groupManager->isAdmin($user->getUID())) {
            return true;
        }

        // Check if user is in the allowed group
        $allowedGroup = $this->configService->getAllowedGroup();
        if (!empty($allowedGroup) && $this->groupManager->isInGroup($user->getUID(), $allowedGroup)) {
            return true;
        }

        return false;
    }

    /**
     * @NoAdminRequired
     */
    public function start(): JSONResponse {
        if (!$this->isAuthorized($this->userSession)) {
            return new JSONResponse(['error' => 'Not authorized'], 403);
        }

        $user = $this->userSession->getUser();
        $session = $this->sessionManager->create($user->getUID());

        // Here we would also trigger the ShellProcessManager to start a process
        // For now, we just create the DB record.

        return new JSONResponse(['sessionId' => $session->id]);
    }

    /**
     * @NoAdminRequired
     */
    public function stop(string $sessionId): JSONResponse {
        if (!$this->isAuthorized($this->userSession)) {
            return new JSONResponse(['error' => 'Not authorized'], 403);
        }

        $user = $this->userSession->getUser();
        $session = $this->sessionManager->get($sessionId);
        if ($session === null || $session->userId !== $user->getUID()) {
            return new JSONResponse(['error' => 'Session not found or permission denied'], 404);
        }

        $this->sessionManager->delete($sessionId);

        // Here we would also trigger the ShellProcessManager to stop a process

        return new JSONResponse(['status' => 'success']);
    }
}
