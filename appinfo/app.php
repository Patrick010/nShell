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
        $context->registerService('ShellLauncher', function ($c) {
            return new \nShell\ShellLauncher();
        });

        $context->registerService('SessionManager', function ($c) {
            return new \nShell\SessionManager(
                $c->get('ShellLauncher')
            );
        });

        $context->registerService('TerminalController', function ($c) {
            return new \nShell\Controller\TerminalController(
                $c->get('AppName'),
                $c->get('Request'),
                $c->get('SessionManager')
            );
        });

        $context->registerService('Logger', function ($c) {
            // In a real app, this path would come from config
            $logFile = sys_get_temp_dir() . '/nshell.log';
            return new \nShell\Logger($logFile);
        });

        $context->registerService('AdminController', function ($c) {
            return new \nShell\Controller\AdminController(
                $c->get('AppName'),
                $c->get('Request'),
                $c->get('Logger')
            );
        });
    }

    public function boot(IBootable $app): void
    {
        // Run any boot-time logic here.
    }
}
