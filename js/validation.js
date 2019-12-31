/*
Fonction permettant de valider ou non le formulaire d'inscription en ajoutant la classe
"error" quand les champs sont incorrects
 */
function validerFormulaireInscription(){
    let form = $('#inscription_form');
    let username = form.find('input[name="username"]');
    let password1 = form.find('input[name="password1"]');
    let password2 = form.find('input[name="password2"]');

    // Nom d'utilisateur
    if ($.trim(username.val()).length < 4 || $.trim(username.val()).length > 25){
        username.addClass('is-danger');
        username.addClass("error");
        username.removeClass('is-success');
        $('#msg-incorrect-username').removeClass('hidden-msg-w');
    } else {
        username.removeClass('is-danger');
        username.removeClass("error");
        username.addClass('is-success');
        $('#msg-incorrect-username').addClass('hidden-msg-w');
    }

    // Mot de passe
    toggleClassError(password1);

    // Confirmation du mot de passe
    if ($.trim(password2.val()) < 1 || password2.val() !== password1.val()){
        password2.addClass('is-danger');
        password2.addClass("error");
    } else {
        password2.removeClass('is-danger');
        password2.removeClass("error");
    }
}

/*
Fonction permettant de valider ou non le formulaire d'inscription en ajoutant la classe
"error" quand les champs sont incorrects
 */
function validerFormulaireQuiz() {
    let form = $('#form_create_quiz');
    let quizname = form.find('input[name="quizname"]');

    toggleClassError(quizname);

    /*if ($.trim(quizname.val()) < 1) {
        //$('#msg-incorrect-quizname').removeClass('hidden-msg-w');
        quizname.parent().siblings().removeClass('hidden-msg-w');
    } else {
        //$('#msg-incorrect-quizname').addClass('hidden-msg-w');
        quizname.parent().siblings().addClass('hidden-msg-w');
    }*/

    // Textareas
    $('form#form_create_quiz textarea').each(function () {
        if ($(this).attr('name').indexOf('enonce') >= 0){
            toggleClassError($(this));
        } else if ($(this).attr('name').indexOf('reponse1') >= 0) {
            toggleClassError($(this));
        } else if ($(this).attr('name').indexOf('reponse2') >= 0){
            toggleClassError($(this));
        }
    });

    // Radio Buttons
    form.find("input[type='radio']").each(function () {
        console.log("radio : " + $(this).attr('name'));
        console.log("radio val : " + $(this).attr('value'));
        console.log("radio checked ? : " + $(this).is(':checked'));
        if ($(this).is(':checked')){
            let num_question = $(this).attr('name').substring(10);
            let num_reponse = (parseInt(($(this).attr('value'))) + 1);
            console.log('num q : ' + num_question);
            console.log("test : " + '#reponse' + num_reponse + 'q' + num_question);
            if ($.trim($('#reponse' + num_reponse + 'q' + num_question).val()).length < 1){
                $(this).addClass("error");
            } else {
                $(this).removeClass("error");
            }
        } else {
            $(this).removeClass("error");
        }
    });
}

/*
Fonction indiquant si le formulaire d'inscription est correctement rempli
 */
function isFormInscriptionOK(){
    let retVal = true;

    validerFormulaireInscription();

    $('form#inscription_form :input').each(function(){
        if ($(this).hasClass('error')) {
            retVal = false;
        }
    });

    return retVal;
}

/*
Fonction indiquant si le formulaire de création de quiz est correctement rempli
 */
function isFormQuizOK(){
    let retVal = true;

    validerFormulaireQuiz();

    $('form#form_create_quiz :input').each(function () {
        if ($(this).hasClass('error')) {
            retVal = false;
        }
    });

    $('form#form_create_quiz textarea').each(function () {
        if ($(this).hasClass('error')) {
            retVal = false;
        }
    });

    return retVal;
}

function toggleClassError(elem){
    if ($.trim(elem.val()).length < 1){
        elem.addClass("is-danger");
        elem.removeClass("is-success");
        elem.addClass("error");
        elem.parent().siblings().removeClass('hidden-msg-w');
    } else {
        elem.removeClass("is-danger");
        elem.addClass("is-success");
        elem.removeClass("error");
        elem.parent().siblings().addClass('hidden-msg-w');
    }
}