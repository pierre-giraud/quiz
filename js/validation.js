/*
Fonction permettant de valider ou non le formulaire en ajoutant la classe
"error" quand les champs sont incorrects
 */
function validerFormulaire(){
    //let form = document.getElementById('inscription_form');
    let form = $('#inscription_form');
    let username = form.find('input[name="username"]');
    let password1 = form.find('input[name="password1"]');
    let password2 = form.find('input[name="password2"]');

    //alert('username : ' + username.val() + ' password1 : ' + password1.val() + ' p2 : ' + password2.val());

    // Nom d'utilisateur
    if (username.val().length < 4 || username.val().length > 25){
        username.addClass('error');
    } else {
        username.removeClass('error');
    }

    // Mot de passe
    if (password1.val() === ''){
        password1.addClass('error');
    } else {
        password1.removeClass('error');
    }

    // Confirmation du mot de passe
    if (password2.val() === '' || password2.val() !== password1.val()){
        password2.addClass('error');
    } else {
        password2.removeClass('error');
    }
}

/*
Fonction indiquant si le formulaire d'inscription est correctement rempli
 */
function isFormOK(){
    let retVal = true;

    /*$('form#inscription_form :input').each(function(){
        if ($(this).hasClass('error') === true) {
            retVal =  false;
        }
    });*/

    return retVal;
}