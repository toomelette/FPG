<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the database connections below you wish
    | to use as your default connection for all database work. Of course
    | you may use many connections at once using the Database library.
    |
    */

    'default' => env('DB_CONNECTION', 'mysql'),

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the database connections setup for your application.
    | Of course, examples of configuring each database platform that is
    | supported by Laravel is shown below to make development simple.
    |
    |
    | All database work in Laravel is done through the PHP PDO facilities
    | so make sure you have the driver for your particular database of
    | choice installed on your machine before you begin development.
    |
    */

    'connections' => [

//        'sqlite' => [
//            'driver' => 'sqlite',
//            'database' => env('DB_DATABASE', database_path('database.sqlite')),
//            'prefix' => '',
//        ],
//
        'mysql' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => false,
            'engine' => null,
        ],

        'afd_qc' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => 'afd_qc',
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => false,
            'engine' => null,
        ],

        'mysql_records_qc' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => 'records_qc',
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => false,
            'engine' => null,
        ],

        'mysql_ppu' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST_PPU', '127.0.0.1'),
            'port' => env('DB_PORT_PPU', '3306'),
            'database' => env('DB_DATABASE_PPU', 'forge'),
            'username' => env('DB_USERNAME_PPU', env('DB_USERNAME')),
            'password' => env('DB_PASSWORD_PPU', env('DB_PASSWORD')),
            'unix_socket' => env('DB_SOCKET_PPU', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => false,
            'engine' => null,
        ],
        'mysql_ppu_vis' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST_PPU', '127.0.0.1'),
            'port' => env('DB_PORT_PPU', '3306'),
            'database' => 'swep_ppu_vis',
            'username' => env('DB_USERNAME_PPU', env('DB_USERNAME')),
            'password' => env('DB_PASSWORD_PPU', env('DB_PASSWORD')),
            'unix_socket' => env('DB_SOCKET_PPU', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => false,
            'engine' => null,
        ],

        'mysql_temp' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST_PPU', '127.0.0.1'),
            'port' => env('DB_PORT_PPU', '3306'),
            'database' => 'temp',
            'username' => env('DB_USERNAME_PPU', 'forge'),
            'password' => env('DB_PASSWORD_PPU', ''),
            'unix_socket' => env('DB_SOCKET_PPU', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => false,
            'engine' => null,
        ],

        'mysql_sida' => [
            'driver' => 'mysql',
            'host' => 'localhost',
            'port' => '3306',
            'database' => 'sida_sys',
            'username' => 'root',
            'password' => 'misvis',
            'unix_socket' => env('DB_SOCKET_PPU', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => false,
            'engine' => null,
        ],

        'server5' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST_SERVER5', '10.36.1.14'),
            'port' => env('DB_PORT_SERVER5', '3306'),
            'database' => env('DB_DATABASE_SERVER5', 'swep_afd'),
            'username' => env('DB_USERNAME_SERVER5', 'root'),
            'password' => env('DB_PASSWORD_SERVER5', 'P@ssw0rd:mssius@server7@misvis'),
            'unix_socket' => env('DB_SOCKET_SERVER5', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => false,
            'engine' => null,
        ],

        'server5_ppu' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST_SERVER5', '10.36.1.14'),
            'port' => env('DB_PORT_SERVER5', '3306'),
            'database' => 'swep_ppu',
            'username' => env('DB_USERNAME_SERVER5', 'root'),
            'password' => env('DB_PASSWORD_SERVER5', 'P@ssw0rd:mssius@server7@misvis'),
            'unix_socket' => env('DB_SOCKET_SERVER5', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => false,
            'engine' => null,
        ],

        'swep_bcd' => [
            'driver' => 'mysql',
            'host' => '119.93.145.202',
            'port' => '1987',
            'database' =>'swep_afd',
            'username' => 'root',
            'password' =>'P@ssword:mssius@server5@misvis',
            'unix_socket' => env('DB_SOCKET_SERVER5', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => false,
            'engine' => null,
        ],

        'slave' => [
//            'read' => [
//                'host' => env('DB_HOST', '127.0.0.1'),
//                'port' => env('DB_PORT', '3306'),
//                'username' => env('DB_USERNAME', 'forge'),
//                'password' => env('DB_PASSWORD', ''),
//            ],
//            'write' => [
//                'host' => '119.93.145.202',
//                'port' => '1987',
//                'username' => 'root',
//                'password' =>'P@ssword:mssius@server5@misvis',
//            ],
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'driver' => 'mysql',
            'database' =>'swep_afd_bcd',
            'unix_socket' => env('DB_SOCKET_SERVER5', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => false,
            'engine' => null,
        ],

        'swep_bridge' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST_BRIDGE', ''),
            'port' => env('DB_PORT_BRIDGE', '3306'),
            'database' => env('DB_DATABASE_BRIDGE', 'forge'),
            'username' => env('DB_USERNAME_BRIDGE', 'forge'),
            'password' => env('DB_PASSWORD_BRIDGE', ''),
            'unix_socket' => env('DB_SOCKET_CLOUD', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => false,
            'engine' => null,
        ],

        'mysql_qc_server' => [
            'driver' => 'mysql',
            'host' => '143.68.29.202',
            'port' => '3306',
            'database' => 'swep_afd',
            'username' => 'remoteUser',
            'password' => 'mysql@serverqc',
            'unix_socket' => env('DB_SOCKET_CLOUD', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => false,
            'engine' => null,
        ],

//        'pgsql' => [
//            'driver' => 'pgsql',
//            'host' => env('DB_HOST', '127.0.0.1'),
//            'port' => env('DB_PORT', '5432'),
//            'database' => env('DB_DATABASE', 'forge'),
//            'username' => env('DB_USERNAME', 'forge'),
//            'password' => env('DB_PASSWORD', ''),
//            'charset' => 'utf8',
//            'prefix' => '',
//            'schema' => 'public',
//            'sslmode' => 'prefer',
//        ],

        'sqlsrv' => [
            'driver' => 'sqlsrv',
            'host' => env('DB_HOST_MSSQL_GASS', 'localhost'),
            'database' => env('DB_DATABASE_MSSQL_GASS', 'forge'),
            'username' => env('DB_USERNAME_MSSQL_GASS', 'forge'),
            'password' => env('DB_PASSWORD_MSSQL_GASS', ''),
            'charset' => 'utf8',
            'prefix' => '',
//            'TrustServerCertificate' => 'yes',
//            'Encrypt' => 'no',
        ],

        'sqlsrv_accounting2017' => [
            'driver' => 'sqlsrv',
            'host' => env('DB_HOST_MSSQL_ACCOUNTING2017', 'localhost'),
            'database' => env('DB_DATABASE_MSSQL_ACCOUNTING2017', 'forge'),
            'username' => env('DB_USERNAME_MSSQL_ACCOUNTING2017', 'forge'),
            'password' => env('DB_PASSWORD_MSSQL_ACCOUNTING2017', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'TrustServerCertificate' => 'yes',
            'Encrypt' => 'no',
        ],
//

    ],

    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    |
    | This table keeps track of all the migrations that have already run for
    | your application. Using this information, we can determine which of
    | the migrations on disk haven't actually been run in the database.
    |
    */

    'migrations' => 'migrations',

    /*
    |--------------------------------------------------------------------------
    | Redis Databases
    |--------------------------------------------------------------------------
    |
    | Redis is an open source, fast, and advanced key-value store that also
    | provides a richer set of commands than a typical key-value systems
    | such as APC or Memcached. Laravel makes it easy to dig right in.
    |
    */

    'redis' => [

        'client' => 'predis',

        'default' => [
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', 6379),
            'database' => 0,
        ],

    ],

];
