<?php

namespace OCA\nShell\AppInfo;

use OCA\nShell\Controller\AdminController;
use OCA\nShell\Controller\TerminalController;
use OCA\nShell\Db\SessionMapper;
use OCA\nShell\Service\ConfigService;
use OCA\nShell\Service\SessionManager;
use OCA\nShell\Settings\AdminSection;
use OCA\nShell\Settings\AdminSettings;
use OCA\nShell\ShellLauncher;
use OCP\AppFramework\App;
use OCP\AppFramework\Bootstrap\IBootContext;
use OCP\AppFramework\Bootstrap\IBootstrap;
use OCP\AppFramework\Bootstrap\IRegistrationContext;
use OCP\IConfig;
use OCP\IDBConnection;
use OCP\IGroupManager;
use OCP\IURLGenerator;
use OCP\IUserSession;
use OCP\Util;

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
            return new ConfigService($c->get(IConfig::class));
        });
        $context->registerService(ShellLauncher::class, function ($c) {
            return new ShellLauncher();
        });
        $context->registerService(SessionMapper::class, function ($c) {
            return new SessionMapper($c->get(IDBConnection::class));
        });
        $context->registerService(SessionManager::class, function ($c) {
            return new SessionManager($c->get(SessionMapper::class));
        });

        // Controllers
        $context->registerService(AdminController::class, function ($c) {
            return new AdminController(
                $c->get('AppName'),
                $c->get('Request'),
                $c->get(ConfigService::class),
                $c->get(IURLGenerator::class),
                $c->get(IGroupManager::class)
            );
        });
        $context->registerService(TerminalController::class, function ($c) {
            return new TerminalController(
                $c->get('AppName'),
                $c->get('Request'),
                $c->get(IUserSession::class),
                $c->get(IGroupManager::class),
                $c->get(ConfigService::class),
                $c->get(SessionManager::class)
            );
        });

        // Settings
        $context->registerService(AdminSection::class, function ($c) {
            return new AdminSection($c->get(IURLGenerator::class));
        });
        $context->registerService(AdminSettings::class, function ($c) {
            return new AdminSettings(
                $c->get(ConfigService::class),
                $c->get(IGroupManager::class)
            );
        });
    }

    public function boot(IBootContext $context): void
    {
        // Load our JS and CSS with CSP nonce support
        Util::addScript('nshell', 'xterm');
        Util::addScript('nshell', 'terminal');
        Util::addStyle('nshell', 'xterm.min');
        Util::addStyle('nshell', 'terminal');
    }
}
