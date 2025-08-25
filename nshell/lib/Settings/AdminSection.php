<?php

namespace OCA\nShell\Settings;

use OCP\Settings\IIconSection;

class AdminSection implements IIconSection {

    public function getID(): string {
        return 'nshell';
    }

    public function getName(): string {
        return 'nShell';
    }

    public function getPriority(): int {
        return 50;
    }

    public function getIcon(): ?string {
        return null;
    }
}
