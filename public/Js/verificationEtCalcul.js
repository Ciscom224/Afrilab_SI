$(function () {
    function redBox(idElement) {
        if ($(idElement).val() == "") {
            $(idElement).css({ "box-shadow": "0px 0px 10px red" })
            setTimeout(() => {
                $(idElement).css({ "box-shadow": "0px 0px 0px black" })
            }, 3000);
            return true
        }
        return false
    }
    function arrondi(x) {
        return Number.parseFloat(x).toFixed(2);
      }
    function verification(){
        let demandeERROR
        for (let i = 0; i < nbEch; i++) {
            let PT="#poidsTare"+i
            let PH="#poidsHumide"+i
            let PS="#poidsSeche"+i

            if (redBox(PT)) {
                demandeERROR=true
            }
            else if (redBox(PH)) {
                demandeERROR=true
            }
            else if (redBox(PS)) {
                demandeERROR=true
            }
            else demandeERROR=false;

         }
         return demandeERROR;
    }

    function verificationDensite(){
        let densiteERROR
        for (let i = 0; i < nbEch; i++) {
            let M="#masse"+i;
            let T="#temperature"+i;
            let Vo="#v_initial"+i;
            let V1="#v_1"+i;

            if (redBox(M)) {
                densiteERROR=true
            }
            else if (redBox(T)) {
                densiteERROR=true
            }
            else if (redBox(Vo)) {
                densiteERROR=true
            }
            else if (redBox(V1)) {
                densiteERROR=true
            }
            else densiteERROR=false;

         }
         return densiteERROR;
    }

    function verificationPF(){
        let pfERROR
        for (let i = 0; i < nbEch; i++) {
            let MC="#masse_c"+i;
            let T="#temperature"+i;
            let Mo="#masse_o"+i;
            let M2h="#masse_2h"+i;

            if (redBox(MC)) {
                pfERROR=true
            }
            else if (redBox(T)) {
                pfERROR=true
            }
            else if (redBox(Mo)) {
                pfERROR=true
            }
            else if (redBox(M2h)) {
                pfERROR=true
            }
            else pfERROR=false;

         }
         return pfERROR;
    }

    function verificationVolumetrie(){
        let volERROR
        for (let i = 0; i < nbEch; i++) {
             let VETDA="#vol"+i;
            let ref='ref'+i;



            if (redBox(VETDA)) {
                volERROR=true
            }
            else volERROR=false;

         }
         return volERROR;
    }


    let nbEch=+$('#nombreEchantillon').val();


    $('#calculer').on('click',function () {
         //--------------------------------sur le champ demandeur-----------
            let error=verification();
         if (!error) {


            for (let i = 0; i < nbEch; i++) {
                let PT="#poidsTare"+i
                let PH="#poidsHumide"+i
                let PS="#poidsSeche"+i
                let P="#poids"+i;
                let EAU="#eau"+i;
                let pt=+$(PT).val()
                let ps=+$(PS).val()
                let ph=+$(PH).val()
                console.log(ps)
                console.log(pt)
                let p=ps-pt
                if (pt>ps) {
                    let error=redBox(PT);
                     error=redBox(PS)
                     $(P).text("Poids tare >Poids seche ");
                }else
                 $(P).text(arrondi(p));
                 let res2=((ph-p)/ph)*100;

                $(EAU).text(arrondi(res2))

            }
        }
    })


    $('#calculerDensite').on('click',function () {
        //--------------------------------sur le champ demandeur-----------
           let errorDensite=verificationDensite();
        if (!errorDensite) {


           for (let i = 0; i < nbEch; i++)
           {
                let M="#masse"+i;
                let T="#temperature"+i;
                let Vo="#v_initial"+i;
                let V1="#v_1"+i;
                let V="#volume"+i;
                let D="#densite"+i;
                let m=+$(M).val()
                let t=+$(T).val()
                let vo=+$(Vo).val()
                let v1=+$(V1).val()
               let v=v1-vo
               let d=m/v
               if (vo>=v1 ) {
                    $(V).text(" Erreur:Vo >V1 ");
                }else
                $(V).text(arrondi(v));
                $(D).text(arrondi(d))

           }
       }
   })


   $('#calculerPF').on('click',function () {
    //--------------------------------sur le champ demandeur-----------
       let errorPF = verificationPF();
    if (!errorPF) {


       for (let i = 0; i < nbEch; i++)
       {
            let MC="#masse_c"+i;
            let Mo="#masse_o"+i;
            let M2h="#masse_2h"+i;
            let M="#masse"+i;
            let PF="#pf"+i;
            let mc=+$(MC).val()
            let mo=+$(Mo).val()
            let m2h=+$(M2h).val()
           let m=m2h-mc
           let pf=((mo-m)/mo)*100
           if (mc>=m2h ) {
                $(M).text(" Erreur:MCreuset >M.(2h) ");
            }else
                $(M).text(arrondi(m));
            if (mo!=0) {
                $(PF).text(arrondi(pf))
            }


       }
   }
    })

    $('#calculerConcentration').on('click',function () {
        //--------------------------------sur le champ demandeur-----------
           let errorVOL = verificationVolumetrie();

        if (!errorVOL) {
            let temoinVal=+$('#temoinVal').val()
            let temoinMasse=+$('#masseTemoin').val()
         //    les sd1
             let sd2_m=+$('#m_sd2').val()
             let sd2_v=+$('#v_sd2').val()
             let sd1_m=+$('#m_sd1').val()
             let sd1_v=+$('#v_sd1').val()
            let temoinVol=$('#volTemoin').val()
            let const1=(sd1_m/sd1_v)*100
            let const2=(sd2_m/sd2_v)*100
            let SD1=const1*(temoinVol/temoinMasse)
            let SD2=const2*(temoinVol/temoinMasse)
            $('#std1Temoin').text(SD1)
            $('#std2Temoin').text(SD2)
           for (let i = 0; i < nbEch; i++)
           {
                let VETDA="#vol"+i;
                let masse="#masse"+i
                let std1="#std1_"+i;
                let std2="#std2_"+i;
                let correct="#corect_"+i;
                let v_ech=+$(VETDA).val()
                let m_ech=+$(masse).val()
                let p1=const1*(v_ech/m_ech)
                let p2=const2*(v_ech/m_ech)
                let correctResult=(temoinVal/SD1)*p1
                $(std1).text(arrondi(p1))
                $(std2).text(arrondi(p2))
                $(correct).text(arrondi(correctResult))
           }
       }
        })

    // laboration d'absorption calcul et verification
    function verificationAbsorption(elemt){
        let volERROR
        let ech="#nombreEchantillon"+elemt
        let Nbech=+$(ech).val()
        console.log(Nbech);
        for (let i = 0; i <Nbech; i++) {
            let volD="#vol"+elemt+"_"+i;
            let PD="#pd"+elemt+"_"+i;
            if (redBox(volD)) {
                volERROR=true
            }
            else if (redBox(PD)) {
                volERROR=true
            }
            else if (redBox('#teneurCertifie'+elemt)) {
                volERROR=true
            }
            else if(redBox('#lecture'+elemt)) {
                volERROR=true
            }
            else if(redBox('#masse'+elemt)) {
                volERROR=true
            }
            else if(redBox('#volumeD'+elemt)) {
                volERROR=true
            }
            else if(redBox('#PD'+elemt)) {
                volERROR=true
            }
            else volERROR=false;

         }
         return volERROR;
    }
    $('.calculer').on('click',function () {
        var elem=$(this).attr('id');
        let ech="#nombreEchantillon"+elem
        let Nbech=+$(ech).val()
        //--------------------------------sur le champ demandeur-----------
        let errorVOL = verificationAbsorption(elem);
        console.log(1);

        if (!errorVOL) {
            console.log(2);
            let TC=+$('#teneurCertifie'+elem).val()
            let lecture=+$('#lecture'+elem).val()
            let temoinMasse=+$('#masse'+elem).val()
            let volumePC=+$('#volumePC'+elem).val()
            let VD=+$('#volumeD'+elem).val()
            let PDT=+$('#PD'+elem).val()
            let TCal=((lecture*volumePC)/(temoinMasse*VD))/PDT
            let coef=TC/TCal // coeffiient du temoin
            $('#teneurCalcul'+elem).text(TCal)
            $('#coefCor'+elem).text(coef)

           for (let i = 0; i < Nbech; i++)
           {
               console.log(3);
                let volD="#vol"+elem+"_"+i;
                let PD="#pd"+elem+"_"+i;
                let teneur="#t"+elem+"_"+i;
                let cctin="#c"+elem+"_"+i;
                let lec="#lec"+elem+"_"+i
                let m_pc="#maPC_"+elem+"_"+i;
                let v_pc="#volPC_"+elem+"_"+i;
                let volVD=+$(volD).val() // le volume Dilue dans AA
                let pd=+$(PD).val() // Le PD de la AA
                let lect=+$(lec).text() // la valuebr de la lecture
                let M=+$(m_pc).text() // la masse en preparation chimique
                console.log("M= "+M);

                let volPC= +$(v_pc).text() // le volume dans la salle
                console.log("vpc= "+volPC);
                let T=((lect*volPC)/(M*volVD))/pd // le teneur
                let C=T*coef // ppm correction
                $(teneur).text(arrondi(T))
               $(cctin) .text(arrondi(C))
           }
        }
    })



})
