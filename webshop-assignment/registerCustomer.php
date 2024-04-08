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

if (isset($_POST['userName']) && isset($_POST['userEmail']) && isset($_POST['userPW'])) :

    # Assigning user data to variables for easy access later.
    $userName = $_POST['userName'];
    $userEmail = $_POST['userEmail'];
    $userPW = $_POST['userPW'];

    # SQL query for Inserting the Form Data into the users table.
    $sql = "INSERT INTO `login` (`userName`, `userEmail`, `userPW`) VALUES ('$userName', '$userEmail', '$userPW')";

    try {
        $stmt = $handler->prepare($sql);
        $stmt->execute([$userName, $userEmail, $userPW]);

        # Tjekker om forespørgslen blev udført korrekt
        if ($stmt->rowCount() > 0) {
            echo 'Velkommen til ' . $_POST["userName"] . '<br><br>' . '<a href="./products.php">Gå til produktsiden</a>';
        } else {
            echo "Der skete en fejl." . '<br><br>' . '<a href="./registerCustomer.php">Prøv igen</a>';
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage(); // Håndtering af databasefejl
    }
    exit;
endif;
?>

<p>Hej</p>

<form action="registerCustomer.php" method="post">
    <label>Brugernavn:</label><br>
    <input type="text" name="userName"><br>
    <label>E-mailadresse:</label><br>
    <input type="email" name="userEmail"><br>
    <label>Adgangskode:</label><br>
    <input type="password" name="userPW"><br>
    <input type="submit" value="Opret">
</form>