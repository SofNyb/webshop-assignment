<?php
session_start();
include_once "db.php";
include "includes/head.php";

//udskriver produkterne tilføjet til kurv fra session
if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    $checkouts = $_SESSION['cart'];


    // Opret et tomt array til at holde styr på produktID'er og deres tilsvarende antal
    $cartItems = [];

    // Gennemgå hvert element i $checkouts
    foreach ($checkouts as $item) {
        // Hvis elementet er et array og har 'productID' indekset
        if (is_array($item) && isset($item['productID'])) {
            // Hvis produktID allerede er i $cartItems arrayet, så tilføj blot antallet
            if (isset($cartItems[$item['productID']])) {
                $cartItems[$item['productID']]['productAmount'] += $item['productAmount'];
            } else {
                // Ellers tilføj det til $cartItems arrayet med antallet
                $cartItems[$item['productID']] = $item;
            }
        }
    }

    /* Her bliver productAmount sendt korrekt over
     * // Opret et array til at gemme produktID'er og deres tilsvarende antal
    $productInfo = [];

    // Gennemgå hvert element i $checkouts
    foreach ($checkouts as $item) {
        // Hvis elementet er et array og har 'productID' indekset
        if (is_array($item) && isset($item['productID'])) {
            // Opret et unikt nøgle for hvert produktID
            $productKey = $item['productID'];

            // Tilføj produktID og tilhørende antal til $productInfo array
            if (!isset($productInfo[$productKey])) {
                $productInfo[$productKey] = 0;
            }
            $productInfo[$productKey] += $item['productAmount'];
        }
    }

    // Opret et array til at gemme produktID'er
    $productIDs = [];

    // Gennemgå produktInfo array for at oprette placeholders og hente produktID'er
    foreach ($productInfo as $productID => $productAmount) {

        // Tilføj produktID til $productIDs array
        $productIDs[] = $productID;
    }*/

    try {
        // Opret et array til at holde produktID'er
        $productIDs = [];

        // Gennemgå de konsoliderede produkter i kurven for at hente produktID'er
        foreach ($cartItems as $cartItem) {
            // Tilføj produktID til $productIDs array
            $productIDs[] = $cartItem['productID'];
        }
        // Der skal en streng med produktID til at håndtere SQL IN-operator
        $allProducts = implode(",", $productIDs);

        $sql = "SELECT productID, productName, productPrice, productPicture FROM product WHERE productID IN ($allProducts)";
        $stmt = $handler->prepare($sql);
        $stmt->execute();
        $productsData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Opret $cartItems arrayet med nødvendige oplysninger
        foreach ($productsData as $productData) {
            $cartItems[$productData['productID']] = [
                'productID' => $productData['productID'],
                'productName' => $productData['productName'],
                'productPrice' => $productData['productPrice'],
                'productPicture' => $productData['productPicture'],
                'productAmount' => $cartItems[$productData['productID']]['productAmount'] // Bevarer produktantal fra tidligere
            ];
        }
    } catch(PDOException $e) {
        echo "Fejl: " . $e->getMessage();
    }
}

//fjerner produkterne fra kurven fra sessionen
if(isset($_POST['removeProduct'])) {
    $productIDToRemove = $_POST['removeProduct'];
    $productAmountToRemove = $_POST['productAmount'];
    // Find og fjern det valgte antal af produktet fra kurven
    if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        foreach($_SESSION['cart'] as $key => $product) {
            if($product['productID'] == $productIDToRemove) {
                // Hvis det valgte antal er mindre end eller lig med det antal i kurven, fjern fra kurven
                if($productAmountToRemove <= $product['productAmount']) {
                    $_SESSION['cart'][$key]['productAmount'] -= $productAmountToRemove;
                    // Hvis antallet bliver 0, fjern produktet helt fra kurven
                    if($_SESSION['cart'][$key]['productAmount'] == 0) {
                        unset($_SESSION['cart'][$key]);
                    }
                } else {
                    // Hvis det valgte antal er større end antallet i kurven, fjern produktet helt fra kurven
                    unset($_SESSION['cart'][$key]);
                }
                break; // Stop løkken, når produktet er fjernet
            }
        }
    }
}

