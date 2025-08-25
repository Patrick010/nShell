<?php

namespace OCA\nShell\Controller;

use OCA\nShell\Service\ConfigService;
use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\JSONResponse;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\IGroupManager;
use OCP\IRequest;

class AdminController extends Controller {

    private ConfigService $configService;
    private IGroupManager $groupManager;

    public function __construct(
        string $appName,
        IRequest $request,
        ConfigService $configService,
        IGroupManager $groupManager
    ) {
        parent::__construct($appName, $request);
        $this->configService = $configService;
        $this->groupManager = $groupManager;
    }

    /**
     * @AdminRequired
     */
    public function index(): TemplateResponse {
        $allGroups = $this->groupManager->search('');
        $groupNames = array_map(function($group) {
            return $group->getGID();
        }, $allGroups);

        $params = [
            'groups' => $groupNames,
            'current_allowed_group' => $this->configService->getAllowedGroup()
        ];
        return new TemplateResponse('nshell', 'admin', $params);
    }

    /**
     * @AdminRequired
     */
    public function saveSettings(string $allowedGroup = ''): JSONResponse {
        $this->configService->setAllowedGroup($allowedGroup);
        return new JSONResponse(['status' => 'success', 'message' => 'Settings saved.']);
    }
}
