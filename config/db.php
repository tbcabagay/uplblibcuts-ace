<?php

$config = parse_ini_file('/home/tbcabagay/web.ini');

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=' . $config['uplblibcuts_db_name'],
    'username' => $config['db_username'],
    'password' => $config['db_password'],
    'charset' => 'utf8',
];
