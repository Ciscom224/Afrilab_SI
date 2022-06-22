function getElementName() {
    let selectfield = document.getElementsByClassName('selectfield');
    for (let i = 0; i < selectfield.length; i++) {
        let element = selectfield[i]
        element.addEventListener('change', () => {
            console.log(element.value)
            let input = document.getElementById('elementAna' + element.getAttribute('id'));
            console.log(input.value)
            input.value += ';'+element.value
        })
    }
}
getElementName()

$(function() {

    let nbEch=+$('.nbrEch').val()
    let oldNbr=+$('.nbrEch').val()
    $('.addEchantillon').on('click',function() {

        nbEch++
        let ref="R/"+$('#dem_id').val()+"_2021_"+nbEch
        let elem='elementAna'+nbEch
        let design='design'+nbEch
        $('.nbrEch').val(nbEch)
        $('table').append("<tr class='line'><th scope='row'>"+nbEch+"</th><td>R/"+$('#dem_id').val()+"_2021_"+nbEch+"<input type='hidden' name=ref"+nbEch+" class='form-control' value="+ref+"></td><td><input type='text' name="+design+"   placeholder='...' class='form-control' required></td>  <td><input style='width:100%' type='text' id='"+elem+"' name='"+elem+"' class='form-control' required ></td> </tr>")

    })


    $('.delEchantillon').on('click',function() {
        if (nbEch>oldNbr) {
            nbEch--
            $('.nbrEch').val(nbEch)
            $('tr:last').remove();

        }
        else {
        var annee = (new Date()).getFullYear();
        alert(annee);
        alert("Impossible de supprimer ces echantillons sont uniquement a modifier")
        }
    })

})
