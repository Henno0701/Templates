$(document).ready(function () {
    $("#btn-inschrijvingen").click(function () {
        var ReisID = $('#ReisID').val();
        var ID = $('#ID').val();
        var Opmerkingen = $('#Opmerkingen').val();
        // zijn beide velden ingevuld voer de functie uit
        if (ReisID != "" && ID != "" && Opmerkingen != "") {
            $.ajax({
                url: "../dashboard/functies/Inschrijvingen.php",
                type: "POST",
                data: {
                    type: 1,
                    ReisID: ReisID,
                    ID: ID,
                    Opmerkingen: Opmerkingen
                },
                cache: false,
                // Ajax request is gelukt
                success: function (dataResult) {
                    var dataResult = JSON.parse(dataResult);
                    alert('GELUKT');
                }
            });
        }
    })
});