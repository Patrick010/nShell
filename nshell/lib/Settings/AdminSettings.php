<?php

namespace OCA\nShell\Settings;

use OCP\AppFramework\Http\TemplateResponse;
use OCP\Settings\ISettings;

class AdminSettings implements ISettings {

    /**
     * @return TemplateResponse
     */
    public function getForm(): TemplateResponse {
        // The 'admin' template is the settings page
        return new TemplateResponse('nshell', 'admin');
    }

    /**
     * @return string
     */
    public function getSection(): string {
        // The ID of the section we want to add the settings panel to
        return 'nshell';
    }

    /**
     * @return int
     */
    public function getPriority(): int {
        // Show this as the first/only item in our section
        return 10;
    }
}
