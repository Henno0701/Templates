<?php
session_start();

// maak elke session leeg die ik heb aangemaakt.
unset($_SESSION["loggedin"]);
unset($_SESSION["studentnumber"]);
unset($_SESSION["name"]);

session_destroy();
// Redirect to the login page:
header('Location: dashboard/index.php');
?>