<?php
session_start();

require '../config.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Home Page</title>
    <!-- Imports -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <!-- Css -->
    <link type="text/css" rel="stylesheet" href="../css/home-style.css">
    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body class="loggedin">
<nav class="navtop">
    <div class="navtop-header">
        <img src="../img/glr.png" style="height: 100%;padding: 0px 50px">
        <div class="navbar-right">
            <a href="home.php"><i class="fas fa-home"></i>Startpagina</a>
            <?php
            if (isset($_SESSION['loggedin'])) {
                ?>
                <a href="../logout.php"><i class="fas fa-sign-out-alt"></i>Log uit</a>
                <?php
            } else if (isset($_SESSION['admin-loggedin'])) {
                ?>
                <a href="index.php"><i class="fas fa-clipboard-list"></i>Overicht</a>
                <a href="../admin/logout.php"><i class="fas fa-sign-out-alt"></i>Log uit</a>
                <?php
            }
            else {
                ?>
                <a href="../Index.html"><i class="fas fa-sign-out-alt"></i>Log in</a>
                <?php
            }
            ?>
        </div>
    </div>
</nav>
<div class="content">
    <h2>Ga Lekker Reizen</h2>
    <p><?php
        if (isset($_SESSION['loggedin'])) {
            echo "Hi, " . $_SESSION['name'] . "!";
        }?></p>
    <div class="trip-container">
    <?php
    if (isset($_SESSION['loggedin'])) {
        $result = $con->query('SELECT * FROM Reizen');
        if (mysqli_num_rows($result) > 0) {
            // output data of each row
            while($row = mysqli_fetch_assoc($result)) {?>
                <div class="trip-box">
                    <div>
                        <img src="../img/texel-eiland-vuurtoren-809x540.jpeg" style="width: 100%">
                        <div class="trip-box-text">
                            <h2><?php echo $row["Titel"];?></h2>
                            <p><?php echo $row["Bestemming"];?></p>
                            <p><?php echo $row["Begindatum"];?></p>
                            <?php echo "<a href='#editEmployeeModal".$row['ID']."' data-toggle='modal' class='trip-box-button'>Meer Informatie</a>";?>
                        </div>
                    </div>
                </div>

        <!-- Edit Modal HTML -->
        <?php echo "<div id='editEmployeeModal".$row['ID']."' class='modal fade'>";?>
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="Inschrijving-form" name="form2" method="post">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <img src="../img/2.webp" class="trip-box-img">
                        <div class="trip-box-text">
                            <h2><?php echo $row["Titel"];?></h2>
                            <p><?php echo $row["Bestemming"];?></p>
                            <p><?php echo $row["Omschrijving"];?></p>
                            <p><strong><?php echo $row["Begindatum"];?></strong> tot <strong><?php echo $row["Einddatum"];?></strong></p>
                        <?php

                        $resultInschrijvingen = $con->query('SELECT COUNT(*) FROM Inschrijvingen WHERE ReisID='.$row["ID"]);
                        $Inschrijvingen = implode(mysqli_fetch_assoc($resultInschrijvingen));

                        $ingeschreven = $con->query('SELECT * FROM `Inschrijvingen` WHERE StudentNummer='.$_SESSION["studentnumber"].' AND ReisID='.$row["ID"]);
                        $anderReisIngeschreven = $con->query('SELECT * FROM `Inschrijvingen` WHERE StudentNummer='.$_SESSION["studentnumber"]);

                            if ($Inschrijvingen == $row["MaxInschrijvingen"]) {
                                echo '<p style="color: red">VOL</p>';

                                if (mysqli_num_rows($ingeschreven) > 0) {
                                    echo '<div class="modal-form">';
                                    echo '<input type="hidden" id="StudentNumber" value="' . $_SESSION["studentnumber"] . '">';
                                    echo '<input type="hidden" id="ReisID" value="' . $row["ID"] . '">';
                                    echo '<div class="modal-form-input">';
                                    echo '<input type="button" id="Uitschrijvingen-btn" class="btn btn-danger" value="Uitschrijven!">';
                                    echo '</div>';
                                    echo '</div>';
                                }
                            } else {
                                echo '<p style="color: #8fe508"><strong>' . $Inschrijvingen . '</strong> van de <strong>' . $row["MaxInschrijvingen"] . '</strong> Ingeschreven.</p>';

                                if (!mysqli_num_rows($anderReisIngeschreven) > 0) {
                                    echo '<div class="modal-form">';
                                    echo '<div class="modal-form-input">';
                                    echo '<div class="form-message-error" id="form-message-error' . $row["ID"] . '"></div>';
                                    echo '<input type="text" id="ID" placeholder="Identiteitsbewijs" style="width: 100%">';
                                    echo '<input type="hidden" id="StudentNumber" value="' . $_SESSION["studentnumber"] . '">';
                                    echo '<input type="hidden" id="ReisID" value="' . $row["ID"] . '">';
                                    echo '<textarea  id="Opmerkingen" placeholder="Opmerkingen (optioneel)" rows="3" style="width: 100%;max-width: 100%"></textarea>';
                                    echo '<input type="button" id="Inschrijvingen-btn" class="btn btn-success" value="Inschrijven!">';
                                    echo '</div>';
                                    echo '</div>';

                                } else {

                                    echo '<div class="modal-form">';
                                    echo '<input type="hidden" id="StudentNumber" value="' . $_SESSION["studentnumber"] . '">';
                                    echo '<input type="hidden" id="ReisID" value="' . $row["ID"] . '">';
                                    echo '<div class="modal-form-input">';
                                    echo '<div class="form-message-error" id="form-message-error' . $row["ID"] . '"></div>';

                                    if (mysqli_num_rows($ingeschreven) > 0) {
                                        echo '<input type="button" id="Uitschrijvingen-btn" class="btn btn-danger" value="Uitschrijven!">';
                                    }

                                    echo '</div>';
                                    echo '</div>';
                                }
                            }
                            ?>
                        </div>

                    </div>
                </form>
            </div>
                </div>
        <?php

            }
        }
    }

    ?>
    </div>
</div>
<script src="../js/jquery-3.6.0.min.js"></script>
<script src="../js/home.js"></script>
</body>
</html>
