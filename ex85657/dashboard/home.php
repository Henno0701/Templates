<?php
session_start();
include '../config.php';

//check of de user is ingelogd anders redirect
if (!isset($_SESSION['admin-loggedin']) || $_SESSION['admin-loggedin'] == "") {
    header("location:index.php");
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
            <a href="index.php"><i class="fas fa-home"></i>Startpagina</a>
            <?php
            // check if de user is ingelogd voor navbar
            if (isset($_SESSION['admin-loggedin'])) {
                ?>
                <a href="home.php"><i class="fas fa-clipboard-list"></i>Overicht</a>
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
            <div class="row">
                <div class="col-sm-6">
                    <h2>Reizen <b>Overzicht</b></h2>
                </div>
                <div class="col-sm-6">
                    <a href="#addReisModal" class="btn btn-success pull-right" data-toggle="modal" style="background-color: #8fe508;
    border-color: #8fe508;"><i
                                class="fas fa-plus"></i> <span>Nieuwe reis toevoegen</span></a>
                </div>
            </div>
        </div>
        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th>ID</th>
                <th>Titel</th>
                <th>Bestemming</th>
                <th>Omschrijving</th>
                <th>Begindatum</th>
                <th>Einddatum</th>
                <th title="Inschrijvingen">In.</th>
                <th>Acties</th>
            </tr>
            </thead>
            <tbody>

            <?php
            // haal alle reizen op
            $result = mysqli_query($con, "SELECT * FROM Reizen");

            // Loop alle data van de database naar pagina
            while ($row = mysqli_fetch_array($result)) {
                ?>
                <tr id="<?php echo $row["ID"]; ?>">

                    <td><?php echo $row['ID']; ?></td>
                    <td class="text-overflow" title="<?php echo $row["Titel"]; ?>"><?php echo $row["Titel"]; ?></td>
                    <td><?php echo $row["Bestemming"]; ?></td>
                    <td class="text-overflow"
                        title="<?php echo $row["Omschrijving"]; ?>"><?php echo $row["Omschrijving"]; ?></td>
                    <td><?php echo $row["Begindatum"]; ?></td>
                    <td><?php echo $row["Einddatum"]; ?></td>
                    <td><a href="ingeschreven.php?id=<?php echo $row["ID"]; ?>" class="read" data-toggle="modal"><i class="fas fa-info-circle" data-toggle="tooltip"</td>
                    <td>
                        <a href="#editReisModal" class="edit" data-toggle="modal">
                            <!-- Stuur data attributes mee om makkelijk te updaten -->
                            <i class="fas fa-pencil-alt update" data-toggle="tooltip"
                               data-id="<?php echo $row["ID"]; ?>"
                               data-titel="<?php echo $row["Titel"]; ?>"
                               data-bestemming="<?php echo $row["Bestemming"]; ?>"
                               data-omschrijving="<?php echo $row["Omschrijving"]; ?>"
                               data-begindatum="<?php echo $row["Begindatum"]; ?>"
                               data-einddatum="<?php echo $row["Einddatum"]; ?>"
                               data-maxInschrijvingen="<?php echo $row["MaxInschrijvingen"]; ?>"
                               data-afbeelding="<?php echo $row["Afbeelding"]; ?>"
                               title="Aanpassen"></i>
                        </a>
                        <!-- Stuur data attributes mee om makkelijk te verwijderen -->
                        <a href="#deleteReisModal" class="delete" data-id="<?php echo $row["ID"]; ?>"
                           data-toggle="modal"><i class="fas fa-trash" data-toggle="tooltip"
                                                  title="Verwijderen"></i></a>
                    </td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>

    </div>
</div>
<!-- toevoegen Modal HTML -->
<div id="addReisModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="reis-toevoegen-form">
                <div class="modal-header">
                    <button type="button" id="close_modal_create" class="close" data-dismiss="modal" aria-hidden="true">
                        ×
                    </button>
                    <h4 class="modal-title">Reis toevoegen</h4>
                    <div class="message_error" id="message_create_error"><i class="fas fa-times"
                                                                            style="margin-right: 5px"></i><span
                                id="message_create_desc_error_text"></span></div>
                    <div class="message_succes" id="message_create_succes"><i class="fas fa-check"
                                                                              style="margin-right: 5px"></i><span
                                id="message_create_desc_succes_text"></span></div>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Titel</label>
                        <input type="text" id="titel_c" name="titel" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Bestemming</label>
                        <input type="text" id="bestemming_c" name="bestemming" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Omschrijving</label>
                        <textarea id="omschrijving_c" name="omschrijving" class="form-control" rows="3"
                                  style="max-width: 100%;"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Begindatum</label>
                        <input type="date" id="begindatum_c" name="begindatum" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Einddatum</label>
                        <input type="date" id="einddatum_c" name="einddatum" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Max Inschrijvingen</label>
                        <input type="number" id="maxInschrijvingen_c" name="maxInSchrijvingen" class="form-control"
                               required>
                    </div>
                    <div class="form-group">
                        <label style="width: 100%">Foto toevoegen</label>
                        <select id="afbeelding" name="afbeelding">
                            <?php
                            // haal alle afbeeldingen op
                            $result = mysqli_query($con, "SELECT * FROM Afbeeldingen");

                            // Loop alle data van de database naar pagina
                            while ($row = mysqli_fetch_array($result)) {
                            ?>
                                <option value="<?php echo trim($row["Naam"]);?>"><?php echo trim($row["Naam"]);?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" value="1" name="type">
                    <input type="button" id="cancel_modal_create" class="btn btn-default" data-dismiss="modal"
                           value="Cancel">
                    <button type="button" class="btn btn-success" id="btn-reis-toevoegen">Toevoegen</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- verander Modal HTML -->
<div id="editReisModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="update_form">
                <div class="modal-header">
                    <button type="button" class="close" id="close_modal_update" data-dismiss="modal" aria-hidden="true">
                        ×
                    </button>
                    <h4 class="modal-title">Reis aanpassen</h4>
                    <div class="message_error" id="message_update_error"><i class="fas fa-times"
                                                                            style="margin-right: 5px"></i><span
                                id="message_update_desc_error_text"></span></div>
                    <div class="message_succes" id="message_update_succes"><i class="fas fa-check"
                                                                              style="margin-right: 5px"></i><span
                                id="message_update_desc_succes_text"></span></div>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="id_u" name="id" class="form-control" required>
                    <div class="form-group">
                        <label>Titel</label>
                        <input type="text" id="titel_u" name="titel" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Bestemming</label>
                        <input type="text" id="bestemming_u" name="bestemming" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Omschrijving</label>
                        <textarea id="omschrijving_u" name="omschrijving" class="form-control" rows="3"
                                  style="max-width: 100%;"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Begindatum</label>
                        <input type="date" id="begindatum_u" name="begindatum" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Einddatum</label>
                        <input type="date" id="einddatum_u" name="einddatum" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Max Inschrijvingen</label>
                        <input type="number" id="maxInschrijvingen_u" name="maxInSchrijvingen" class="form-control"
                               required>
                    </div>
                    <div class="form-group">
                        <label style="width: 100%">Foto veranderen</label>
                        <select id="afbeelding_u" name="afbeelding">
                            <?php
                            // haal data van afbeeldingen op
                            $result = mysqli_query($con, "SELECT * FROM Afbeeldingen");

                            // Loop alle data van de database naar pagina
                            while ($row = mysqli_fetch_array($result)) {
                                ?>
                                <option value="<?php echo trim($row["Naam"]);?>"><?php echo trim($row["Naam"]);?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" value="2" name="type">
                    <input type="button" id="cancel_modal_update" class="btn btn-default" data-dismiss="modal"
                           value="Cancel">
                    <button type="button" class="btn btn-info" id="update">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- verwijder Modal HTML -->
<div id="deleteReisModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Verwijder Reis</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="id_d" name="id" class="form-control">
                    <p>Weet u zeker dat u een reis wilt verwijderen?</p>
                    <p class="text-warning"><small>Deze actie kan niet terug gedraaid worden.</small></p>
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                    <button type="button" class="btn btn-danger" id="delete">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
<script>
    $(document).on('click', '#btn-reis-toevoegen', function (e) {
        var data = $("#reis-toevoegen-form").serialize();
        // haal data van de form op en zet die om naar ajax request
        $.ajax({
            data: data,
            type: "post",
            url: "functies/save.php",
            success: function (dataResult) {
                var dataResult = JSON.parse(dataResult);
                $("#message_create_error").attr('style', 'display:none;');
                $("#message_create_succes").attr('style', 'display:none;');
                if (dataResult.statusCode == 200) {
                    // Laat een bericht zien als het is gelukt
                    $('#message_create_succes').attr('style', 'display:block');
                    $('#message_create_desc_succes_text').text('Reis toegevoegd!');

                    setTimeout(
                        function () {
                            // reload pagina
                            $('#addReisModal').modal('hide');
                            location.reload();
                        }, 2000);
                } else if (dataResult.statusCode == 201) {
                    // Laat een bericht zien als het fout is gegaan
                    $('#message_create_error').attr('style', 'display:block');
                    $('#message_create_desc_error_text').text('Er is een fout opgetreden!');
                }
            }
        });
        $("#close_modal_create, #cancel_modal_create").on('click', function () {
            $("#message_create_error").attr('style', 'display:none;');
            $("#message_create_succes").attr('style', 'display:none;');
        });
    });

    $(document).on('click', '.update', function (e) {
        // Haal data op van attributes
        var id = $(this).attr("data-id");
        var titel = $(this).attr("data-titel");
        var bestemming = $(this).attr("data-bestemming");
        var omschrijving = $(this).attr("data-omschrijving");
        var begindatum = $(this).attr("data-begindatum");
        var einddatum = $(this).attr("data-einddatum");
        var maxInschrijvingen = $(this).attr("data-maxInschrijvingen");
        var afbeelding = $(this).attr("data-afbeelding");

        // zet de velden om naar de data van de attributes
        $('#id_u').val(id);
        $('#titel_u').val(titel);
        $('#bestemming_u').val(bestemming);
        $('#omschrijving_u').val(omschrijving);
        $('#begindatum_u').val(begindatum);
        $('#einddatum_u').val(einddatum);
        $('#maxInschrijvingen_u').val(maxInschrijvingen);
        $('#afbeelding_u').val(afbeelding);

    });

    $(document).on('click', '#update', function (e) {
        // haal data van de form op en zet die om naar ajax request
        var data = $("#update_form").serialize();
        $.ajax({
            data: data,
            type: "post",
            url: "functies/save.php",
            success: function (dataResult) {
                var dataResult = JSON.parse(dataResult);
                $("#message_update_error").attr('style', 'display:none;');
                $("#message_update_succes").attr('style', 'display:none;');

                if (dataResult.statusCode == 200) {
                    // Laat een bericht zien als het is gelukt
                    $('#message_update_succes').attr('style', 'display:block');
                    $('#message_update_desc_succes_text').text('Reis aangepast!');

                    setTimeout(
                        function () {
                            // reload pagina
                            $('#editReisModal').modal('hide');
                            location.reload();
                        }, 2000);

                } else if (dataResult.statusCode == 201) {
                    // Laat een bericht zien als het fout is gegaan
                    $('#message_update_error').attr('style', 'display:block');
                    $('#message_update_desc_error_text').text('Er is een fout opgetreden!');
                }
            }
        });
        $("#close_modal_update, #cancel_modal_update").on('click', function () {
            $("#message_update_error").attr('style', 'display:none;');
            $("#message_update_succes").attr('style', 'display:none;');
        });
    });
    $(document).on("click", ".delete", function () {
        var id = $(this).attr("data-id");
        // haal de id op om makkelijk te verwijderen
        $('#id_d').val(id);

    });
    $(document).on("click", "#delete", function () {
        // haal data van de form op en zet die om naar ajax request
        $.ajax({
            url: "functies/save.php",
            type: "POST",
            cache: false,
            data: {
                type: 3,
                id: $("#id_d").val()
            },
            success: function (dataResult) {
                $('#deleteReisModal').modal('hide');
                $("#" + dataResult).remove();

            }
        });
    });
</script>

</html>