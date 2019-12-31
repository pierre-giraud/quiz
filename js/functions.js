$(document).ready(function(){
    // Fonction lors d'un clic pour supprimer un utilisateur
    $('#suppr_user').click(function(){
        let id_user = [];

        $('#choix_user:checked').each(function(i){
            id_user[i] = $(this).val();
        });

        if (id_user.length > 0){
            if (confirm("Êtes-vous sûr de vouloir supprimer les utilisateurs sélectionnés ?")) {
                $.ajax({
                    url: 'ajax.php',
                    type: 'post',
                    data: {
                        id_user: id_user
                    },
                    success:function(){
                        for (let i = 0; i < id_user.length; ++i) {
                            $('tr#rowu_' + id_user[i] + '').remove();
                        }

                        // Si il n'y a plus d'utilisateurs enregistrés, on supprime le tableau
                        if ($('#tableuser tr').length === 1){
                            $('#tableuser').parent().replaceWith("<p>Aucun utilisateur n'est enregistré !</p>");
                            $('#suppr_user').remove();
                        }
                    },
                    error:function(){
                        alert('Erreur AJAX');
                    }
                });
            }
        }
    });

    // Fonction lors d'un clic pour supprimer un de ses propres quiz
    $('#suppr_quiz').click(function(){
        let id_quiz = [];

        $('#choix_quiz:checked').each(function(i){
            id_quiz[i] = $(this).val();
        });

        if (id_quiz.length > 0) {
            if (confirm("Êtes-vous sûr de vouloir supprimer les quiz sélectionnés ?")) {
                $.ajax({
                    url: 'ajax.php',
                    type: 'post',
                    data: {
                        id_quiz: id_quiz
                    },
                    success: function () {
                        for (let i = 0; i < id_quiz.length; ++i) {
                            $('tr#rowq_' + id_quiz[i] + '').remove();
                            if ($('tr#rowqa_' + id_quiz + '').length > 0) $('tr#rowqa_' + id_quiz[i] + '').remove();
                        }

                        // Si le tableau ne contient plus de quiz, on le supprime
                        if ($('#tablequiz tr').length === 2) {
                            $('#tablequiz').parent().replaceWith("<p>Vous n'avez aucun quiz</p>");
                        }

                        if ($('#tablequizadmin tr').length === 1) {
                            $('#tablequizadmin').parent().replaceWith("<p>Aucun quiz enregistré</p>");
                            $('#suppr_quiz_admin').remove();
                        }
                    },
                    error: function () {
                        alert('Erreur AJAX');
                    }
                });
            }
        }
    });

    // Fonction lors d'un clic sur le bouton de suppression de quiz depuis la liste administrateur
    $('#suppr_quiz_admin').click(function(){
        let id_quiz = [];

        $('#choix_quiz_admin:checked').each(function(i){
            id_quiz[i] = $(this).val();
        });

        if (id_quiz.length > 0) {
            if (confirm("Êtes-vous sûr de vouloir supprimer les quiz sélectionnés ?")) {
                $.ajax({
                    url: 'ajax.php',
                    type: 'post',
                    data: {
                        id_quiz: id_quiz
                    },
                    success: function () {
                        for (let i = 0; i < id_quiz.length; ++i) {
                            $('tr#rowqa_' + id_quiz[i] + '').remove();
                            if ($('tr#rowq_' + id_quiz + '').length > 0) $('tr#rowq_' + id_quiz[i] + '').remove();
                        }

                        // Si le tableau ne contient plus de quiz, on le supprime
                        if ($('#tablequizadmin tr').length === 1) {
                            $('#tablequizadmin').parent().replaceWith("<p>Aucun quiz enregistré</p>");
                            $('#suppr_quiz_admin').remove();
                        }

                        if ($('#tablequiz tr').length === 2) {
                            $('#tablequiz').parent().replaceWith("<p>Vous n'avez aucun quiz</p>");
                        }
                    },
                    error: function () {
                        alert('Erreur AJAX');
                    }
                });
            }
        }
    });

    // Fonction lors d'un clic sur ke bouton valider pour rendre public des quiz
    $('#btn_set_public').click(function () {
        let id_quiz = [];
        let is_public = [];

        // Récupération des identifiants des quiz
        $("input[name='choix_public']").each(function(i){
            id_quiz[i] = $(this).val();
            is_public[i] = $(this).is(':checked');
        });

        $.ajax({
            url: 'ajax.php',
            type: 'post',
            data: {
                id_quiz_set_public: {id_quiz, is_public}
            },
            success: function () {
                let popup = $('#popup');
                popup.removeClass('popup-invisible');
                popup.addClass('popup-visible');
            },
            error: function () {
                alert('Erreur AJAX');
            }
        });
    });

    // Clic sur la fermeture de la popup
    $('#del-popup').click(function () {
        let popup = $('#popup');
        popup.removeClass('popup-visible');
        popup.addClass('popup-invisible');
    });

    let nb_Questions = $('div .div_question').length; // Nombre de questions du quiz affiché

    $('#btn_add_question').click(function(){
        nb_Questions++;

        let divenonce = $("<div class='field div_question' id='enonce_question" + nb_Questions + "'></div>");
        let divcontrolenonce = $("<div class='control'></div>");
        let labelquestion = "<label class='label' for='enonce" + nb_Questions + "'>Question " + nb_Questions + "</label>";
        let textareaquestion = "<textarea class='textarea is-primary is-small' id='enonce" + nb_Questions + "' name='enonce" + nb_Questions + "' placeholder='Texte de la question 1 ...'></textarea>";
        let phrasewarningenonce = $("<p class='hidden-msg-w help is-danger'>Une question doit avoir un énoncé</p>");

        let divreponses = $("<div id='reponses_question" + nb_Questions + "'></div>");
        let txttitre = $("<br><h4>Réponses à la question " + nb_Questions + "</h4><br>");

        let divfieldrep1 = $("<div class='field'></div>");
        let divcontrolrep1 = $("<div class='control'></div>");
        let labelrep1 = $("<label class='label' for='reponse1q" + nb_Questions + "'>Réponse 1</label>");
        let textareareponse1 = $("<textarea class='textarea is-info is-small' id='reponse1q" + nb_Questions + "' name='reponse1q" + nb_Questions + "' placeholder='Texte de la réponse 1 ...'></textarea>");
        let phrasewarningrep1 = $("<p class='hidden-msg-w help is-danger'>Cette réponse ne doit pas être vide</p>");

        let divfieldrep2 = $("<div class='field'></div>");
        let divcontrolrep2 = $("<div class='control'></div>");
        let labelrep2 = $("<label class='label' for='reponse2q" + nb_Questions + "'>Réponse 2</label>");
        let textareareponse2 = $("<textarea class='textarea is-info is-small' id='reponse2q" + nb_Questions + "' name='reponse2q" + nb_Questions + "' placeholder='Texte de la réponse 2 ...'></textarea>");
        let phrasewarningrep2 = $("<p class='hidden-msg-w help is-danger'>Cette réponse ne doit pas être vide</p>");

        let divfieldrep3 = $("<div class='field'></div>");
        let divcontrolrep3 = $("<div class='control'></div>");
        let labelrep3 = $("<label class='label' for='reponse3q" + nb_Questions + "'>Réponse 3</label>");
        let textareareponse3 = $("<textarea class='textarea is-info is-small' id='reponse3q" + nb_Questions + "' name='reponse3q" + nb_Questions + "' placeholder='Texte de la réponse 3 ...'></textarea>");

        let divfieldrep4 = $("<div class='field'></div>");
        let divcontrolrep4 = $("<div class='control'></div>");
        let labelrep4 = $("<label class='label' for='reponse4q" + nb_Questions + "'>Réponse 4</label>");
        let textareareponse4 = $("<textarea class='textarea is-info is-small' id='reponse4q" + nb_Questions + "' name='reponse4q" + nb_Questions + "' placeholder='Texte de la réponse 4 ...'></textarea>");

        let divrepcorrectes = $("<div class='field'></div>");
        let divcontrolrepco = $("<div class='control'></div>");
        let labelgroup = $("<label class='label'>Réponse correcte</label>");
        let radio1 = $("<label class='radio' for='rep1q" + nb_Questions + "'><input type='radio' id='rep1q" + nb_Questions + "' name='choix_repq" + nb_Questions + "' value='0' checked>Réponse 1</label>");
        let radio2 = $("<label class='radio' for='rep2q" + nb_Questions + "'><input type='radio' id='rep2q" + nb_Questions + "' name='choix_repq" + nb_Questions + "' value='1'>Réponse 2</label>");
        let radio3 = $("<label class='radio' for='rep3q" + nb_Questions + "'><input type='radio' id='rep3q" + nb_Questions + "' name='choix_repq" + nb_Questions + "' value='2'>Réponse 3</label>");
        let radio4 = $("<label class='radio' for='rep4q" + nb_Questions + "'><input type='radio' id='rep4q" + nb_Questions + "' name='choix_repq" + nb_Questions + "' value='3'>Réponse 4</label>");

        let divfieldbtn = $("<div class='field'></div>");
        let divcontrolbtn = $("<div class='control'></div>");
        let btn = $("<button class='button is-danger' type='button' id='btn_suppr_question" + nb_Questions + "' value='" + (nb_Questions - 1) + "'>Supprimer la question</button>");

        divcontrolenonce.append(labelquestion, textareaquestion);

        divcontrolrep1.append(labelrep1, textareareponse1);
        divcontrolrep2.append(labelrep2, textareareponse2);
        divcontrolrep3.append(labelrep3, textareareponse3);
        divcontrolrep4.append(labelrep4, textareareponse4);

        divfieldrep1.append(divcontrolrep1, phrasewarningrep1);
        divfieldrep2.append(divcontrolrep2, phrasewarningrep2);
        divfieldrep3.append(divcontrolrep3);
        divfieldrep4.append(divcontrolrep4);

        divcontrolrepco.append(labelgroup, radio1, radio2, radio3, radio4);
        divrepcorrectes.append(divcontrolrepco);

        divcontrolbtn.append(btn);
        divfieldbtn.append(divcontrolbtn);

        divenonce.append(divcontrolenonce, phrasewarningenonce);
        divreponses.append(txttitre, divfieldrep1, "<br>", divfieldrep2, "<br>", divfieldrep3, "<br>", divfieldrep4, "<br>", divrepcorrectes, divfieldbtn);

        $('#questions').append("<br><hr><br>", divenonce, divreponses);
    });

    // Fonction utilisée à chaque tentative d'envoie du formulaire d'inscription
    $('#inscription_form').submit(function(){
        return isFormInscriptionOK();
    });

    // Fonction utilisée à chaque tentative d'envoie du formulaire de création de quiz
    $('#form_create_quiz').submit(function (){
        return isFormQuizOK();
    });

    // Cochage des cases dont le quiz est public si l'on se situe dans la page profil utilisateur
    if ($(location).attr('pathname').split('/').pop() === 'home.php') public_checkboxes();

    let num_question_quiz = 0; // Numéro de la question actuellement en cours de traitement

    // Fonction utilisée lors d'un clic sur le bouton "Commencer" pour effectuer un quiz
    $('#btn_start_quiz').click(function () {
        process_quiz(num_question_quiz, true);
    });

    // Fonction utilisée lors d'un clic sur une des réponses d'un quiz
    $('table tr.trreponses td').click(function () {
        let num_reponse = $(this).attr('id').substring(3);

        $.ajax({
            url: 'user/ajax.php',
            type: 'post',
            data: {
                save_reponse: {num_question_quiz, num_reponse}
            },
            success: function () {
                process_quiz(++num_question_quiz, false)
            },
            error: function () {
                alert('Erreur AJAX');
            }
        });
    });

    // Clic sur une ligne du tableau d'utilisateurs (mode admin)
    $('tr.truser').click(function (event) {
        if (event.target.type !== 'checkbox') {
            $(':checkbox', this).trigger('click');
        }
    });

    // Clic sur une ligne du tableau de quiz (mode admin)
    $('tr.trquiz').click(function (event) {
        if (event.target.type !== 'checkbox') {
            $(':checkbox', this).trigger('click');
        }
    });

    // Recherche d'un quiz sur la page d'accueil
    $("#searchquiz").on("keyup", function() {
        let word = $(this).val().toLowerCase();
        $("a.panel-block").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(word) > -1)
        });
    });

    let num_questions_suppr = [];

    // Clic sur un des boutons de suppression de question
    $('#questions').on('click', 'button[id*="btn_suppr_question"]', function () {
        alert("non opérationnel");
    });
});

