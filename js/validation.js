/*
Fonction permettant de valider ou non le formulaire en ajoutant la classe
"error" quand les champs sont incorrects
 */
function validerFormulaire(){
    let form = document.getElementById('inscription_form');
    let username = form['username'];
    let password1 = form['password1'];
    let password2 = form['password2'];

    // Nom d'utilisateur
    if (username.value.length < 4 || username.value.length > 25){
        username.className = "error";
    } else {
        username.className = "none";
    }

    // Mot de passe
    if (password1.value === ''){
        password1.className = "error";
    } else {
        password1.className = "none";
    }

    // Confirmation du mot de passe
    if (password2.value === '' || password2.value !== password1.value){
        password2.className = "error";
    } else {
        password2.className = "none";
    }
}

/*
Fonction indiquant si le formulaire d'inscription est correctement rempli
 */
function isFormOK(){
    //validerFormulaire();
    //alert("ok");

    return true;
}