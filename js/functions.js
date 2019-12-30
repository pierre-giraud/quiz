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
                            $('#tableuser').replaceWith("<p>Vous n'avez aucun quiz</p>");
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
                            $('#tablequiz').replaceWith("<p>Vous n'avez aucun quiz</p>");
                        }

                        if ($('#tablequizadmin tr').length === 1) {
                            $('#tablequizadmin').replaceWith("<p>Aucun quiz enregistré</p>");
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
                            $('#tablequizadmin').replaceWith("<p>Aucun quiz enregistré</p>");
                            $('#suppr_quiz_admin').remove();
                        }

                        if ($('#tablequiz tr').length === 2) {
                            $('#tablequiz').replaceWith("<p>Vous n'avez aucun quiz</p>");
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
        let divenonce = $("<div id='enonce_question" + nb_Questions + "'></div>");
        let labelquestion = "<br><label for='enonce" + nb_Questions + "'>Question " + nb_Questions + "</label><br>";
        let textareaquestion = "<textarea id='enonce" + nb_Questions + "' name='enonce" + nb_Questions + "'></textarea>";

        let divreponses = $("<div id='reponses_question" + nb_Questions + "'></div>");
        let txttitre = $("<p></p>").text("Réponses à la question " + nb_Questions);
        let table = $("<table></table>");
        let row1 = $("<tr></tr>");
        let col1row1 = $("<td></td>");
        let labelrep1 = $("<label for='reponse1q" + nb_Questions + "'></label><br>").text("Réponse 1");
        let textareareponse1 = $("<textarea id='reponse1q" + nb_Questions + "' name='reponse1q" + nb_Questions + "'></textarea>");
        let col2row1 = $("<td></td>");
        let labelrep2 = $("<label for='reponse2q" + nb_Questions + "'></label><br>").text("Réponse 2");
        let textareareponse2 = $("<textarea id='reponse2q" + nb_Questions + "' name='reponse2q" + nb_Questions + "'></textarea>");
        let row2 = $("<tr></tr>");
        let col1row2 = $("<td></td>");
        let labelrep3 = $("<label for='reponse3q" + nb_Questions + "'></label><br>").text("Réponse 3");
        let textareareponse3 = $("<textarea id='reponse3q" + nb_Questions + "' name='reponse3q" + nb_Questions + "'></textarea>");
        let col2row2 = $("<td></td>");
        let labelrep4 = $("<label for='reponse4q" + nb_Questions + "'></label><br>").text("Réponse 4");
        let textareareponse4 = $("<textarea id='reponse4q" + nb_Questions + "' name='reponse4q" + nb_Questions + "'></textarea>");

        let divRadioButtons = $("<div style='display: flex; align-items: center;'></div>");
        let textRadios = $("<p></p>").text("Réponse correcte : ");
        let radio1 = $("<input type='radio' id='rep1q" + nb_Questions + "' name='choix_repq" + nb_Questions + "' value='0' checked>");
        let labelradio1 = $("<label for='rep1q" + nb_Questions + "'></label>").text("Réponse 1");
        let radio2 = $("<input type='radio' id='rep2q" + nb_Questions + "' name='choix_repq" + nb_Questions + "' value='1'>");
        let labelradio2 = $("<label for='rep2q" + nb_Questions + "'></label>").text("Réponse 2");
        let radio3 = $("<input type='radio' id='rep3q" + nb_Questions + "' name='choix_repq" + nb_Questions + "' value='2'>");
        let labelradio3 = $("<label for='rep3q" + nb_Questions + "'></label>").text("Réponse 3");
        let radio4 = $("<input type='radio' id='rep4q" + nb_Questions + "' name='choix_repq" + nb_Questions + "' value='3'>");
        let labelradio4 = $("<label for='rep4q" + nb_Questions + "'></label>").text("Réponse 4");

        col1row1.append(labelrep1, textareareponse1);
        col2row1.append(labelrep2, textareareponse2);
        col1row2.append(labelrep3, textareareponse3);
        col2row2.append(labelrep4, textareareponse4);
        row1.append(col1row1, col2row1);
        row2.append(col1row2, col2row2);
        table.append(row1, row2);
        divRadioButtons.append(textRadios, radio1, labelradio1, radio2, labelradio2, radio3, labelradio3, radio4, labelradio4);
        divreponses.append(txttitre, table, divRadioButtons);
        divenonce.append(labelquestion, textareaquestion);

        $('#questions').append(divenonce, divreponses);
    });

    // Fonction utilisée à chaque tentative d'envoie du formulaire d'inscription
    $('#inscription_form').submit(function(){
        return isFormInscriptionOK();
    });

    // Fonction utilisée à chaque tentative d'envoie du formulaire de création de quiz
    $('#form_create_quiz').submit(function (){
        alert(isFormQuizOK());
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
    $('#resultats_quiz').css('display', 'block');

    $.ajax({
        url: 'user/ajax.php',
        type: 'post',
        data: {
            get_infos_quiz: true
        },
        success: function (results) {
            let resultats = JSON.parse(results);
            let nb_rep_correctes = 0;
            let nb_rep = 0;
            console.log(resultats);
            console.log(resultats['quiz'])
            console.log(resultats['resultats'])

            for (nb_rep = 0; nb_rep < resultats['resultats'].length; nb_rep++){
                console.log(resultats['resultats'][nb_rep]);
                console.log('table tr.trquestionsres #repres' + resultats['resultats'][nb_rep]);
                console.log("CORRECTE ? " + resultats['quiz']['questions'][nb_rep]['reponses'][resultats['resultats'][nb_rep]]['iscorrect_reponse']);

                let reponse = $('#tablequestionres' + nb_rep + ' tr.trquestionsres #repres' + resultats['resultats'][nb_rep]);
                let correctfield = $('#correctornot' + nb_rep);
                if (resultats['quiz']['questions'][nb_rep]['reponses'][resultats['resultats'][nb_rep]]['iscorrect_reponse'] === '1'){
                    reponse.css('background-color', '#3ec46d');
                    correctfield.text("Correct").css('color', 'green');
                    nb_rep_correctes++;
                } else {
                    reponse.css('background-color', 'red');
                    correctfield.text("Faux").css('color', 'red');
                }
            }

            $('#nbreponsescorrectes').text('Nombre de réponses correctes : ' + nb_rep_correctes + ' / ' + nb_rep);
        },
        error: function () {
            alert('Erreur AJAX');
        }
    });
}