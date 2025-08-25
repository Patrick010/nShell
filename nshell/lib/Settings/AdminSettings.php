<?php

namespace OCA\nShell\Settings;

use OCA\nShell\Service\ConfigService;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\IGroupManager;
use OCP\Settings\ISettings;

class AdminSettings implements ISettings {

    private ConfigService $configService;
    private IGroupManager $groupManager;

    public function __construct(ConfigService $configService, IGroupManager $groupManager) {
        $this->configService = $configService;
        $this->groupManager = $groupManager;
    }

    public function getForm(): TemplateResponse {
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

    public function getSection(): string {
        return 'nshell';
    }

    public function getPriority(): int {
        return 10;
    }
}
