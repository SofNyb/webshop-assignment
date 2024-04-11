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
                    <div class="col">
                        <div class="card mb-3">
                            <div class="card-body mx-4">
                                <div class="row pt-3">
                                    <div class="col text-center">
                                        <h4 class="card-title">
                                            <?php echo $user['userName']; ?></h4>
                                    </div>
                                </div>
                                <hr>
                                <div class="row py-2">
                                    <div class="col-3">
                                        <p class="card-text">Telefonnummer:</p>
                                    </div>
                                    <div class="col">
                                        <p class="card-text"><?php echo $user['userPhone']; ?></p>
                                    </div>
                                </div>
                                <div class="row py-2">
                                    <div class="col-3">
                                        <p class="card-text">Email:</p>
                                    </div>
                                    <div class="col">
                                        <p class="card-text"><?php echo $user['userEmail']; ?></p>
                                    </div>
                                </div>
                                <div class="row py-2">
                                    <div class="col-3">
                                        <p class="card-text">Edresse:</p>
                                    </div>
                                    <div class="col">
                                        <p class="card-text"><?php echo $user['userAddress']; ?></p>
                                    </div>
                                </div>
                                <div class="row py-2">
                                    <div class="col-3">
                                        <p class="card-text adgangskode">
                                            Din kode: <input type="checkbox" onclick="myFunction()">
                                            <i class="fa-solid fa-eye"></i>
                                        </p>

                                    </div>
                                    <div class="col">
                                        <p class="card-text">
                                            <input type="password"
                                                   style="border: none; outline: none;"
                                                   id="userPW"
                                                   name="userPW"
                                                   value="<?php echo $user['userPW']; ?>" readonly>

                                        </p>

                                    </div>
                                    <div class="col text-end">

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container text-center">
                <div class="row mt-5">
                    <div class="col">
                        <form action="logout.php" method="post">
                            <input class="btn btn-danger" type="submit" value="Log ud">
                        </form>
                    </div>
                </div>
            </div>


            <script>
                function myFunction() {
                    var x = document.getElementById("userPW");
                    if (x.type === "password") {
                        x.type = "text";
                    } else {
                        x.type = "password";
                    }
                }
            </script>
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
