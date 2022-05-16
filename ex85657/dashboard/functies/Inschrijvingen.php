<?php
session_start();
require '../../config.php';

// haal gegevens van AJAX op
if($_POST['type']==1){
    $ReisID= $_POST['ReisID'];
    $StudentNummer= $_SESSION['studentnumber'];
    $ID= $_POST['ID'];
    $Opmerkingen= $_POST['Opmerkingen'];

    // check of de form velden zijn ingevuld
    if (!isset($ID, $Opmerkingen) ) {
        exit('Vul beide velden in!');
    }

    // Bereid de SQL voor
    if ($stmt = $con->prepare('INSERT INTO inschrijvingen(ReisID, StudentNummer, Identiteitsbewijs, Opmerkingen) VALUES (?, ?, ?, ?)')) {
        // Bindparameters (s = string, i = int, b = blob, etc), in dit geval is de gebruikersnaam een string, dus "s"
        $stmt->bind_param('iiis', $ReisID,$StudentNummer, $ID, $Opmerkingen);
        $stmt->execute();
        }
        $stmt->close();
}
?>