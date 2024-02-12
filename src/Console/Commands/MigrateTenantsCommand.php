<?php

namespace OpenCodeCo\Matrix\Console\Commands;

use Hyperf\Command\Annotation\Command;
use Hyperf\Command\Command as HyperfCommand;
use Hyperf\DbConnection\Db;
use OpenCodeCo\Matrix\Model\Tenant;
use Psr\Container\ContainerInterface;

/**
 * @Command
 */
class MigrateTenantsCommand extends HyperfCommand
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        parent::__construct('migrate:tenants');
        $this->container = $container;
        $this->setDescription('Run migrations for each tenant');
    }

    public function configure()
    {
        parent::configure();
    }

    public function handle()
    {
        $tenants = Tenant::all();

        if (!defined('BASE_PATH')) {
            define('BASE_PATH', __DIR__);
        }

        foreach ($tenants as $tenant) {
            $this->configureTenantDatabase($tenant);

            $this->info("Migrating tenant: {$tenant->id}");
            $this->call('migrate', [
                '--database' => 'tenant',
                '--path' => BASE_PATH . '/migrations/tenants',
            ]);

        }

        $this->resetToDefaultConnection();
    }

    protected function configureTenantDatabase($tenant): void
    {
        $config = [
            'driver' => 'mysql',
            'host' => $tenant->db_host,
            'database' => $tenant->db_database,
            'username' => $tenant->db_username,
            'password' => $tenant->db_password,
        ];

        config(['database.connections.tenant' => $config]);
        Db::setDefaultConnection('tenant');
    }

    protected function resetToDefaultConnection(): void
    {
        Db::setDefaultConnection('default');
        $this->info("Reset connection to default.");
    }
}