// Fonction qui vérifie quel quiz est public
function public_checkboxes() {
    let id_quiz = [];

    // Récupération des identifiants des quiz
    $("input[name='choix_public']").each(function(i){
        id_quiz[i] = $(this).val();
    });

    if (id_quiz.length > 0) {
        $.ajax({
            url: 'ajax.php',
            type: 'post',
            data: {
                id_quiz_public: id_quiz
            },
            success: function (liste_quiz) {
                let obj = JSON.parse(liste_quiz);
                for (let key in obj){
                    if (obj[key]['ispublic_quiz'] == 1){
                        $('#pquiz_' + key).prop('checked', true);
                    }
                }
            },
            error: function () {
                alert('Erreur AJAX');
            }
        });
    }
}

// Fonction de traitement de l'exécution d'un quiz
function process_quiz(num_question, begin){
    if (begin){
        $('#btn_start_quiz').hide();
        $('#tablequestion' + num_question).css('display', 'inline-block');
    } else {
        let question_suivante = $('#tablequestion' + num_question);
        if (question_suivante.length > 0){
            $('#tablequestion' + (num_question - 1)).css('display', 'none');
            question_suivante.css('display', 'inline-block');
        } else {
            $('#question_quiz').css('display', 'none');
            showResultatsQuiz();
        }
    }
}

