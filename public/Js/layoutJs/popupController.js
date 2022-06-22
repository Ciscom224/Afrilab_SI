    $(function() {
        $("#apercu").on("click", function() {
            if ($("i").hasClass("bi-eye-fill")) {
                $('i').removeClass("bi-eye-fill").delay(300).addClass("bi-eye-slash");
                $("#layoutAppercue").css({
                    "visibility":"visible"
                }).show(200).fadeIn(200)
            } 
            else{
                $('i').removeClass("bi-eye-slash").delay(300).addClass("bi-eye-fill");
                $("#layoutAppercue").css({
                    "visibility":"hidden"
                }).hide(200).fadeOut(200)
            }

        })


        $('.registerBTN').on('click',function(){
            
            $('.table').css({
                "filter": "blur(10px)"
            })
            if ($('#popup').hasClass('popupHide')) {
                $("#popup").removeClass("popupHide").delay(300).addClass("popupActive");
                
            }
        })
     $('.retour').on('click',function(){
        $('.table').css({
            "filter": "blur(0px)"
        })
        if ($('#popup').hasClass('popupActive')) {
            $("#popup").removeClass("popupActive").delay(300).addClass("popupHide");
        }
     });


        $(".nonValider").on('click',function() {
            if ($('#popup').hasClass('popupActive')) {
                $("#popup").removeClass("popupActive").delay(300).addClass("popupHide");
                
            }
            $("#layoutAppercue").hide(200).fadeOut(200)
            $('.table').css({
                "filter": "blur(0px)"
            })
        })
        $('.supprime').on('click',function(){
            var id='#'+$(this).attr('id')
            $(id).val(" ")
        })
    })
