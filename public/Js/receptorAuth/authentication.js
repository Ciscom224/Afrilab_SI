export function receteurLogin() {
    let url = "http://127.0.0.1:8000/isLoggedIn"
    let localData

    $.get(url, (data) => {
        localData = data
    }).then(() => {
        if (!localData.isLoggedIn) {
            // $('.formReception').css({
            //     "visibility":"visible"
            // }).hide().delay().show()
            // $('.toHide').css({
            //     "filter": "blur(5px)",
            //     "cursor": "wait"
            // });
            // $('.logout').hide();
            $('.connexion').click(function() {
                let matricule = $('#conncexionMatricule').val()
                let password = $('#connexionPassword').val()
                let nameError = false
                let passwordError = false
                if (!matriculeRegex(matricule)) nameError = true
                if (password.length < 6) passwordError = true
                if (nameError || passwordError) {
                    $('.errorLogin').text("Veillez saisir correctement toutes les informations")
                } else {
                    let url = "http://127.0.0.1:8000/login"
                    let localData
                    let status
                    $.get(url, { matricule: matricule, password: password }, (data) => {
                        localData = data
                    }).then(() => {
                        status = localData.success
                        if (status) {
                            // $('.formReception').hide(100);
                            // // $('.toHide').css({
                            // //     "filter": "blur(0px)",
                            // //     "cursor": "auto"
                            // // });
                            // $('.logout').show();
                        } else {
                            $('.errorLogin').text("Aucun compte trouvé ")
                        }
                    })
                }
            });
        } else {
            // $('.formReception').hide(0);
            // $('.toHide').css({
            //     "filter": "blur(0px)",
            //     "cursor": "auto"
            // });
        }
    })
}

export function receteurRegister() {
    $('.inscription').click(function() {
        let name = $('#registerName').val()
        let matricule = $('#registerMatricule').val()
        let password = $('#registerPassword').val()
        let passwordConfirm = $('#registerPasswordComfirm').val()
        let nameError = false
        let matriculeError = false
        let passwordError = false
        if (name.length <= 2) nameError = true
        if (!matriculeRegex(matricule)) matriculeError = true
        if (password.length < 6) passwordError = true
        if (passwordConfirm.length < 6) passwordError = true

        if (nameError || passwordError || matriculeError) {
            $('.errorSignin').text("Veillez saisir correctement toutes les informations")
        } else {
            let status
            let comfirmErorStatus
            let userAlreadyExistStatus
            let url = "http://127.0.0.1:8000/register"
            let localData
            $.get(url, { name: name, password: password, comfirmPassword: passwordConfirm, matricule: matricule }, (data) => {
                localData = data
            }).then(() => {
                status = localData.success
                comfirmErorStatus = localData.comfirmError
                userAlreadyExistStatus = localData.userAlreadyExists
                if (userAlreadyExistStatus) {
                    $('.errorSignin').text("Ce matricule est déjà utilisé pour un autre compte.")
                }
                if (comfirmErorStatus) {
                    $('.errorSignin').text("Les deux mots de passe ne sont pas identiques.")
                }
                if (status) {
                    $('.formReception').hide();
                    $('.toHide').css({
                        "filter": "blur(0px)",
                        "cursor": "auto"
                    });
                    receteurLogin()
                    $('.errorSignin').text("Votre compte a été crée ; Passe à  la connexion ").css({
                        "color": "green"
                    })
                }

            })

        }
    });
}

export function logout() {
    let url = "http://127.0.0.1:8000/logout"
    $('.logout').click(() => {
        $.get(url, () => {
            document.location = "http://127.0.0.1:8000"
        })
    })
}

export function matriculeRegex(chaine) {
    let pattern = /^[A-Z][0-9]{6}[A-Z]$/
    if (pattern.test(chaine)) return true
    return false
}