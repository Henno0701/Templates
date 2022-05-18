<?php
session_start();
require '../../config.php';

// haal gegevens van AJAX op
if($_POST['type']==1){
    $ReisID= $_POST['ReisID'];
    $StudentNummer= $_SESSION['studentnumber'];
    $ID= $_POST['ID'];
    $Opmerkingen= $_POST['Opmerkingen'];


    //de gegevens om bouwen naar de juiste instelling
    $id = trim($ID);

    // check of de form velden zijn ingevuld
    if (!isset($ID) ) {
        echo json_encode(array("statusCode"=>201));
        exit();
    }

    // check of het veld BSN wel 9 karakters heeft.
    if(strlen($id) != 9) {
        echo json_encode(array("statusCode"=>202));
        exit();
    }

    // Bereid de SQL voor
    if ($stmt = $con->prepare('INSERT INTO Inschrijvingen (StudentNummer, ReisID, Identiteitbewijs, Opmerkingen) VALUES (?, ?, ?, ?)')) {
        // voeg de juiste gegevens toe in de parameter
        $stmt->bind_param('iiis', $StudentNummer,$ReisID, $ID, $Opmerkingen);
        $stmt->execute();

        echo json_encode(array("statusCode"=>200));
        }
    $stmt->close();
}

if($_POST['type']==2){
// haal gegevens van AJAX op
    $ReisID= $_POST['ReisID'];
    $StudentNummer= $_SESSION['studentnumber'];
    // Bereid de SQL voor
    if ($stmt = $con->prepare('DELETE FROM Inschrijvingen WHERE StudentNummer = ? AND ReisID = ?')) {
        // voeg de juiste gegevens toe in de parameter
        $stmt->bind_param('ii', $StudentNummer,$ReisID);
        $stmt->execute();

        echo json_encode(array("statusCode"=>200));
    }
    $stmt->close();
}
?>