// Hvis et produkt skal fjernes fra kurven, bliver siden automatisk genindlæst
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['removeProduct'])) {
    header("Location: " . $_SERVER['REQUEST_URI']); // Omdiriger til den samme side
    exit(); // Stop yderligere udførelse af PHP-kode
}

//hvis betalingsknappen bliver trykket
if (isset($_POST['betaling'])) {
    echo
    '<div class="container mt-5 text-center">
            <div class="row">
                <div class="col">
                    <h1>Hej!</h1>
                </div>
                <div class="row">
                    <div class="col">
                        <h4>Denne del af siden er stadig under udvikling.</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <h5>Derfor kan du desværre ikke foretage dit køb endnu.</h5>
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col">
                        <h5>Tusinde tak for din støtte og forståelse!</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <p>
                            <a href="' . $_SERVER['HTTP_REFERER'] . '" class="btn btn-success">
                            Tryk her, for at komme tilbage</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>';
    include "includes/footer.php";
    exit;
}

?>
    <!--overskrift-->
<div class="container mt-5 text-center">
    <div class="row">
        <div class="col">
            <h1>Din kurv</h1>
        </div>
    </div>
</div>

    <!--indhold i kurv-->
<div class="container mt-5">
    <div class="row">
        <div class="col-sm-12 col-md-8">

           <!-- --><?php /*if(isset($products) && !empty($products)) {
                foreach ($products as $product) { */?>

            <?php if(!empty($cartItems)) {
                foreach ($cartItems as $productID => $cartItem) {
            ?>
                    <div class="card mb-3">
                        <div class="row g-0">
                            <div class="col-md-4 d-flex align-items-center">
                                <img src="productPicture/<?php echo $cartItem['productPicture']; ?>" class="card-img-top w-75" alt="<?php echo $cartItem['productName']; ?>">
                            </div>
                            <div class="col-md-8">
                                <a style="color: black; text-decoration: none;" href="product.php?productID=<?php echo $productID ?>">
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            <?php echo $cartItem['productName']; ?>
                                        </h5>
                                        <p class="card-text">
                                            <?php echo $cartItem['productPrice']; ?>kr. x <?php echo $cartItem['productAmount']; ?>
                                        </p>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col text-end">
                                    <form action="" method="post">
                                        <input type="hidden" name="removeProduct" value="<?php echo $productID; ?>">
                                        <input type="number" name="productAmount" value="1" min="1" placeholder="Antal" required>
                                        <button type="submit" class="btn btn-danger">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php }
            } else {
                echo '<div class="text-center mt-5">
                        <h5>Du har ikke noget i din kurv</h5>
                        <a href="products.php" class="btn btn-primary">Tryk her, for at komme til produktoversigten</a>
                    </div>';
            } ?>
        </div>

        <!--samlet pris-->
        <div class="col mb-5">
            <?php

            $totalPrice = 0;

            if (!empty($cartItems)) {
                foreach ($cartItems as $cartItem)  {
                    $totalPrice += $cartItem['productPrice'] * $cartItem['productAmount'];
                }
            }

            // Den samlede pris er nu gemt i totalPrice:
            echo '
                <p>Total (inkl. moms)
                    <hr>
                    <h4 class="text-end">' . $totalPrice . " kr." .
                    '</h4>
                </p>
                
                <!--betalingsknap-->
                <div class="row text-center mt-4 mb-5">
                        <form action="" enctype="multipart/form-data" method="post">
                            <input type="submit" value="Gå til betaling" class="btn btn-success" name="betaling">
                        </form>
                    </div>
                </div>
                ';
            ?>
        </div>
    </div>

</div>

<?php
include "includes/footer.php";
