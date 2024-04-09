<?php
session_start();
require_once "db.php";
include "includes/head.php";

if(isset($_GET["productID"])) {
    $productID = $_GET["productID"];

    try {
        $sql = "SELECT * FROM product WHERE productID = '$productID'";
        $stmt = $handler->prepare($sql);
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        echo "Fejl: " . $e->getMessage();
    }

}

if(isset($products) && !empty($products)) {
    foreach ($products as $product) { ?>

        <div class="container mt-5 text-center">
            <div class="row">
                <div class="col">
                    <h1><?php echo $product['productName']; ?> - <?php echo $product['productBrand']; ?></h1>
                </div>
            </div>
        </div>

    <div class="container mt-5">

        <div class="card mb-3">
            <div class="row g-0">

                <div class="col-md-4">
                    <img src="uploads/<?php echo $product['productPicture']; ?>" class="card-img-top" alt="<?php echo $product['productName']; ?>">
                </div>

                <div class="col-md-8">
                    <div class="card-body">
                        <h4 class="card-title">
                            <?php echo $product['productName']; ?>
                        </h4>
                        <p class="card-text text-muted">
                            <?php echo $product['productDesc']; ?>
                        </p>
                        <p class="card-text">
                            <strong class="text-muted">Farve:</strong>
                            <?php echo $product['productColor']; ?>
                        </p>

                        <h5 class="card-text">
                            <?php echo $product['productPrice']; ?>kr.
                        </h5>

                        <div class="form-group mt-3">
                            <form action="product.php?productID=<?php echo $_GET["productID"]; ?>" method="post">
                                <input type="number" name="data[productAmount]" value="1" min="1" placeholder="Antal" required>
                                <input type="hidden" name="data[productName]" value="<?php echo $product['productName']; ?>">
                                <input type="hidden" name="data[productPicture]" value="<?php echo $product['productPicture']; ?>">
                                <input type="hidden" name="data[productPrice]" value="<?php echo $product['productPrice']; ?>">

                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Tilføj til kurv</button>

                                <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Produkt tilføjet til kurv</h1>
                                                    <button type="submit" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn text-light btn-success" data-bs-dismiss="modal">
                                                        Fortsæt
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                            </form>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>


<?php }
}else {
    echo "Fejl";
}

include "includes/footer.php";
