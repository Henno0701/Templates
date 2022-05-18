$(document).ready(function () {

    $(document).on('click','body #Inschrijvingen-btn',function(){
        var ReisID = $(this).prev().prev().val();
        var ID = $(this).prev().prev().prev().prev().val();
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
                        // reload is het is gelukt
                        location.reload();
                    }
                }
            });
        } else {
            $("#form-message-error"+ReisID).attr('style', 'display:none;');
            $("#form-message-error"+ReisID).text('Vul het identiteitsbewijs in!');
            $("#form-message-error"+ReisID).attr('style', 'display:block;');
        }
    });

    $(document).on('click','body #Uitschrijvingen-btn',function(){
        var ReisID = $(this).prev().val();
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
                    $("#form-message-error" + ReisID).attr('style', 'display:none;');

                    // Reload als de statuscode wordt terug gegeven van 200
                    if (dataResult.statusCode == 200) {
                        location.reload();
                    }
                }
            });
        }
    });
});