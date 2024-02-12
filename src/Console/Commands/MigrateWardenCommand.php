<?php

namespace OpenCodeCo\Matrix\Console\Commands;

use Hyperf\Command\Command as HyperfCommand;

class MigrateWardenCommand extends HyperfCommand
{
    protected ?string $name = 'migrate:warden';

    public function handle()
    {
        if (!defined('BASE_PATH')) {
            define('BASE_PATH', __DIR__);
        }

        $migrationsPath = BASE_PATH . '/migrations/warden';
        $this->call('migrate', ['--path' => $migrationsPath]);
    }
}