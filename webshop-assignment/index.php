<?php

require_once "user/admin.php";
require_once "user/customer.php";

include "includes/head.php";
?>

<div class="container mt-5 text-center">
    <div class="row">
        <div class="col">
            <h1>Velkommen til webshop!</h1>
        </div>
    </div>
</div>

<div class="container mt-5">
    <div class="card p-3">
        <form action="login.php" method="post">
            <div class="row mb-2">
                <label for="userName" class="col-form-label">Brugernavn</label>
                <div>
                    <input type="text" class="form-control" id="userName" name="userName">
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
                    <input type="submit" value="Log ind" class="btn btn-primary">
                </div>
            </div>
        </form>
        <hr>
        <div class="row text-center mt-4 mb-3">
            <div class="col">
                <a class="btn btn-success" href="registerCustomer.php">Opret ny konto</a>
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