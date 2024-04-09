<?php
session_start();
include_once "db.php";

/*$sql = "SELECT * FROM login WHERE userID = '$userID'";
$stmt = $handler->query($sql);
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);*/

if(isset($_GET["userID"])) {
    $userID = $_GET["userID"];

    try {
        $sql = "SELECT * FROM login WHERE userID = '$userID'";
        $stmt = $handler->prepare($sql);
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        echo "Fejl: " . $e->getMessage();
    }

}

/*
if ($result) {
    if ($result['userEmail'] == $userEmail && $result['userPW'] == $userPW) {
        $_SESSION['userEmail'] = $userEmail;
        $_SESSION['status'] = true;

        $userRole = $result['userRole'];

        if ($userRole == 1) {
            header("location: adminRegister.php");
        } else {
            echo '<br><a href="products.php">Gå til produktsiden</a>';
        }
    }
} else {
    $_SESSION['status'] = false;
    echo "Fejl";
}*/

include "includes/head.php";
?>

    <div class="container mt-5 text-center">
        <div class="row">
            <div class="col">
                <h1>Din profil</h1>
            </div>
        </div>
    </div>

<?php if(isset($users) && !empty($users)) {
    foreach ($users as $user) { ?>

    <div class="container mt-5">
        <div class="row">

                <div class="col-sm-6 col-md-4">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title">
                                        <?php echo $user['userName']; ?>
                                    </h5>
                                </div>
                            </div>
                            <p> - <?php echo $user['userPhone']; ?></p>
                            <p class="card-text">
                                <?php echo $user['userAddress']; ?>
                            </p>
                            <p class="card-text">
                                <?php echo $user['userEmail']; ?>
                            </p>
                            <p class="card-text">
                                <?php echo $user['userPW']; ?>
                            </p>
                        </div>
                    </div>

                </div>

        </div>
    </div>

    <form action="/logout.php" method="post">
        <a class="btn nav-link" type="submit">Log ud</a>
    </form>
        <?php }
} else {
    echo "Fejl";
}?>
<?php

include "includes/footer.php";
