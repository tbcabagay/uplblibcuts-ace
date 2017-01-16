<?php

$config = parse_ini_file(dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'web.ini');

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=' . $config['uplblibcuts_db_name'],
    'username' => $config['db_username'],
    'password' => $config['db_password'],
    'charset' => 'utf8',
];
