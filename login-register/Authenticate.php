<?php
session_start();
require 'config.php';

// haal gegevens van AJAX op
if($_POST['type']==1){
    $username= $_POST['name'];
    $password= $_POST['password'];

    // check of de form velden zijn ingevuld
    if ( !isset($username, $password) ) {
        exit('Vul beide velden in!');
    }

    // Bereid de SQL voor
    if ($stmt = $con->prepare('SELECT id, password FROM accounts WHERE username = ?')) {
        // Bindparameters (s = string, i = int, b = blob, etc), in dit geval is de gebruikersnaam een string, dus "s"
        $stmt->bind_param('s', $username);
        $stmt->execute();
        // Sla het resultaat op zodat we kunnen controleren of het account in de database bestaat.
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $passwordResult);
            $stmt->fetch();
            // Account bestaat, now we verify the password.
            if (password_verify($_POST['password'], $passwordResult)) {
                // Maak sessions aan en sla dit op in de cookies om het terug te krijgen
                session_regenerate_id();
                $_SESSION['loggedin'] = TRUE;
                $_SESSION['name'] = $username;
                $_SESSION['id'] = $id;

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