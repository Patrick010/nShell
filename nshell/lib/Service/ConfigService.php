<?php

namespace OCA\nShell\Service;

use OCP\IConfig;

class ConfigService {

    private IConfig $config;
    private const APP_NAME = 'nshell';

    public function __construct(IConfig $config) {
        $this->config = $config;
    }

    public function setAllowedGroup(string $groupName): void {
        $this->config->setAppValue(self::APP_NAME, 'allowed_group', $groupName);
    }

    public function getAllowedGroup(): string {
        return $this->config->getAppValue(self::APP_NAME, 'allowed_group', '');
    }
}
