<?php
include '../../config.php';

//create function
if(count($_POST)>0){
    if($_POST['type']==1){
        $titel=$_POST['titel'];
        $bestemming=$_POST['bestemming'];
        $omschrijving=$_POST['omschrijving'];
        $begindatum=$_POST['begindatum'];
        $einddatum=$_POST['einddatum'];
        $maxInschrijvingen=$_POST['maxInSchrijvingen'];
        $afbeelding=$_POST['afbeelding'];

        if (!isset($titel, $bestemming, $omschrijving, $begindatum, $einddatum, $maxInschrijvingen, $afbeelding)) {
            echo json_encode(array("statusCode" => 201));
            exit();
        }

        if (empty($titel) || empty($bestemming) || empty($omschrijving) || empty($begindatum) || empty($einddatum) || empty($maxInschrijvingen)|| empty($afbeelding)) {
            // Een of meer velden zijn leeg
            echo json_encode(array("statusCode"=>201));
            exit();
        }

        if (!is_numeric($maxInschrijvingen)) {
            // Telefoon is niet geldig
            echo json_encode(array("statusCode"=>201));
            exit();
        }

        // Bereid de SQL voor
        if ($stmt = $con->prepare('INSERT INTO `Reizen` (Titel, Bestemming, Omschrijving, Begindatum, Einddatum, MaxInschrijvingen, Afbeelding) VALUES (?, ?, ?, ?, ?, ?, ?)')) {
            // voeg de juiste gegevens toe in de parameter
            $stmt->bind_param('sssssis', $titel, $bestemming, $omschrijving, $begindatum, $einddatum, $maxInschrijvingen, $afbeelding);
            // SQL klaar en voer het uit
            $stmt->execute();

            // Return statusCode wanneer het gelukt is
            echo json_encode(array("statusCode" => 200));
        }
        else {
            // Laat error zien wanneer het niet gelukt is
            echo "Error: " . $stmt . "<br>" . mysqli_error($con);
        }
    }
}

//update function
if(count($_POST)>0){
    if($_POST['type']==2){
        $id=$_POST['id'];
        $titel=$_POST['titel'];
        $bestemming=$_POST['bestemming'];
        $omschrijving=$_POST['omschrijving'];
        $begindatum=$_POST['begindatum'];
        $einddatum=$_POST['einddatum'];
        $maxInschrijvingen=$_POST['maxInSchrijvingen'];
        $afbeelding=$_POST['afbeelding'];

        if (!isset($id, $titel, $bestemming, $omschrijving, $begindatum, $einddatum, $maxInschrijvingen, $afbeelding)) {
            echo json_encode(array("statusCode" => 201));
            exit();
        }

        if (empty($id) || empty($titel) || empty($bestemming) || empty($omschrijving) || empty($begindatum) || empty($einddatum) || empty($maxInschrijvingen)|| empty($afbeelding)) {
            // Een of meer velden zijn leeg
            echo json_encode(array("statusCode"=>201));
            exit();
        }

        if ($stmt = $con->prepare('UPDATE `Reizen` SET `Titel`= ?,`Bestemming`= ?,`Omschrijving`= ?,`Begindatum`= ?,`Einddatum`= ?,`MaxInschrijvingen`= ?, `Afbeelding` = ? WHERE id= ?')) {
            // voeg de juiste gegevens toe in de parameter
            $stmt->bind_param('sssssisi', $titel, $bestemming, $omschrijving, $begindatum, $einddatum, $maxInschrijvingen, $afbeelding, $id);
            // SQL klaar en voer het uit
            $stmt->execute();

            // Return statusCode wanneer het gelukt is
            echo json_encode(array("statusCode" => 200));
        }
        else {
            // Laat error zien wanneer het niet gelukt is
            echo "Error: " . $stmt . "<br>" . mysqli_error($con);
        }

    }
}
if(count($_POST)>0) {
    if ($_POST['type'] == 3) {
        $id = $_POST['id'];

        if ($stmt = $con->prepare('DELETE FROM `Reizen` WHERE id = ?')) {
            // voeg de juiste gegevens toe in de parameter
            $stmt->bind_param('i', $id);
            // SQL klaar en voer het uit
            $stmt->execute();

            echo $id;
        } else {
            // Laat error zien wanneer het niet gelukt is
            echo "Error: " . $stmt . "<br>" . mysqli_error($con);
        }
    }
}

?>