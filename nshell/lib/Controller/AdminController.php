<?php

namespace OCA\nShell\Controller;

use OCA\nShell\Service\ConfigService;
use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\RedirectResponse;
use OCP\IRequest;
use OCP\IURLGenerator;

class AdminController extends Controller {

    private ConfigService $configService;
    private IURLGenerator $urlGenerator;

    public function __construct(
        string $appName,
        IRequest $request,
        ConfigService $configService,
        IURLGenerator $urlGenerator
    ) {
        parent::__construct($appName, $request);
        $this->configService = $configService;
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * @AdminRequired
     * @CSRFCheck
     */
    public function saveGroup(string $allowedGroup): RedirectResponse {
        $this->configService->setAllowedGroup($allowedGroup);
        $settingsUrl = $this->urlGenerator->getAbsoluteURL('/settings/admin/nshell');
        return new RedirectResponse($settingsUrl);
    }
}
