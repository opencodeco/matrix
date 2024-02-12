<?php

namespace OpenCodeCo\Matrix;

use OpenCodeCo\Matrix\Console\Commands\PublishCommand;

class MatrixConfigProvider
{
    public function __invoke(): array
    {
        $basePath = $this->getBasePath();

        return [
            'commands' => [
                PublishCommand::class
            ],
            'dependencies' => [
            ],
            'listeners' => [
            ],
            'migrations' => [
                __DIR__ . '/../database/migrations/2024_02_03_000001_create_tenants_table.php',
            ],
            'publish' => [
            ],
        ];
    }

    protected function getBasePath(): string
    {
        return defined('BASE_PATH') ? BASE_PATH : dirname(__DIR__, 4);
    }
}
