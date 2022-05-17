<?php
session_start();
include '../config.php';

 $id = $_GET['id'];

if (!isset($_SESSION['admin-loggedin']) || $_SESSION['admin-loggedin'] == "") {
    header("location:home.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Data</title>
    <!-- Imports -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <!-- Css -->
    <link rel="stylesheet" href="../css/crud-style.css">
    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<nav class="navtop">
    <div class="navtop-header">
        <img src="../img/glr.png" style="height: 100%;padding: 0px 50px">
        <div class="navbar-right">
            <a href="home.php"><i class="fas fa-home"></i>Startpagina</a>
            <?php
            if (isset($_SESSION['admin-loggedin'])) {
                ?>
                <a href="index.php"><i class="fas fa-clipboard-list"></i>Overicht</a>
                <a href="../admin/logout.php"><i class="fas fa-sign-out-alt"></i>Log uit</a>
                <?php
            }
            ?>
        </div>
    </div>
</nav>
<div class="container">
    <p id="success"></p>
    <div class="table-wrapper">
        <div class="table-title">
            <a href="index.php" style="width: 100%;padding: 0px 20px;font-size: 12px"><i class="fas fa-long-arrow-alt-left" style="margin-right: 5px;font-size: 12px"></i>Terug</a>
            <div class="row">
                <div class="col-sm-6">
                    <h2>Reizen <b>Overzicht</b></h2>
                </div>
            </div>
        </div>
        <table class="table table-striped table-hover">
            <thead>
            <tr>

                <th>Student Nummer</th>
                <th>Identiteitsbewijs</th>
                <th>Opmerkingen</th>

            </tr>
            </thead>
            <tbody>

            <?php
            $result = mysqli_query($con, "SELECT * FROM Inschrijvingen WHERE ReisID =".$id);

            // Loop alle data van de database naar pagina
            while ($row = mysqli_fetch_array($result)) {
                ?>
                <tr id="<?php echo $row["ID"]; ?>">
                    <td><?php echo $row['StudentNummer']; ?></td>
                    <td><?php echo $row["Identiteitbewijs"]; ?></td>
                    <td><?php echo $row["Opmerkingen"]; ?></td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>

    </div>
</div>
</body>
</html>