<?php
session_start();
include_once "db.php";

    try {
        $sql = "SELECT * FROM checkout ORDER BY checkoutID ASC";
        $stmt = $handler->prepare($sql);
        $stmt->execute();
        $checkouts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        echo "Fejl: " . $e->getMessage();
    }

include "includes/head.php";
?>
        <div class="container mt-5 text-center">
            <div class="row">
                <div class="col">
                    <h1>Din kurv</h1>
                </div>
            </div>
        </div>

        <div class="container mt-5">
            <div class="row">
    <div class="col-8">
<?php if(isset($checkouts) && !empty($checkouts)) {
    foreach ($checkouts as $checkout) { ?>

            <div class="card mb-3">
                <div class="row g-0">

                    <div class="col-md-4">
                        <img src="uploads/<?php echo $checkout['checkoutPicture']; ?>" class="card-img-top" alt="<?php echo $checkout['checkoutName']; ?>">
                    </div>

                    <div class="col-md-8">
                        <div class="card-body">
                            <h4 class="card-title">
                                <?php echo $checkout['checkoutName']; ?>
                            </h4>

                            <h5 class="card-text">
                                <?php echo $checkout['checkoutPrice']; ?>kr.
                            </h5>

                        </div>
                    </div>

                </div>
            </div>

        <?php } ?>
    </div>
        <div class="col">
            <p>Total udregning</p>
        </div>
    </div>
        </div>

<?php
}else {
        echo "fejl";
    }
include "includes/footer.php";
