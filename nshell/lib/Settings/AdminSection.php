<?php

namespace OCA\nShell\Settings;

use OCP\Settings\IIconSection;
use OCP\IURLGenerator;

class AdminSection implements IIconSection {

    private IURLGenerator $urlGenerator;

    public function __construct(IURLGenerator $urlGenerator) {
        $this->urlGenerator = $urlGenerator;
    }

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
        return $this->urlGenerator->imagePath('nshell', 'app.svg');
    }
}
