$(document).ready(function () {

    $(document).on('click','body #Inschrijvingen-btn',function(){

        var ReisID = $(this).prev().prev().val();
        var ID = $(this).prev().prev().prev().val();
        var Opmerkingen = $(this).prev().val();
        // zijn beide velden ingevuld voer de functie uit
        if (ReisID != "" && ID != "") {

            $.ajax({
                url: "../dashboard/functies/in-uitschrijvingen.php",
                type: "POST",
                data: {
                    type: 1,
                    ReisID: ReisID,
                    ID: ID,
                    Opmerkingen: Opmerkingen
                },
                // Ajax request is gelukt
                success: function (dataResult) {
                    var dataResult = JSON.parse(dataResult);
                    $("#form-message-error"+ReisID).attr('style', 'display:none;');

                    // weergeef foutmelding als dit is aangegeven door de php
                    if (dataResult.statusCode == 202) {
                        $("#form-message-error"+ReisID).text('Identiteitsbewijs niet geldig!');
                        $("#form-message-error"+ReisID).attr('style', 'display:block;');
                    }
                    else if (dataResult.statusCode == 201) {
                        $("#form-message-error"+ReisID).text('Er is een fout opgetreden!');
                        $("#form-message-error"+ReisID).attr('style', 'display:block;');
                    }
                    else {
                        location.reload();
                    }
                }
            });
        }
    });

    $("#Uitschrijvingen-btn").on('click', function () {
        var ReisID = $('#ReisID').val();
        // zijn beide velden ingevuld voer de functie uit
        if (ReisID != "") {
            $.ajax({
                url: "../dashboard/functies/in-uitschrijvingen.php",
                type: "POST",
                data: {
                    type: 2,
                    ReisID: ReisID,
                },
                // Ajax request is gelukt
                success: function (dataResult) {
                    var dataResult = JSON.parse(dataResult);
                    $("#form-message-error"+ReisID).attr('style', 'display:none;');

                    // weergeef foutmelding als dit is aangegeven door de php
                    if (dataResult.statusCode == 202) {
                        $("#form-message-error"+ReisID).text('Identiteitsbewijs niet geldig!');
                        $("#form-message-error"+ReisID).attr('style', 'display:block;');
                    }
                    else if (dataResult.statusCode == 201) {
                        $("#form-message-error"+ReisID).text('Er is een fout opgetreden!');
                        $("#form-message-error"+ReisID).attr('style', 'display:block;');
                    }
                    else {
                        location.reload();
                    }
                }
            });
        }
    });
});