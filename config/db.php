<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=yii2db',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',
    'attributes' => [
        PDO::MYSQL_ATTR_INIT_COMMAND =>
            "SET NAMES utf8mb4 COLLATE utf8mb4_general_ci"
    ],
    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];


// Updated configuration for Docker environment
// return [
//     'class' => 'yii\db\Connection',
//     'dsn' => 'mysql:host=db;dbname=yii2db',
//     'username' => 'root',
//     'password' => 'root',
//     'charset' => 'utf8',
// ];
