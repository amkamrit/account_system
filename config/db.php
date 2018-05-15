<?php
session_start();
$host=isset($_SESSION['host'])?$_SESSION['host']:null;
$dbname=isset($_SESSION['dbname'])?$_SESSION['dbname']:null;
$username=isset($_SESSION['username'])?$_SESSION['username']:null;
$password=isset($_SESSION['password'])?$_SESSION['password']:null;

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host='.$host.';dbname='.$dbname,
    'username' => $username,
    'password' => $password,
    'charset' => 'utf8',
];
?>