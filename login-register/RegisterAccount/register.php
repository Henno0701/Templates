<?php
require '../config.php';

if($_POST['type']==1) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $con_password = $_POST['con_password'];
    $email = $_POST['email'];

// De functie isset() controleert of de gegevens bestaan
    if (!isset($username, $password, $email)) {
        // stuur StatusCode terug voor foutmelding
        echo json_encode(array("statusCode"=>998));
    }
// Zorg ervoor dat de ingediende registratiewaarden niet leeg zijn.
    if (empty($username) || empty($password) || empty($email)) {
        // Een of meer velden zijn leeg
        echo json_encode(array("statusCode"=>998));
    }
// Bereid de SQL voor
    if ($stmt = $con->prepare('SELECT id, password FROM accounts WHERE username = ?')) {
        // Bindparameters (s = string, i = int, b = blob, etc), in dit geval is de gebruikersnaam een string, dus "s"
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->store_result();
        // Sla het resultaat op zodat we kunnen controleren of het account in de database bestaat.
        // Gebruikersnaam al in gebruik
        if ($stmt->num_rows > 0) {
            echo json_encode(array("statusCode"=>201));
        } else {
            // Email niet geldig
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo json_encode(array("statusCode"=>202));
                exit;
            }
            // Gebruikersnaam niet geldig
            if (preg_match('/^[a-zA-Z0-9]+$/', $username) == 0) {
                echo json_encode(array("statusCode"=>203));
                exit;
            }
            // Wachtwoorden niet gelijk aan elkaar
            if (strlen($password) != strlen($con_password)) {
                echo json_encode(array("statusCode"=>204));
                exit;
            }
            // Wachtwoord lengte is niet het minimum
            if (strlen($password) < 5) {
                echo json_encode(array("statusCode"=>205));
                exit;
            }
            if ($stmt = $con->prepare('INSERT INTO accounts (username, password, email) VALUES (?, ?, ?)')) {
                // We willen geen wachtwoorden in onze database vrijgeven, dus hash het wachtwoord en gebruik password_verify wanneer een gebruiker inlogt.
                $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                $stmt->bind_param('sss', $username, $passwordHash, $email);
                $stmt->execute();
                echo json_encode(array("statusCode"=>200));
            } else {
                // Er is iets mis met de sql, controleer of de rekeningentabel bestaat met alle 3 velden.
                echo json_encode(array("statusCode"=>999));
            }
        }
        $stmt->close();
    } else {
        // Er is iets mis met de sql, controleer of de rekeningentabel bestaat met alle 3 velden.
        echo json_encode(array("statusCode"=>999));
    }
    $con->close();
}
?>