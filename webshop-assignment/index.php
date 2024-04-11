<?php
session_start();
require_once "db.php";
include "includes/head.php";

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
            <h1>Velkommen til Heart and Home!</h1>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <h5>Skriv en tekst her</h5>
        </div>
    </div>
</div>

<div class="container">

    <p>Kategorier</p>
        <div class="accordion" id="indexAcc">

        <div class="accordion-item">
            <h2 class="accordion-header" id="accHead1">
                <button class="accordion-button collapsed"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#indexAcc1"
                        aria-expanded="false"
                        aria-controls="indexAcc1">
                    Sengetøj
                </button>
            </h2>
            <div id="indexAcc1"
                 class="accordion-collapse collapse"
                 aria-labelledby="accHead1"
                 data-bs-parent="#indexAcc">
                <div class="accordion-body">

                    <div class="row">
                    <?php foreach ($products as $product) : ?>

                        <ul class="list-group list-group-flush">

                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col">
                                        <img src="uploads/<?php echo $product['productPicture']; ?>" class="card-img-top" alt="<?php echo $product['productName']; ?>">
                                    </div>
                                    <div class="col">
                                        <h5>
                                            <?php echo $product['productName']; ?>
                                        </h5>
                                    </div>
                                    <div class="col">
                                        <p class="text-muted">
                                            <?php echo $product['productPrice']; ?>kr.
                                        </p>
                                    </div>
                                    <div class="col">
                                        <a class="btn btn-primary" href="product.php?productID=<?php echo $product['productID'] ?>">
                                            Læs mere
                                        </a>
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

        <div class="accordion-item">
            <h2 class="accordion-header" id="accHead2">
                <button class="accordion-button collapsed"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#indexAcc2"
                        aria-expanded="false"
                        aria-controls="indexAcc2">
                    Lagener
                </button>
            </h2>
            <div id="indexAcc2"
                 class="accordion-collapse collapse"
                 aria-labelledby="accHead2"
                 data-bs-parent="#indexAcc">
                <div class="accordion-body">
                    <div class="row">
                        <div class="col"><p>Test</p></div>
                        <div class="col"><p>Test</p></div>
                        <div class="col"><p>Test</p></div>
                        <div class="col"><p>Test</p></div>
                    </div>

                </div>
            </div>
        </div>

        <div class="accordion-item">
            <h2 class="accordion-header" id="accHead3">
                <button class="accordion-button collapsed"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#indexAcc3"
                        aria-expanded="false"
                        aria-controls="indexAcc3">
                    Indretning
                </button>
            </h2>
            <div id="indexAcc3"
                 class="accordion-collapse collapse"
                 aria-labelledby="accHead3"
                 data-bs-parent="#indexAcc">
                <div class="accordion-body">
                    <strong>This is the third item's accordion body.</strong>
                    It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                </div>
            </div>
        </div>

    </div>

</div>
<a href="login.php">log ind</a>



<?php
include "includes/footer.php";
?>