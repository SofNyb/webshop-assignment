<?php

require_once "user/admin.php";
require_once "user/customer.php";

include "includes/head.php";
?>

<form action="login.php" method="post">
    <label for="userName">Brugernavn:</label>
    <br>
    <input type="text" name="userName">
    <br>
    <label for="userPW">Adgangskode:</label>
    <br>
    <input type="text" name="userPW">
    <br>
    <input type="submit" value="login">
</form>

<p>Ny bruger?</p>
<a href="registerCustomer.php">Registrer dig her</a>

<?php
include "includes/footer.php";
?>