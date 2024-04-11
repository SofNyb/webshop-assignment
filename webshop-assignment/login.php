<?php
session_start();
require_once "db.php";
include "includes/head.php";

$loginMessage = "";

if(isset($_POST['userEmail'], $_POST['userPW'])) {
    $userEmail = $_POST['userEmail'];
    $userPW = $_POST['userPW'];

    // connect to db

    $q = $sql = "SELECT * FROM login WHERE userEmail = '$userEmail'; // AND userPW = '$userPW'";
    $stmt = $handler->prepare($q);
    $stmt->execute([$userEmail, $userPW]);

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        if ($result['userEmail'] == $userEmail && $result['userPW'] == $userPW) {
            $_SESSION['userEmail'] = $userEmail;
            $_SESSION['userID'] = $result['userID'];
            $_SESSION['status'] = true;
            $_SESSION['userRole'] = $result['userRole'];

            if ($result['userRole'] == 1) {
                header("location: adminRegister.php");
            } else {
                header("location: products.php");
            }
        }
    } else {
        $_SESSION['status'] = false;
        $loginMessage = "Hov, der skete en fejl! Prøv at logge ind igen.";
    }
}
?>

<div class="container mt-5 text-center">
    <div class="row">
        <div class="col">
            <h1>Log ind på din profil</h1>
        </div>
    </div>
</div>

<div class="container mt-5">
    <div class="card p-3">
        <form action="login.php" method="post">

            <div class="row mb-2">
                <label for="userEmail" class="col-form-label">Emailadresse</label>
                <div>
                    <input type="text" class="form-control" id="userEmail" name="userEmail">
                </div>
            </div>
            <div class="row mb-3">
                <label for="userPW" class="col-form-label">Adgangskode</label>
                <div>
                    <input type="password" class="form-control" id="userPW" name="userPW">
                    <input type="checkbox" onclick="myFunction()"> Vis adgangskoden
                </div>
            </div>
            <div class="row text-center">
                <div class="col mt-2 mb-4">
                    <input type="submit" value="Log ind" class="btn btn-success">
                </div>
            </div>

            <?php if (!empty($loginMessage)) : ?>
                <div class="alert alert-info">
                    <?php echo $loginMessage; ?>
                </div>
            <?php endif; ?>

        </form>
        <hr>
        <div class="row text-center mt-4 mb-3">
            <div class="col">
                <a class="btn btn-primary" href="registerCustomer.php">Opret ny konto</a>
            </div>
        </div>
    </div>

</div>

<script>
    function myFunction() {
        var x = document.getElementById("userPW");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
</script>
<?php
include "includes/footer.php";
?>
