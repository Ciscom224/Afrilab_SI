function redBox(idElement) {
    if ($(idElement).val() == "") {
        console.log("le  dchampemandeur est vide")
        $(idElement).css({ "box-shadow": "0px 0px 10px red" })
        setTimeout(() => {
            $(idElement).css({ "box-shadow": "0px 0px 0px black" })
        }, 5000);
        return true
    }
    return false
}

function getElementName() {
    let selectfield = document.getElementsByClassName('selectfield');
    for (let i = 0; i < selectfield.length; i++) {
        let element = selectfield[i]
        element.addEventListener('change', () => {
            console.log(element.value)
            let input = document.getElementById('elementAna' + element.getAttribute('id'));
            input.value += element.value + ';'
        })
    }
}


$(function() {
    getElementName()

    $("select").change(function() {
        var str = "";
        $("#etat option:selected").each(function() {
            str = $(this).text();
            if (str == "Solide") {
                $('#solideOptions').css({
                    "visibility": "visible"
                }).show()
            } else {
                $('#solideOptions').css({
                    "visibility": "hidden"
                }).hide()
            }
        });
    }).change();

    $("select").change(function() {
        var str = "";
        $("#depotAfrilab option:selected").each(function() {
            str = $(this).text();
            if (str == "AFRILAB") {
                console.log(" AfriLab depot ")
                $('#depotoire').css({
                    "visibility": "visible"
                }).show()
            } else {
                $('#depotoire').css({
                    "visibility": "hidden"
                }).hide()
            }
        });
    }).change();
    //------------------------------------------------------
    let errorDemande = false;
    $("#nombre").change(function() {
        $("#ref1").text("R/" + $('#numDemande').val() + "_2021_1")
            //les verification
        if ($(" #nombre option:selected").val() != 0) {
            //--------------------------------sur le champ demandeur-----------
            errorDemande = redBox("#demandeur")
                //--------------------------------sur le champ societe-----------
            errorDemande = redBox("#societe")
                //--------------------------------sur le champ identificateur-----------
            errorDemande = redBox("#identificateur")
                //--------------------------------sur le champ numero de demande-----------
            errorDemande = redBox("#numDemande")
                //--------------------------------sur le champ numero de Etat de l'echantillon-----------
            if ($("#etat option:selected").val() == "") {
                errorDemande = redBox("#etat")

            } else if ($("#etat option:selected").val() == "solide") {
                let vari = "vide "
                vari = vari + "autre" + $('input[name=solide]:checked').val()
            }
            if ($("#depotAfrilab option:selected").val() == "") {
                errorDemande = redBox("#depotAfrilab")
            }
        }

        //-----------------------------------------------
    }).change();
})