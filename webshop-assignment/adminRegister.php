<?php
session_start();
require_once "db.php";
include "includes/head.php";

// Kontroller om brugeren er logget ind og har en rolle, før tjek for administratorrolle
if (!isset($_SESSION['userRole']) || $_SESSION['userRole'] !== '1') {
    //hvis userRole ikke er 1, kan de ikke få adgang, og får vist fejlbesked
    echo "Hej!" . '<br>' . "Du er på vej ind et sted, hvor du ikke har adgang til." . '<br>' . '<a href="' . $_SERVER['HTTP_REFERER'] . '">Tryk her, for at komme tilbage</a>';
    exit;
}

$productMessage = "";

/*if (isset($_POST['productName']) && isset($_POST['productColor']) && isset($_POST['productBrand']) && isset($_POST['productPrice'])) :*/

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
}
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
                <div>
                    <input type="number" class="form-control" id="productPrice" name="productPrice" required>
                </div>
            </div>

            <div class="row mb-2">
                <label for="productColor" class="col-form-label">Produktets farve</label>
                <div>
                    <input type="text" class="form-control" id="productColor" name="productColor" required>
                </div>
            </div>

            <div class="row mb-2">
                <label for="productBrand" class="col-form-label">Tøjmærke</label>
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
                    <input type="submit" value="Opret produktet" class="btn btn-primary">
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