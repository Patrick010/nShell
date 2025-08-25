<?php

namespace OCA\nShell\Settings;

use OCP\AppFramework\Http\TemplateResponse;
use OCP\Settings\ISettings;
use OCA\nShell\Controller\AdminController;

class AdminSettings implements ISettings {

    private AdminController $adminController;

    public function __construct(AdminController $adminController) {
        $this->adminController = $adminController;
    }

    public function getForm(): TemplateResponse {
        return $this->adminController->index();
    }

    public function getSection(): string {
        return 'nshell';
    }

    public function getPriority(): int {
        return 10;
    }
}
