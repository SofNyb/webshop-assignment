<?php
session_start();
require_once "db.php";

$userEmail = $_POST['userEmail'];
$userPW = $_POST['userPW'];

// connect to db

$q = $sql = "SELECT * FROM login WHERE userEmail = '$userEmail'; // AND userPW = '$userPW'";
$stmt = $handler->prepare($q);
$stmt->execute([$userEmail, $userPW]);

$result = $stmt->fetch(PDO::FETCH_ASSOC);

if ($result) {
    if ($result['userEmail'] == $userEmail && $result['userPW'] == $userPW){
        $_SESSION['userEmail'] = $userEmail;
        $_SESSION['status'] = true;

        $userRole = $result['userRole'];

        if($userRole == 1) {
            header("location: adminRegister.php");
        } else {
            echo '<br><a href="products.php">Gå til produktsiden</a>';
        }
    }
} else {
    $_SESSION['status'] = false;
    echo "Fejl";
}

//var_dump($query);

