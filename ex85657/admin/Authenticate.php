<?php
session_start();
require '../config.php';

// haal gegevens van AJAX op
if($_POST['type']==1){
    $username= $_POST['docentAFK'];
    $password= SHA1($_POST['password']);

    // check of de form velden zijn ingevuld
    if (!isset($username, $password) ) {
        exit('Vul beide velden in!');
    }

    // Bereid de SQL voor
    if ($stmt = $con->prepare('SELECT Naam, Wachtwoord FROM Docenten WHERE Afkorting = ?')) {
        // Bindparameters (s = string, i = int, b = blob, etc), in dit geval is de gebruikersnaam een string, dus "s"
        $stmt->bind_param('s', $username);
        $stmt->execute();
        // Sla het resultaat op zodat we kunnen controleren of het account in de database bestaat.
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($name, $passwordResult);
            $stmt->fetch();

            // Account bestaat, test of het wachtwoord klopt.
            if ($password == $passwordResult) {
                // Maak sessions aan en sla dit op in de cookies om het terug te krijgen
                session_regenerate_id();
                $_SESSION['admin-loggedin'] = TRUE;
                $_SESSION['docentAFK'] = $username;
                $_SESSION['name'] = $name;

                echo json_encode(array("statusCode"=>200));


            } else {
                // Verkeerd wachtwoord
                echo json_encode(array("statusCode"=>201));
            }
        } else {
            // Verkeerd gebruikersnaam
            echo json_encode(array("statusCode"=>202));
        }

        $stmt->close();
    }
}
?>