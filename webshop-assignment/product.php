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

    <div class="container mt-5">

        <div class="row">

            <div class="col">
                <div class="card">
                    <!--<img src="uploads/<?php /*echo $product['productPicture']; */?>" class="card-img-top" alt="<?php /*echo $product['productName']; */?>">-->
                </div>

                <div class="card">

                    <div class="card-body">

                        <div class="row">

                            <div class="col">
                                <h5 class="card-title">
                                    <?php echo $product['productName']; ?>
                                </h5>
                            </div>

                        </div>

                        <p> - <?php echo $product['productType']; ?></p>
                        <p class="card-text">
                            <?php echo $product['productBrand']; ?>
                        </p>
                        <p class="card-text">
                            <?php echo $product['productColor']; ?>
                        </p>
                        <p class="card-text">
                            <?php echo $product['productType']; ?>
                        </p>

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
