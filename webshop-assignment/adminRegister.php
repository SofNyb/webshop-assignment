<?php
session_start();
require_once "db.php";
include "includes/head.php";

// Kontroller om brugeren er logget ind og har en rolle, før tjek for administratorrolle
if (!isset($_SESSION['userRole']) || $_SESSION['userRole'] !== '1') {
    //hvis userRole ikke er 1, kan de ikke få adgang, og får vist fejlbesked
    echo
        '<div class="container mt-5 text-center">
            <div class="row">
                <div class="col">
                    <h1>Hej!</h1>
                </div>
                <div class="row">
                    <div class="col">
                        <h4>Du er på vej ind et sted, hvor du ikke har adgang til.</h4>
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col">
                        <h5>
                            <a href="' . $_SERVER['HTTP_REFERER'] . '" class="btn btn-success">Tryk her, for at komme tilbage</a>
                        </h5>
                    </div>
                </div>
            </div>
        </div>'
        . '<br>';
    include "includes/footer.php";
    exit;
}

$productMessage = "";

// check if the user has clicked the button "UPLOAD"

if (isset($_POST['Opret'])) {
    $productName = $_POST['productName'];
    $productBrand = $_POST['productBrand'];
    $productPrice = $_POST['productPrice'];
    $productType = $_POST['productType'];
    $productDesc = $_POST['productDesc'];

    $productPicture = $_FILES["productPicture"]["name"];
    $tempName = $_FILES["productPicture"]["tmp_name"];
    $folder = "uploads/".$productPicture;

        // query to insert the submitted data
        $sql = "INSERT INTO `product` (`productName`, `productPrice`, `productBrand`, `productType`, `productDesc`, `productPicture`)
                VALUES ('$productName', '$productPrice', '$productBrand', '$productType', '$productDesc', '$productPicture')";

        $stmt = $handler->prepare($sql);
        $stmt->execute([$productName, $productPrice, $productBrand, $productType, $productDesc, $productPicture]);

        // Add the image to the "uploads" folder"

        if (move_uploaded_file($tempName, $folder)) {

            $productMessage = "Image uploaded successfully";

        }else{
            /*$lastError = error_get_last();
            if ($lastError !== null && isset($lastError['message'])) {
                print_r($lastError);
                $errorMessage = $lastError['message'];*/


            $productMessage = "Failed to upload image";
            /*} else {
                // Hvis der ikke er nogen specifik fejlmeddelelse, kan du give en generel besked
                $productMessage = "Der opstod en ukendt fejl under flytning af filen.";

            }*/

    }

    if (is_uploaded_file($tempName)) {
        if (move_uploaded_file($tempName, $folder)) {
            $productMessage = "Image uploaded successfully";
        } else {
            $productMessage = "Failed to upload image";
        }
    } else {
        $productMessage = "Produkt blev oprettet";
    }

}

/*if (isset($_POST['productName']) && isset($_POST['productColor']) && isset($_POST['productBrand']) && isset($_POST['productPrice'])) :*/

/*if ($_SERVER["REQUEST_METHOD"] == "POST") {
    # Assigning user data to variables for easy access later.
    $productName = $_POST['productName'];
    $productColor = $_POST['productColor'];
    $productBrand = $_POST['productBrand'];
    $productPrice = $_POST['productPrice'];
    $productType = $_POST['productType'];
    $productDesc = $_POST['productDesc'];

    // fil upload
    if (isset($_FILES['productPicture']) && $_FILES['productPicture']['error'] === UPLOAD_ERR_OK) {
        print_r($_FILES['productPicture']);
        $allowedTypes = ['image/jpeg', 'image/jpg'];
        $maxFileSize = 5 * 1024 * 1024; // 5 MB

        if (in_array($_FILES['productPicture']['type'], $allowedTypes) && $_FILES['productPicture']['size'] <= $maxFileSize) {
            // Filen er af tilladt type og størrelse
            $fileName = $_FILES["productPicture"]["name"];
            $tempName = $_FILES["productPicture"]["tmp_name"];
            $folder = "uploads/" . $fileName;

            if (move_uploaded_file($tempName, $folder)) {
                $productMessage = "Image uploaded successfully";
                $sql = "INSERT INTO `product` (`productName`, `productPrice`, `productColor`, `productBrand`, `productType`, `productDesc`, `productPicture`) VALUES (?, ?, ?, ?, ?, ?, ?)";

                $stmt = $handler->prepare($sql);
                $stmt->execute([$productName, $productPrice, $productColor, $productBrand, $productType, $productDesc, $fileName]);

                if ($stmt->rowCount() > 0) {
                    $productMessage = 'Produktet er nu tilføjet';
                } else {
                    $productMessage = "Der skete en fejl." . '<br>' . "Prøv igen.";
                }
            } else {
                $productMessage = "Der opstod en fejl under upload af billedet.";
            }
        } else {
            $productMessage = "Den uploadede fil er ikke tilladt eller er for stor.";
        }
    } else {
        $productMessage = "Der blev ikke valgt nogen fil, men produktet er nu tilføjet.";
        $sql = "INSERT INTO `product` (`productName`, `productPrice`, `productColor`, `productBrand`, `productType`, `productDesc`) VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $handler->prepare($sql);
        $stmt->execute([$productName, $productPrice, $productColor, $productBrand, $productType, $productDesc]);
    }
}*/
?>

<div class="container mt-5 text-center">
    <div class="row">
        <div class="col">
            <h1>Tilføj produkter</h1>
        </div>
    </div>
</div>

<div class="container mt-5">
    <div class="card p-3">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" method="post">

            <?php if (!empty($productMessage)) : ?>
                <div class="alert alert-info">
                    <?php echo $productMessage; ?>
                </div>
            <?php endif; ?>

            <div class="row mb-2">
                <label for="productName" class="col-form-label">Produktnavn</label>
                <div>
                    <input type="text" class="form-control" id="productName" name="productName" required>
                </div>
            </div>

            <!-- Tilføj produktbilledet -->
            <div class="row mb-2">
                <label for="productPicture" class="col-form-label">Produktbillede</label>
                <div>
                    <input type="file" class="form-control" id="productPicture" name="productPicture">
                </div>
            </div>

            <div class="row mb-3">
                <label for="productPrice" class="col-form-label">Produktets pris</label>
                <div class="input-group">
                    <input type="number" class="form-control" id="productPrice" name="productPrice" required>
                    <div class="input-group-text">kr.</div>
                </div>
            </div>

            <div class="row mb-2">
                <label for="productBrand" class="col-form-label">Mærke</label>
                <div>
                    <input type="text" class="form-control" id="productBrand" name="productBrand" required>
                </div>
            </div>

            <div class="row mb-2">
                <label for="productType" class="col-form-label">Produkttype</label>
                <div>
                    <input type="text" class="form-control" id="productType" name="productType" required>
                </div>
            </div>

            <div class="row mb-2">
                <label for="productDesc" class="col-form-label">Produktbeskrivelse</label>
                <div>
                    <textarea rows="3" type="text" class="form-control" id="productDesc" name="productDesc" required></textarea>
                </div>
            </div>

            <div class="row text-center">
                <div class="col mt-2 mb-4">
                    <input type="submit" value="Opret produktet" class="btn btn-primary" name="Opret">
                </div>
            </div>

            <hr>

            <div class="row text-center mt-4 mb-3">
                <div class="col">
                    <a class="btn btn-success" href="products.php">Se produkterne</a>
                </div>
            </div>

        </form>

    </div>

<?php
include "includes/footer.php";
?>