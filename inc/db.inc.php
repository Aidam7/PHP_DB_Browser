<?php
require_once "inc/db.inc.php";
require_once "DBCredentials.php";
$host = DBHost;
$db = DB;
$user = DBUsername;
$pass = DBPassword;
$charset = DBCharset;

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
    PDO::ATTR_EMULATE_PREPARES => false,
];
$pdo = new PDO($dsn, $user, $pass, $options);
