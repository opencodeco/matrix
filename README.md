# Matrix - Hyperf Multi-Tenant Library
Matrix is a comprehensive multi-tenant library designed to seamlessly integrate multi-tenancy into your Hyperf applications. It provides an easy-to-use and flexible system to manage multiple tenants, ensuring data isolation, dynamic database connection management, and tenant identification based on request parameters.

### 🌟 Features
- Dynamic Tenant Database Connections: Automatically switch database connections based on the identified tenant, ensuring that each tenant's data remains isolated and secure.
- Customizable Tenant Identification: Flexibly define how tenants are identified from incoming requests, whether by subdomain, path, headers, or other custom strategies.
- Extensible Architecture: Easily extend or override default behaviors with custom implementations, thanks to the library's use of Hyperf's dependency injection and configuration systems.
- Command for Publishing Migrations: Includes a command to publish necessary migrations to the application, making setup quick and straightforward.

### 🚀 Installation
To install Matrix, run the following command in the root of your Hyperf project:

```shell
composer require opencodeco/matrix
```
After installation, you should publish the default migrations provided by Matrix:

```shell
php bin/hyperf.php matrix:publish
```
This command copies necessary migration files to your project's `migrations` directory.

### Configuration
To fully integrate Matrix into your Hyperf project, you must register the `MatrixConfigProvider`. This step is essential as it configures the library's commands, dependencies, migrations, and any other necessary setup:

1. **Register the MatrixConfigProvider**: Add the `MatrixConfigProvider` to your project's configuration to load it automatically. This enables all features provided by Matrix, including dynamic tenant database connections and the command to publish migrations.

In `config/autoload/dependencies.php`, add the following line:
```php
\OpenCodeCo\Matrix\MatrixConfigProvider::class => \OpenCodeCo\Matrix\MatrixConfigProvider::class,
```
2. **Middleware Registration**: Register the `TenantMiddleware` in your application's middleware stack, typically in `config/autoload/middlewares.php`:

```php
return [
    'http' => [
        \OpenCodeCo\Matrix\Http\Middleware\TenantMiddleware::class,
    ],
];
```
### Usage
To use Matrix in your application, simply proceed with your business logic as usual. The library handles tenant identification and database connection switching automatically based on your configuration.

Ensure that your tenant-specific models use the dynamic tenant connection, which Matrix configures based on the identified tenant:
```php
namespace App\Model;

use Hyperf\DbConnection\Model\Model;
use OpenCodeCo\Matrix\Model\Traits\UsesTenantConnection;

class YourTenantModel extends Model
{
    use UsesTenantConnection;
}
```

### Customizing Tenant Identification
To customize how tenants are identified, implement your own `TenantFinderInterface` and specify it in the `config/autoload/matrix.php` configuration file. Your custom finder should return the tenant identifier based on the request, which Matrix will use to configure the database connection.

### Contributing
Contributions are welcome! Please feel free to submit pull requests or create issues for bugs, questions, and feature requests.
