<?php
session_start();
include_once "db.php";

include "includes/head.php";

if(isset($_SESSION['userID'])) {
    $userID = $_SESSION['userID'];

    try {
        $sql = "SELECT * FROM login WHERE userID = :userID";
        $stmt = $handler->prepare($sql);
        $stmt->bindParam(':userID', $userID);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
?>
            <div class="container mt-5 text-center">
                <div class="row">
                    <div class="col">
                        <h1>Din profil</h1>
                    </div>
                </div>
            </div>

            <div class="container mt-5">
                <div class="row">
                    <div class="col-sm-6 col-md-4">
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title"><?php echo $user['userName']; ?></h5>
                                    </div>
                                </div>
                                <p>- <?php echo $user['userPhone']; ?></p>
                                <p class="card-text"><?php echo $user['userAddress']; ?></p>
                                <p class="card-text"><?php echo $user['userEmail']; ?></p>
                                <p class="card-text"><?php echo $user['userPW']; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <form action="logout.php" method="post">
                <button class="btn nav-link" type="submit">Log ud</button>
            </form>
<?php
        } else {
            echo "Fejl: Bruger ikke fundet";
        }
    } catch(PDOException $e) {
        echo "Fejl: " . $e->getMessage();
    }
} else {
    header("Location: login.php"); // Omdiriger til login-siden
    exit; // Sørg for at afslutte scriptet efter omdirigering
}

include "includes/footer.php";
?>
