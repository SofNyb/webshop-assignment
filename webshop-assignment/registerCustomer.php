<?php
session_start();
require_once "db.php";
include "includes/head.php";


$errorPW = ""; // Initialiser fejlmeddelelse til tom

if (isset($_POST['userName']) && isset($_POST['userEmail']) && isset($_POST['userPW'])) :

    # Assigning user data to variables for easy access later.
    $userName = $_POST['userName'];
    $userPhone = $_POST['userPhone'];
    $userAddress = $_POST['userAddress'];
    $userEmail = $_POST['userEmail'];
    $userPW = $_POST['userPW'];
    $confirmedPW = $_POST['confirmedPW'];

    if($userPW !== $confirmedPW){
        $errorPW = "Adgangskoderne er ikke ens." . '<br>' . "Prøv venligst igen";
    }else{
        //adgangskoderne er ens:
        $sql = "INSERT INTO `login` (`userName`, `userPhone`, `userAddress`, `userEmail`, `userPW`) VALUES ('$userName', '$userPhone', '$userAddress', '$userEmail', '$userPW')";

        try {
            $stmt = $handler->prepare($sql);
            $stmt->execute([$userName, $userPhone, $userAddress ,$userEmail, $userPW]);

            // Hent brugeroplysninger fra databasen for at gemme dem i sessionen
            $sql = "SELECT * FROM `login` WHERE `userEmail` = '$userEmail'";
            $stmt = $handler->query($sql);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            $_SESSION['userEmail'] = $user['userEmail'];
            $_SESSION['userID'] = $user['userID'];
            $_SESSION['userRole'] = $user['userRole'];

            header("location: products.php");
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage(); // Håndtering af databasefejl
        }
        exit;
    }
endif;
?>

<div class="container mt-5 text-center">
    <div class="row">
        <div class="col">
            <h1>Opret dit log ind her</h1>
        </div>
    </div>
</div>

<div class="container mt-5">
    <div class="card p-3">

        <form action="registerCustomer.php" method="post">

            <div class="row mb-2">
                <label for="userName" class="col-form-label">Brugernavn</label>
                <div>
                    <input type="text" class="form-control" id="userName" name="userName">
                </div>
            </div>

            <div class="row mb-2">
                <label for="userPhone" class="col-form-label">Telefonnummer</label>
                <div>
                    <input type="text" class="form-control" id="userPhone" name="userPhone">
                </div>
            </div>

            <div class="row mb-2">
                <label for="userAddress" class="col-form-label">Adresse</label>
                <div>
                    <input type="text" class="form-control" id="userAddress" name="userAddress">
                </div>
            </div>

            <div class="row mb-2">
                <label for="userEmail" class="col-form-label">Emailadresse</label>
                <div>
                    <input type="email" class="form-control" id="userEmail" name="userEmail">
                </div>
            </div>

            <div class="row mb-3">
                <label for="userPW" class="col-form-label">Adgangskode</label>
                <div>
                    <input type="password" class="form-control" id="userPW" name="userPW">
                    <input type="checkbox" onclick="myFunction()"> Vis adgangskoden
                </div>
            </div>

            <div class="row mb-3">
                <label for="confirmedPW" class="col-form-label">Skriv adgangskoden igen</label>
                <div>
                    <input type="password" class="form-control" id="confirmedPW" name="confirmedPW">
                    <input type="checkbox" onclick="myConfirmedFunction()"> Vis adgangskoden
                </div>
            </div>

            <?php if (!empty($errorPW)) : ?>
                <div class="alert alert-danger"><?php echo $errorPW; ?></div>
            <?php endif; ?>

            <div class="row text-center">
                <div class="col mt-2 mb-4">
                    <input type="submit" value="Opret konto" class="btn btn-primary">
                </div>
            </div>

        </form>
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
    function myConfirmedFunction() {
        var x = document.getElementById("confirmedPW");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
</script>