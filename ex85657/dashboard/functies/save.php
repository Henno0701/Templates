<?php
include '../../config.php';

$valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'bmp' , 'pdf' , 'doc' , 'ppt');
//create function
if(count($_POST)>0){
    if($_POST['type']==1){
        $titel=$_POST['titel'];
        $bestemming=$_POST['bestemming'];
        $omschrijving=$_POST['omschrijving'];
        $begindatum=$_POST['begindatum'];
        $einddatum=$_POST['einddatum'];
        $maxInschrijvingen=$_POST['maxInSchrijvingen'];

        if (!isset($titel, $bestemming, $omschrijving, $begindatum, $einddatum, $maxInschrijvingen)) {
            echo json_encode(array("statusCode" => 201));
            exit();
        }

        if (empty($titel) || empty($bestemming) || empty($omschrijving) || empty($begindatum) || empty($einddatum) || empty($maxInschrijvingen)) {
            // Een of meer velden zijn leeg
            echo json_encode(array("statusCode"=>201));
            exit();
        }

        if (!is_numeric($maxInschrijvingen)) {
            // Telefoon is niet geldig
            echo json_encode(array("statusCode"=>201));
            exit();
        }

        die();
        // Bereid de SQL voor
        if ($stmt = $con->prepare('INSERT INTO `Reizen` (Titel, Bestemming, Omschrijving, Begindatum, Einddatum, MaxInschrijvingen) VALUES (?, ?, ?, ?, ?, ?)')) {
            // Bindparameters (s = string, i = int, b = blob, etc), in dit geval is de gebruikersnaam een string, dus "s"
            $stmt->bind_param('sssssi', $titel, $bestemming, $omschrijving, $begindatum, $einddatum, $maxInschrijvingen);
            // voer SQL uit
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

        if ($stmt = $con->prepare('UPDATE `Reizen` SET `Titel`= ?,`Bestemming`= ?,`Omschrijving`= ?,`Begindatum`= ?,`Einddatum`= ?,`MaxInschrijvingen`= ? WHERE id= ?')) {
            // Bindparameters (s = string, i = int, b = blob, etc), in dit geval is de gebruikersnaam een string, dus "s"
            $stmt->bind_param('sssssii', $titel, $bestemming, $omschrijving, $begindatum, $einddatum, $maxInschrijvingen, $id);
            // voer SQL uit
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
            // Bindparameters (s = string, i = int, b = blob, etc), in dit geval is de gebruikersnaam een string, dus "s"
            $stmt->bind_param('i', $id);
            // voer SQL uit
            $stmt->execute();

            echo $id;
        } else {
            // Laat error zien wanneer het niet gelukt is
            echo "Error: " . $stmt . "<br>" . mysqli_error($con);
        }
    }
}

?>