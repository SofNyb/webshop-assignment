<?php
session_start();
require_once "db.php";
include "includes/head.php";

// Kontroller om brugeren er logget ind
if (isset($_SESSION['userID'])) {
    $is_not_logged_in = false;
} else {
    $is_not_logged_in = true;
}

try {
    // henter typerne fra db
    $typeSql = 'SELECT DISTINCT productType FROM product';
    $typeStmt = $handler->query($typeSql);
    $types = $typeStmt->fetchAll(PDO::FETCH_ASSOC);

    // Hent alle produkter fra databasen
    $productsSql = 'SELECT productID, productName, productPicture, productPrice, productType FROM product';
    $productsStmt = $handler->query($productsSql);
    $products = $productsStmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Håndtering af databasefejl
    echo "Error: " . $e->getMessage();
}
?>
    <!-- overskrift -->
<div class="container mt-5 text-center">
    <div class="row">
        <div class="col">
            <h1>Velkommen til Heart and Home!</h1>
        </div>
    </div>
    <?php if ($is_not_logged_in) { ?>
        <div class="row">
            <div class="col mt-3">
                <a href="login.php" class="btn btn-success">
                    Log ind
                </a>
            </div>
        </div>
    <?php } else { ?>
        <div class="row">
            <div class="col mt-3">
                <a href="checkout.php" class="btn btn-success">
                    Se din kurv
                </a>
            </div>
        </div>
<?php } ?>
</div>

    <!-- indhold -->
<div class="container mt-5">

    <h4>Kategorier</h4>

    <!-- accordion som bliver filtreret ud fra type -->
    <?php foreach ($types as $type) : ?>
        <div class="accordion" id="accordion_<?php echo $type['productType']; ?>">
            <div class="accordion-item">
                <p class="accordion-header" id="heading_<?php echo $type['productType']; ?>">
                    <button class="accordion-button collapsed"
                      type="button"
                      data-bs-toggle="collapse"
                      data-bs-target="#collapse_<?php echo $type['productType']; ?>"
                      aria-expanded="false"
                      aria-controls="collapse_<?php echo $type['productType']; ?>">
                        <?php
                        $kategori = $type['productType'];
                        $antalProdukter = 0;
                        foreach ($products as $product) {
                            if ($product['productType'] === $kategori) {
                                $antalProdukter++;
                            }
                        }
                        ?>
                        <!-- Badge viser antallet af produkter i productType -->
                        <span class="badge bg-success rounded-pill me-2"><?php echo $antalProdukter; ?></span>
                        <?php echo $type['productType']; ?>
                    </button>
                </p>
                <div id="collapse_<?php echo $type['productType']; ?>"
                     class="accordion-collapse collapse"
                     aria-labelledby="heading_<?php echo $type['productType']; ?>"
                     data-bs-parent="#accordion_<?php echo $type['productType']; ?>">
                    <div class="accordion-body">

                        <div class="row">
                            <?php
                            // Filtrer produkter ud fra produkttype
                            $filteredProducts = array_filter($products, function($product) use ($type) {
                                return $product['productType'] === $type['productType'];
                            });

                            foreach ($filteredProducts as $product) : ?>

                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex align-items-center" style="height: 8em;">
                                        <div class="row">
                                            <div class="col">
                                                <img src="productPicture/<?php echo $product['productPicture']; ?>" class="card-img-top w-50 align-self-center" alt="<?php echo $product['productName']; ?>">
                                            </div>
                                            <div class="col">
                                                <strong><?php echo $product['productName']; ?></strong>
                                            </div>
                                            <div class="col">
                                                <p class="text-muted"><?php echo $product['productPrice']; ?>kr.</p>
                                            </div>
                                            <div class="col">
                                                <a class="btn btn-primary" href="product.php?productID=<?php echo $product['productID']; ?>">Læs mere</a>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                                <hr>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>



</div>

<?php
include "includes/footer.php";
?>