function showResultatsQuiz() {
    $('#resultats_quiz').removeClass('hidden-msg-w');

    $.ajax({
        url: 'user/ajax.php',
        type: 'post',
        data: {
            get_infos_quiz: true
        },
        success: function (results) {
            let resultats = JSON.parse(results);
            let nb_rep_correctes = 0;
            let num_q;

            for (num_q = 0; num_q < resultats['resultats'].length; num_q++){
                let reponse = $('#tablequestionres' + num_q + ' tr.trquestionsres #repres' + resultats['resultats'][num_q]);
                let correctfield = $('#correctornot' + num_q);
                if (resultats['quiz']['questions'][num_q]['reponses'][resultats['resultats'][num_q]]['iscorrect_reponse'] === '1'){
                    reponse.css('background-color', '#3ec46d');
                    correctfield.text("Correct").css('color', 'green');
                    nb_rep_correctes++;
                } else {
                    reponse.css('background-color', '#ff5b5b');
                    correctfield.text("Faux").css('color', 'red');

                    for (let i = 0; i < resultats['quiz']['questions'][num_q]['reponses'].length; ++i) {
                        if (resultats['quiz']['questions'][num_q]['reponses'][i]['iscorrect_reponse'] === '1'){
                            $('#tablequestionres' + num_q + ' tr.trquestionsres #repres' + i).css('background-color', '#3aa553');
                        }
                    }
                }
            }

            $('#nbreponsescorrectes').text('Nombre de réponses correctes : ' + nb_rep_correctes + ' / ' + num_q);
        },
        error: function () {
            alert('Erreur AJAX');
        }
    });
}