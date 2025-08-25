<?php

namespace OCA\nShell\Settings;

use OCP\AppFramework\Http\TemplateResponse;
use OCP\Settings\ISettings;

class AdminSettings implements ISettings {

    public function getForm(): TemplateResponse {
        return new TemplateResponse('nshell', 'admin');
    }

    public function getSection(): string {
        return 'nshell';
    }

    public function getPriority(): int {
        return 10;
    }
}
