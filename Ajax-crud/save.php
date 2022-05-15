<?php
include 'config.php';
if(count($_POST)>0){
    if($_POST['type']==1){
        $name=$_POST['name'];
        $email=$_POST['email'];
        $phone=$_POST['phone'];
        $city=$_POST['city'];

        if (!isset($name, $email, $phone, $city)) {
            echo json_encode(array("statusCode" => 201));
        }

        if (empty($name) || empty($email) || empty($phone) || empty($city)) {
            // Een of meer velden zijn leeg
            echo json_encode(array("statusCode"=>201));
            exit();
        }

        // Bereid de SQL voor
        if ($stmt = $con->prepare('INSERT INTO `crud` (name, email, phone, city) VALUES (?, ?, ?, ?)')) {
            // Bindparameters (s = string, i = int, b = blob, etc), in dit geval is de gebruikersnaam een string, dus "s"
            $stmt->bind_param('ssss', $name, $email, $phone, $city);
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
if(count($_POST)>0){
    if($_POST['type']==2){
        $id=$_POST['id'];
        $name=$_POST['name'];
        $email=$_POST['email'];
        $phone=$_POST['phone'];
        $city=$_POST['city'];

        $sql = "UPDATE `crud` SET `name`='$name',`email`='$email',`phone`='$phone',`city`='$city' WHERE id=$id";
        // Maak connectie met database en voer SQL uit
        if (mysqli_query($con, $sql)) {
            // Return statusCode wanneer het gelukt is
            echo json_encode(array("statusCode"=>200));
        }
        else {
            // Laat error zien wanneer het niet gelukt is
            echo "Error: " . $sql . "<br>" . mysqli_error($con);
        }
        mysqli_close($con);
    }
}
if(count($_POST)>0){
    if($_POST['type']==3){
        $id=$_POST['id'];
        $sql = "DELETE FROM `crud` WHERE id=$id ";
        if (mysqli_query($con, $sql)) {
            echo $id;
        }
        else {
            // Laat error zien wanneer het niet gelukt is
            echo "Error: " . $sql . "<br>" . mysqli_error($con);
        }
        mysqli_close($con);
    }
}

?>