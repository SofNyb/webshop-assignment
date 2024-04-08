<?php

require_once "db.php";
include "includes/head.php";
/*
 * The following Condition checks whether a client requested the registerCustomer.php through
 * the POST method with the userName, userEmail and userPW
 *
 * userName, userEmail and userPW - You can also see these in the HTML Form (index.html) -
 * These are keys to access the actual data provided by a user.
 */

$errorPW = ""; // Initialiser fejlmeddelelse til tom

if (isset($_POST['userName']) && isset($_POST['userEmail']) && isset($_POST['userPW'])) :

    # Assigning user data to variables for easy access later.
    $userName = $_POST['userName'];
    $userEmail = $_POST['userEmail'];
    $userPW = $_POST['userPW'];
    $confirmedPW = $_POST['confirmedPW'];

    if($userPW !== $confirmedPW){
        $errorPW = "Adgangskoderne er ikke ens." . '<br>' . "Prøv venligst igen";
    }else{ //adgangskoderne er ens:

        # SQL query for Inserting the Form Data into the users table.
        $sql = "INSERT INTO `login` (`userName`, `userEmail`, `userPW`) VALUES ('$userName', '$userEmail', '$userPW')";

        try {
            $stmt = $handler->prepare($sql);
            $stmt->execute([$userName, $userEmail, $userPW]);

            # Tjekker om forespørgslen blev udført korrekt
            if ($stmt->rowCount() > 0) {
                echo 'Velkommen til ' . $_POST["userName"] . '<br><br>' . '<a href="./products.php">Gå til produktsiden</a>';
                exit;
            } else {
                echo "Der skete en fejl." . '<br><br>' . '<a href="./registerCustomer.php">Prøv igen</a>';
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage(); // Håndtering af databasefejl
        }
        exit;
    }
endif;
?>
<!--
<p>Hej</p>

<form action="registerCustomer.php" method="post">
    <label>Brugernavn:</label><br>
    <input type="text" name="userName"><br>
    <label>E-mailadresse:</label><br>
    <input type="email" name="userEmail"><br>
    <label>Adgangskode:</label><br>
    <input type="password" name="userPW"><br>
    <input type="submit" value="Opret">
</form>-->

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
                <label for="userEmail" class="col-form-label">Emailadresse</label>
                <div>
                    <input type="email" class="form-control" id="userEmail" name="userEmail">
                </div>
            </div>

            <div class="row mb-3">
                <label for="userPW" class="col-form-label">Adgangskode</label>
                <div>
                    <input type="text" class="form-control" id="userPW" name="userPW">
                </div>
            </div>

            <div class="row mb-3">
                <label for="confirmedPW" class="col-form-label">Skriv adgangskoden igen</label>
                <div>
                    <input type="text" class="form-control" id="confirmedPW" name="confirmedPW">
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