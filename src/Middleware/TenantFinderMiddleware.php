<?php

/**
 * Middleware for finding and setting the tenant connection in a multi-tenant application.
 *
 * This middleware is responsible for locating the appropriate tenant based on the incoming HTTP request and setting the database connection for the current request to the corresponding tenant's connection.
 *
 * @package OpenCodeCo\Matrix\Middleware
 */
namespace OpenCodeCo\Matrix\Middleware;

use OpenCodeCo\Matrix\Exceptions\TenantNotFoundException;
use Hyperf\Contract\ConfigInterface;
use OpenCodeCo\Matrix\Tenant\DefaultTenantFinder;
use OpenCodeCo\Matrix\Tenant\TenantFinderInterface;
use Hyperf\Contract\ContainerInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use OpenCodeCo\Matrix\Tenant\TenantManager;

class TenantFinderMiddleware implements MiddlewareInterface
{
    /**
     * TenantFinderMiddleware constructor.
     *
     * @param TenantManager $tenantManager The tenant manager responsible for managing tenant connections.
     * @param ConfigInterface $config The configuration interface for retrieving tenant-related settings.
     */
    public function __construct(
        private TenantManager $tenantManager,
        private ContainerInterface $container,
    ) {
    }

    /**
     * Process the incoming HTTP request, set the tenant connection, and continue with the request handling.
     *
     * @param ServerRequestInterface $request The incoming HTTP request.
     * @param RequestHandlerInterface $handler The request handler.
     * @return ResponseInterface The response to the HTTP request.
     * @throws TenantNotFoundException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        /** @var TenantFinderInterface $finder */
        $finder = $this->container->get(TenantFinderInterface::class);

        $tenantId = $finder->findTenantId($request);
        $this->tenantManager->setTenantConnection($tenantId);
        return $handler->handle($request);
    }
}
