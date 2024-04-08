<?php

require_once "user/admin.php";
require_once "user/customer.php";

?>

<!DOCTYPE html>
<html lang="da">
<head>
    <meta charset="utf-8">

    <title>Login</title>

    <meta name="robots" content="All">
    <meta name="author" content="Udgiver">
    <meta name="copyright" content="Information om copyright">

    <!--
    <link href="css/styles.css" rel="stylesheet" type="text/css">
    -->

    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>

<form action="login.php" method="post">
    <input type="text" name="userName">
    <input type="text" name="userPW">
    <input type="submit" value="login">
</form>

<p>Ny bruger?</p>
<a href="register.php">Registrer dig her</a>

</body>
</html>
