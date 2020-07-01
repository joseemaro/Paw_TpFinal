<?php

use Monolog\Logger as MonologLogger;

$db = getenv('DATABASE_URL');
if ($db) {
    $dbopts = parse_url($db);
    $dbopts['dsn'] = sprintf(
        $dsn_template,
        'pgsql',
        $dbopts["host"],
        $dbopts["port"],
        ltrim($dbopts["path"],'/')
    );
} else {
    $dbopts = [
        "name" => 'inkmaster_db',
        "username" => 'root',
        "password" => '',
        "dsn" => 'mysql:host=127.0.0.1',
    ]
}

return [
    'database' => [
        'name' => 'inkmaster_db',
        'username' => 'root',
        'password' => '',
        'connection' => 'mysql:host=127.0.0.1',
        'options' => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]
    ],
    'logger' => [
        'level' => MonologLogger::INFO
    ],
    'twig' => [
        'templates_dir' => __DIR__ . '/app/views',
        'templates_cache_dir' => __DIR__ . '/app/views/cache'
    ]
];
