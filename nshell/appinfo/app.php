<?php

namespace OCA\nShell\AppInfo;

use OCA\nShell\Controller\PageController;
use OCP\AppFramework\App;
use OCP\AppFramework\Bootstrap\IBootContext;
use OCP\AppFramework\Bootstrap\IBootstrap;
use OCP\AppFramework\Bootstrap\IRegistrationContext;

class Application extends App implements IBootstrap
{
    public const APP_ID = 'nshell';

    public function __construct(array $urlParams = [])
    {
        parent::__construct(self::APP_ID, $urlParams);
    }

    public function register(IRegistrationContext $context): void
    {
        $context->registerService('PageController', function ($c) {
            return new PageController(
                $c->get('AppName'),
                $c->get('Request')
            );
        });
    }

    public function boot(IBootContext $context): void
    {
    }
}
