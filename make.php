<?php
    $db_host = readline("Database host: ");
    $db_user = readline("Database user: ");
    $db_password = readline("Database password: ");
    $db_name = readline("Database name: ");
    $config = [
        "DB_HOST" => $db_host,
        "DB_USER" => $db_user,
        "DB_PASSWORD" => $db_password,
        "DB_NAME" => $db_name
    ];
    if (!file_exists("cfg")) {
        mkdir("cfg");
    }
    file_put_contents("cfg/cfg.json", json_encode($config, JSON_UNESCAPED_UNICODE));