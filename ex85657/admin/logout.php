<?php
session_start();
// maak elke session leeg die ik heb aangemaakt.
unset($_SESSION["admin-loggedin"]);
unset($_SESSION["docentAFK"]);
unset($_SESSION["name"]);

session_destroy();
// Redirect to the login page:
header('Location: ../dashboard/index.php');
?>