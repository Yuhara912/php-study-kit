<?php

$host = 'db';
$dbname = 'php_study';
$user = 'php_user';
$password = 'php_password';

try {

    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $user,
        $password
    );

    $pdo->setAttribute(
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION
    );

    echo "MySQL connection successful!";

} catch (PDOException $e) {

    echo "Connection failed: ";
    echo $e->getMessage();

}