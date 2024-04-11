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

                                <form>
                                    <div class="row mb-3">
                                        <label for="userPhone" class="col-sm-2 col-form-label">Telefon</label>
                                        <div class="col-sm-10">
                                            <input type="number"
                                                   class="form-control"
                                                   id="userPhone"
                                                   style="background-color: white; outline: none;"
                                                   value="<?php echo $user['userPhone']; ?>"
                                                   readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="userEmail" class="col-sm-2 col-form-label">Email</label>
                                        <div class="col-sm-10">
                                            <input type="email"
                                                   class="form-control"
                                                   id="userEmail"
                                                   style="background-color: white; outline: none;"
                                                   value="<?php echo $user['userEmail']; ?>"
                                                   readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="userAddress" class="col-sm-2 col-form-label">Adresse</label>
                                        <div class="col-sm-10">
                                            <input type="email"
                                                   class="form-control"
                                                   id="userAddress"
                                                   style="background-color: white; outline: none;"
                                                   value="<?php echo $user['userAddress']; ?>"
                                                   readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="userPW" class="col-sm-2 col-form-label">Kode
                                            <input type="checkbox" onclick="myFunction()">
                                            <i class="fa-solid fa-eye"></i>
                                        </label>
                                        <div class="col-sm-10">

                                            <input type="email"
                                                   class="form-control"
                                                   id="userPW"
                                                   style="background-color: white; outline: none;"
                                                   value="<?php echo $user['userPW']; ?>"
                                                   readonly>

                                        </div>
                                    </div>

                                    <hr class="my-5">

                                    <div class="row my-3 text-center">
                                        <div class="col">
                                            <a class="btn btn-success" href="checkout.php">
                                                <i class="fa-solid fa-cart-shopping fa-xl"></i> Se din kurv
                                            </a>
                                        </div>
                                    </div>

                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container mt-5 text-center">
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
