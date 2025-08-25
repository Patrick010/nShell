<?php

namespace OCA\nShell\AppInfo;

use OCA\nShell\Controller\PageController;
use OCA\nShell\Service\ConfigService;
use OCA\nShell\SessionManager;
use OCA\nShell\ShellLauncher;
use OCP\AppFramework\App;
use OCP\AppFramework\Bootstrap\IBootContext;
use OCP\AppFramework\Bootstrap\IBootstrap;
use OCP\AppFramework\Bootstrap\IRegistrationContext;
use OCP\IConfig;
use OCP\IGroupManager;
use OCP\IUserSession;

class Application extends App implements IBootstrap
{
    public const APP_ID = 'nshell';

    public function __construct(array $urlParams = [])
    {
        parent::__construct(self::APP_ID, $urlParams);
    }

    public function register(IRegistrationContext $context): void
    {
        // Services
        $context->registerService(ConfigService::class, function ($c) {
            return new ConfigService(
                $c->get(IConfig::class)
            );
        });
        $context->registerService(ShellLauncher::class, function ($c) {
            return new ShellLauncher();
        });
        $context->registerService(SessionManager::class, function ($c) {
            return new SessionManager(
                $c->get(ShellLauncher::class)
            );
        });

        // Controllers
        $context->registerService(PageController::class, function ($c) {
            return new PageController(
                $c->get('AppName'),
                $c->get('Request'),
                $c->get(IUserSession::class),
                $c->get(IGroupManager::class),
                $c->get(ConfigService::class),
                $c->get(SessionManager::class)
            );
        });
    }

    public function boot(IBootContext $context): void
    {
    }
}
