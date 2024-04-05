<?php

try {
    $handler = new PDO('mysql:host=localhost:3308; dbname=webshop', 'root', '');
    $handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo $e->getMessage();
    die();
}