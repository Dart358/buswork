<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Filters extends BaseConfig
{
    public $aliases = [
        'csrf'     => \CodeIgniter\Filters\CSRF::class,
        'toolbar'  => \CodeIgniter\Filters\DebugToolbar::class,
        'honeypot' => \CodeIgniter\Filters\Honeypot::class,
        'cors'     => \App\Filters\Cors::class,
        'jwt'      => \App\Filters\JwtAuthGuard::class,
        'admin'    => \App\Filters\AdminGuard::class,
    ];

    public $globals = [
        'before' => [
            'cors',
        ],
        'after'  => [
            'toolbar',
        ],
    ];

    public $methods = [];

    public $filters = [
     
        'jwt' => ['before' => ['auth/logout', 'auth/me', 'bus/*', 'orders/*']],
        'admin' => ['before' => [
            'bus/createNewBus',
            'bus/getAllConductors',
            'bus/getConductorById',
            'bus/createNewConductor',
            'bus/removeConductor',
            'bus/getAllContractors',
            'bus/getContractorById',
            'bus/createNewContractor',
            'bus/removeContractor',
            'bus/createNewSchedule',
            'bus/admin-protected'
        ]]
    ];
}
