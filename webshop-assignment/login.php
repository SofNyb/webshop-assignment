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

        echo "Velkommen " . $_POST["userName"];

        $userRole = $result['userRole'];

        if($userRole == 1) {
            echo '<br><a href="adminRegister.php">Gå til admin-siden</a>';
        } else {
            echo '<br><a href="products.php">Gå til produktsiden</a>';
        }
    }
} else {
    $_SESSION['status'] = false;
    echo "Fejl";
}

//var_dump($query);

