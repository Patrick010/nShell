<?php

namespace OCA\nShell\Settings;

use OCP\Settings\IIconSection;

class AdminSection implements IIconSection {

    /**
     * @return string
     */
    public function getID(): string {
        return 'nshell'; // The ID of our settings section
    }

    /**
     * @return string
     */
    public function getName(): string {
        return 'nShell'; // The name of the section
    }

    /**
     * @return int
     */
    public function getPriority(): int {
        return 50; // A middle priority
    }

    /**
     * @return string|null
     */
    public function getIcon(): ?string {
        // No icon for now
        return null;
    }
}
