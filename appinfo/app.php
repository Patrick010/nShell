<?php

namespace OCA\nShell\AppInfo;

use OCP\AppFramework\App;
use OCP\AppFramework\Bootstrap\IBootable;
use OCP\AppFramework\Bootstrap\IBootstrap;
use OCP\AppFramework\Bootstrap\IRegistrationContext;

class Application extends App implements IBootstrap, IBootable
{
    public const APP_ID = 'nshell';

    public function __construct(array $urlParams = [])
    {
        parent::__construct(self::APP_ID, $urlParams);
    }

    public function register(IRegistrationContext $context): void
    {
        // Register services, navigation, and scripts here in later phases.
    }

    public function boot(IBootable $app): void
    {
        // Run any boot-time logic here.
    }
}
