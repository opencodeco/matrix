<?php

namespace OpenCodeCo\Matrix\Model;

use Hyperf\Database\Model\Model;
use OpenCodeCo\Matrix\Model\Traits\UsesWardenConnection;

class Tenant extends Model
{
    use UsesWardenConnection;

    protected array $fillable = [
        'name',
        'domain',
        'database',
        'host',
        'port',
        'username',
        'password',
        'config',
    ];
}