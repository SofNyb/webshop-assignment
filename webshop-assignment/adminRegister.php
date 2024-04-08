<?php

include "includes/head.php";
/*
 * The following Condition checks whether a client requested the registerCustomer.php through
 * the POST method with the userName, userEmail and userPW
 *
 * userName, userEmail and userPW - You can also see these in the HTML Form (index.html) -
 * These are keys to access the actual data provided by a user.
 */

if (isset($_POST['productName']) && isset($_POST['productColor']) && isset($_POST['productBrand']) && isset($_POST['productPrice'])) :

    # Assigning user data to variables for easy access later.
    $productName = $_POST['productName'];
    $productColor = $_POST['productColor'];
    $productBrand = $_POST['productBrand'];
    $productPrice = $_POST['productPrice'];
    $productType = $_POST['productType'];

    # SQL query for Inserting the Form Data into the users table.
    $sql = "INSERT INTO `product` (`productName`, `productPrice`, `productColor`, `productBrand`, `productType`) VALUES ('$productName', '$productPrice', '$productColor', '$productBrand', '$productType')";

    try {
        $stmt = $handler->prepare($sql);
        $stmt->execute([$productName, $productPrice, $productColor, $productBrand, $productType]);

        # Tjekker om forespørgslen blev udført korrekt
        if ($stmt->rowCount() > 0) {
            echo 'Produkt tilføjet'. '<br><br>' . '<a href="./adminRegister.php">Registrer flere</a>';
        } else {
            echo "Der skete en fejl." . '<br><br>' . '<a href="./adminRegister.php">Prøv igen</a>';
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage(); // Håndtering af databasefejl
    }
    exit;
endif;
?>

<form action="adminRegister.php" method="post">
    <label>Produktnavn:</label><br>
    <input type="text" name="productName"><br>
    <label>Produktets pris:</label><br>
    <input type="number" name="productPrice"><br>
    <label>Produktets farve:</label><br>
    <input type="text" name="productColor"><br>
    <label>Tøjmærke:</label><br>
    <input type="text" name="productBrand"><br>
    <label>Tøjtype:</label><br>
    <input type="text" name="productType"><br>
    <input type="submit" value="Opret">
</form>
<?php
include "includes/footer.php";
?>