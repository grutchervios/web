<?php
session_start();
$host=getenv('DB_HOST')?:'127.0.0.1';$db=getenv('DB_NAME')?:'animeverse';$user=getenv('DB_USER')?:'root';$pass=getenv('DB_PASS')?:'';
$pdo=new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4",$user,$pass,[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC]);
