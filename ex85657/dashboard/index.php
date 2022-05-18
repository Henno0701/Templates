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
            <a href="index.php"><i class="fas fa-home"></i>Startpagina</a>
            <?php
            // als user is ingelogd toon verschillende navigatie menus per session die de user gebruikt
            if (isset($_SESSION['loggedin'])) {
                ?>
                <a href="../logout.php"><i class="fas fa-sign-out-alt"></i>Log uit</a>
                <?php
            } else if (isset($_SESSION['admin-loggedin'])) {
                ?>
                <a href="home.php"><i class="fas fa-clipboard-list"></i>Overicht</a>
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
        // als user is ingelogd toon een welkom bericht
        if (isset($_SESSION['loggedin']) || isset($_SESSION['admin-loggedin'])) {
            echo "Hi, " . $_SESSION['name'] . "!";
        }?></p>
    <div class="container" style="margin-bottom: 20px;width: 1037px;">
        <div class="row">
            <div class="col-sm-6" style="    padding-top: 70px;">
                Bij het GLR kan je makkelijk reizen boeking rond om het jaar. Kan jij niet wachten om met je vrienden op vakantie te gaan? Bekijk dan ons grote aanbod jongerenreizen en studentenreizen. Alle jongeren krijgen bij GLR studentenkorting waardoor je nog voordeliger met je vrienden op vakantie kunt!
            </div>
            <div class="col-sm-6">
                <img src="../img/roadtrip.jpeg" height="300">
            </div>
        </div>
    </div>
    <div class="container" style="margin-bottom: 50px;width: 1037px;">
        <div class="row">
            <div class="col-sm-3">
                <img src="../img/roadtrip2.jpeg" height="150">
            </div>
            <div class="col-sm-9" style="padding: 50px 60px 0px 0px;">
                Log in bij het GLR om te kunnen boeken! Elke student heeft een eigen account. Log in met je studentnummer en wachtwoord.
            </div>
        </div>
    </div>
    <div class="trip-container">
    <?php
    // als user is ingelogd toon de boekingens
    if (isset($_SESSION['loggedin']) || isset($_SESSION['admin-loggedin'])) {
        $result = $con->query('SELECT * FROM Reizen');
        if (mysqli_num_rows($result) > 0) {
            // zet de resultaat om in een while loop om alles te tonen
            while($row = mysqli_fetch_assoc($result)) {?>
                <div class="trip-box">
                    <div>
                        <img src="../img/<?php echo $row["Afbeelding"]?>" style="width: 100%">
                        <div class="trip-box-text">
                            <h2><?php echo $row["Titel"];?></h2>
                            <p><?php echo $row["Bestemming"];?></p>
                            <p><?php echo $row["Begindatum"];?></p>
                            <?php echo "<a href='#readReisModal".$row['ID']."' data-toggle='modal' class='trip-box-button'>Meer Informatie</a>";?>
                        </div>
                    </div>
                </div>

        <!-- Edit Modal HTML -->
        <?php echo "<div id='readReisModal".$row['ID']."' class='modal fade'>";?>
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="Inschrijving-form" name="form2" method="post">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <img src="../img/<?php echo $row["Afbeelding"]?>" class="trip-box-img">
                        <div class="trip-box-text">
                            <h2><?php echo $row["Titel"];?></h2>
                            <p><?php echo $row["Bestemming"];?></p>
                            <p><?php echo $row["Omschrijving"];?></p>
                            <p><strong><?php echo $row["Begindatum"];?></strong> tot <strong><?php echo $row["Einddatum"];?></strong></p>
                        <?php

                        // tel bij elkaar op hoeveel inschrijvingen er zijn per reis
                        $resultInschrijvingen = $con->query('SELECT COUNT(*) FROM Inschrijvingen WHERE ReisID='.$row["ID"]);
                        $Inschrijvingen = implode(mysqli_fetch_assoc($resultInschrijvingen));

                        // haal de gegevens op van inschijvingen als iemand al heeft ingeschreven
                        $ingeschreven = $con->query('SELECT * FROM `Inschrijvingen` WHERE StudentNummer='.$_SESSION["studentnumber"].' AND ReisID='.$row["ID"]);
                        $anderReisIngeschreven = $con->query('SELECT * FROM `Inschrijvingen` WHERE StudentNummer='.$_SESSION["studentnumber"]);

                        // als de inschijvingen vol zijn toon dit op de website
                            if ($Inschrijvingen == $row["MaxInschrijvingen"]) {
                                echo '<p style="color: red">VOL</p>';

                                // ben je al ingeschreven in een volle inschrijving kan je nog uitschrijven
                                if (mysqli_num_rows($ingeschreven) > 0) {
                                    echo '<div class="modal-form">';
                                    echo '<div class="modal-form-input">';
                                    echo '<input type="hidden" id="StudentNumber" value="' . $_SESSION["studentnumber"] . '">';
                                    echo '<input type="hidden" id="ReisID" value="' . $row["ID"] . '">';
                                    echo '<input type="button" id="Uitschrijvingen-btn" class="btn btn-danger" value="Uitschrijven!">';
                                    echo '</div>';
                                    echo '</div>';
                                }
                            } else {
                                echo '<p style="color: #8fe508"><strong>' . $Inschrijvingen . '</strong> van de <strong>' . $row["MaxInschrijvingen"] . '</strong> Ingeschreven.</p>';

                                // ben je niet ingeschreven voor de boeking waar je op klikt en hij is niet vol, toon wel de inschrijvingen button
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
                                // als je nergens voor bent in geschreven
                                    echo '<div class="modal-form">';
                                    echo '<div class="modal-form-input">';
                                    echo '<div class="form-message-error" id="form-message-error' . $row["ID"] . '"></div>';
                                    echo '<input type="hidden" id="StudentNumber" value="' . $_SESSION["studentnumber"] . '">';
                                    echo '<input type="hidden" id="ReisID" value="' . $row["ID"] . '">';
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
<!-- Footer -->
<footer class="text-center text-lg-start bg-light text-muted" style="background-color: #dfdfdf;padding-top: 30px;">
    <!-- Section: Social media -->
    <section
            class="d-flex justify-content-center justify-content-lg-between p-4 border-bottom"
    >
        <!-- Left -->
        <div class="me-5 d-none d-lg-block">
            <span>Onze social media:</span>
        </div>
        <!-- Left -->

        <!-- Right -->
        <div>
            <a href="" class="me-4 text-reset">
                <i class="fab fa-facebook-f"></i>
            </a>
            <a href="" class="me-4 text-reset">
                <i class="fab fa-twitter"></i>
            </a>
            <a href="" class="me-4 text-reset">
                <i class="fab fa-google"></i>
            </a>
            <a href="" class="me-4 text-reset">
                <i class="fab fa-instagram"></i>
            </a>
            <a href="" class="me-4 text-reset">
                <i class="fab fa-linkedin"></i>
            </a>
            <a href="" class="me-4 text-reset">
                <i class="fab fa-github"></i>
            </a>
        </div>
        <!-- Right -->
    </section>
    <!-- Section: Social media -->

    <!-- Section: Links  -->
    <section class="">
        <div class="container text-center text-md-start mt-5">
            <!-- Grid row -->
            <div class="row mt-3">
                <!-- Grid column -->
                <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
                    <!-- Content -->
                    <h6 class="text-uppercase fw-bold mb-4">
                        <i class="fas fa-gem me-3"></i>Grafisch Lyceum Rotterdam
                    </h6>
                    <p>
                       Boek hier je reizen via het GLR.
                    </p>
                </div>
                <!-- Grid column -->

                <!-- Grid column -->
                <div class="col-md-5 col-lg-4 col-xl-4 mx-auto mb-8">
                    <img src="../img/glr.png" height="150">
                </div>

                <!-- Grid column -->
                <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
                    <h6 class="text-uppercase fw-bold mb-4">
                        Contact
                    </h6>
                    <p><i class="fas fa-home me-3"></i> Heer Bokelweg 255, 3032 AD Rotterdam</p>
                    <p>
                        <i class="fas fa-envelope me-3"></i>
                        info@glr.nl
                    </p>
                    <p><i class="fas fa-phone me-3"></i> + 01 234 567 88</p>
                    <p><i class="fas fa-print me-3"></i> + 01 234 567 89</p>
                </div>
                <!-- Grid column -->
            </div>
            <!-- Grid row -->
        </div>
    </section>
    <!-- Section: Links  -->

    <!-- Copyright -->
    <div class="text-center p-4" style="background-color: rgba(0, 0, 0, 0.05);">
        © 2021 Copyright:
        <a class="text-reset fw-bold" href="https://glr.com/">Grafisch Lyceum Rotterdam</a>
    </div>
    <!-- Copyright -->
</footer>
<!-- Footer -->
<script src="../js/jquery-3.6.0.min.js"></script>
<script src="../js/home.js"></script>
</body>
</html>
