<?php
session_start();
require_once "db.php";

$userName = $_POST['userName'];
$userPW = $_POST['userPW'];

// connect to db

$q = $sql = 'SELECT * FROM login WHERE userName = ? AND userPW = ?';
$stmt = $handler->prepare($q);
$stmt->execute([$userName, $userPW]);

$result = $stmt->fetch(PDO::FETCH_ASSOC);

if ($result) {
    if ($result['userName'] == $userName && $result['userPW'] == $userPW){
        $_SESSION['userName'] = $userName;
        $_SESSION['status'] = true;
        /*echo "Succes";
        header('location: products.php');*/
        echo "Welcome " . $_POST["userName"];
    }
} else {
    $_SESSION['status'] = false;
    echo "Fejl";
    /*header('location: products.php');*/
}

//var_dump($query);

