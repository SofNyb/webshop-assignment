<?php
session_start();
require_once "db.php";
include "includes/head.php";

// Kontroller om brugeren er logget ind
if (isset($_SESSION['userRole'])) {
    $is_logged_in = true;
} else {
    $is_logged_in = false;
}

if ($is_logged_in && $_SESSION['userRole'] == '1' && isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['productID'])) {
    // Slet produktet fra databasen
    $productID = $_GET['productID'];
    $deleteSql = 'DELETE FROM product WHERE productID = :productID';
    $deleteStmt = $handler->prepare($deleteSql);
    $deleteStmt->bindParam(':productID', $productID, PDO::PARAM_INT);
    $deleteStmt->execute();

    // Omdiriger tilbage til samme side efter sletning
    header("Location: {$_SERVER['PHP_SELF']}");
    exit();
}

// Hent alle produkter fra databasen
$sql = 'SELECT productID, productName, productPicture, productPrice FROM product';

try {
    // Forbered og udfør forespørgslen
    $stmt = $handler->query($sql);

    // Hent alle rækker som et associativt array
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Håndtering af databasefejl
    echo "Error: " . $e->getMessage();
}
?>

<div class="container mt-5 text-center">
    <div class="row">
        <div class="col">
            <h1>Alle produkter</h1>
        </div>
    </div>
</div>

<div class="container mt-5 pb-5">
    <div class="row">
        <?php foreach ($products as $product) : ?>
            <div class="col-sm-6 col-md-4">
                <div class="card mb-3">
                    <a style="color: black; text-decoration: none;" href="product.php?productID=<?php echo $product['productID']?>">
                        <div class="card-body">
                            <img src="uploads/<?php echo $product['productPicture']; ?>" class="card-img-top" alt="<?php echo $product['productName']; ?>">
                            <h5 class="card-title">
                                <?php echo $product['productName']; ?>
                            </h5>
                            <p class="card-subtitle text-muted">
                                <?php echo $product['productPrice']; ?>kr.
                            </p>
                        </div>
                    </a>
                    <div class="mt-3 card-footer">
                            <!--<a class="btn btn-primary" href="product.php?productID=<?php /*echo $product['productID'] */?>">
                                Læs mere
                            </a>-->
                        <?php if ($is_logged_in && $_SESSION['userRole'] == '1') : ?>
                            <div class="col text-end">
                                <a class="btn btn-danger text-end" href="?action=delete&productID=<?php echo $product['productID'] ?>">
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include "includes/footer.php"; ?>
