<?php
// database connectie gegevens
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'Schoolex';

// Connectie proberen te maken met gegevens hierboven
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
    // Als er een error is weergeef dit op de pagina
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}