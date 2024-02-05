<?php

namespace OpenCodeCo\Matrix;

class MatrixConfigProvider
{
    public function __invoke(): array
    {
        $basePath = $this->getBasePath();

        return [
            'commands' => [
            ],
            'dependencies' => [
            ],
            'listeners' => [
            ],
            'migrations' => [
                __DIR__ . '/../database/migrations/2024_02_03_000001_create_tenants_table.php',
            ],
            'publish' => [
                [
                    'id' => 'matrix-migration',
                    'description' => 'The migration for the Matrix library to create tenants table.',
                    'source' => __DIR__ . '/../database/migrations/2024_02_03_000001_create_tenants_table.php',
                    'destination' => $basePath . '/migrations/2024_02_03_000001_create_tenants_table.php',
                ],
            ],
        ];
    }

    protected function getBasePath(): string
    {
        return defined('BASE_PATH') ? BASE_PATH : dirname(__DIR__, 4);
    }
}
