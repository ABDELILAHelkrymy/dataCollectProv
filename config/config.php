<?php

return [
    'database' => [
        'dbname' => 'provlaracheCollect',
        'user' => 'root',
        'password' => '',
        'connection' => 'mysql:host=localhost:3306',
        'options' => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]
    ],
    'routes' => [
        "/" => "home/index",
        "/dashboard" => "dashboard/index",
        "/auth/login" => "auth/login",
        "/dataCollect" => "dataCollect/index",
    ],
];
