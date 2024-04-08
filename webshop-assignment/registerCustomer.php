<?php

require_once "db.php";
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
            echo 'New data inserted successfully. <a href="./index.html">Go Back</a>';
        } else {
            echo "Failed to insert new data.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage(); // Håndtering af databasefejl
    }
    exit;
endif;