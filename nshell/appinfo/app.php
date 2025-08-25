<?php

namespace OCA\nShell\AppInfo;

use OCA\nShell\Controller\AdminController;
use OCA\nShell\Controller\TerminalController;
use OCA\nShell\Logger;
use OCA\nShell\SessionManager;
use OCA\nShell\ShellLauncher;
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
        $context->registerService('Logger', function ($c) {
            $logFile = sys_get_temp_dir() . '/nshell.log';
            return new Logger($logFile);
        });
        $context->registerService('ShellLauncher', function ($c) {
            return new ShellLauncher();
        });
        $context->registerService('SessionManager', function ($c) {
            return new SessionManager($c->get('ShellLauncher'));
        });

        $context->registerService('AdminController', function ($c) {
            return new AdminController(
                $c->get('AppName'),
                $c->get('Request'),
                $c->get('Logger')
            );
        });
        $context->registerService('TerminalController', function ($c) {
            return new TerminalController(
                $c->get('AppName'),
                $c->get('Request'),
                $c->get('SessionManager')
            );
        });

        $context->registerService('OCA\nShell\Settings\AdminSection', function ($c) {
            return new \OCA\nShell\Settings\AdminSection();
        });

        $context->registerService('OCA\nShell\Settings\AdminSettings', function ($c) {
            return new \OCA\nShell\Settings\AdminSettings();
        });
    }

    public function boot(IBootContext $context): void
    {
    }
}
