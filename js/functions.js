$(document).ready(function(){
    let page = $(location).attr('pathname').split('/').pop(); // Page courante
    let nb_Questions = $('div .div_question').length;               // Nombre de questions du quiz affiché
    let num_question_quiz = 0; // Numéro de la question actuellement en cours de traitement

    // Fonction lors d'un clic pour supprimer un utilisateur
    $('#suppr_user').click(function(){
        let id_user = [];

        // Récupération des identifiants d'utilisateur
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
                        alert('Une erreur de communication est survenue, veuillez retenter ultérieurement');
                    }
                });
            }
        }
    });

    // Fonction lors d'un clic pour supprimer un de ses propres quiz
    $('#suppr_quiz').click(function(){
        let id_quiz = [];

        // Récupération des identifiants des quiz
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
                        // Suppression des lignes concernées
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
                        alert('Une erreur de communication est survenue, veuillez retenter ultérieurement');
                    }
                });
            }
        }
    });

    // Fonction lors d'un clic sur le bouton de suppression de quiz depuis la liste administrateur
    $('#suppr_quiz_admin').click(function(){
        let id_quiz = [];

        // Récupération des identifiants des quiz
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
                        // Suppression des lignes concernées
                        for (let i = 0; i < id_quiz.length; ++i) {
                            $('tr#rowqa_' + id_quiz[i] + '').remove();
                            if ($('tr#rowq_' + id_quiz + '').length > 0) $('tr#rowq_' + id_quiz[i] + '').remove();
                        }

                        // Si le tableau ne contient plus de quiz, on le supprime
                        if ($('#tablequizadmin tr').length === 1) {
                            $('#tablequizadmin').parent().replaceWith("<p>Aucun quiz enregistré</p>");
                            $('#suppr_quiz_admin').remove();
                        }

                        // Si le tableau de quiz personnels ne contient plus de quiz
                        if ($('#tablequiz tr').length === 2) {
                            $('#tablequiz').parent().replaceWith("<p>Vous n'avez aucun quiz</p>");
                        }
                    },
                    error: function () {
                        alert('Une erreur de communication est survenue, veuillez retenter ultérieurement');
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
                // Création d'une popup
                let body = $('body');
                let popup = $("<div class='popup-visible' id='popup'></div>");
                let msg = $("<article class='message is-success'></article>");

                let msgheader = $("<div class='message-header'></div>");
                let msgtitle = $("<p></p>").text("Success");
                let btnquit = $("<button class='delete' aria-label='delete' id='del-popup'></button>");

                let msgbody = $("<div class='message-body'></div>");
                let textmsg = $("<p></p>").text("Les quiz sélectionnés seront visibles sur la page d'accueil !");

                msgheader.append(msgtitle, btnquit);
                msgbody.append(textmsg);
                msg.append(msgheader, msgbody);
                popup.append(msg);
                body.append(popup);

                // Affectation de la fonction événementtielle pour un clic sur la croix
                body.on('click', '#del-popup', function () {
                    $('#popup').remove();
                });
            },
            error: function () {
                alert('Une erreur de communication est survenue, veuillez retenter ultérieurement');
            }
        });
    });

    // Clic sur le bouton d'ajout de questions d'un formulaire
    $('#btn_add_question').click(function(){
        nb_Questions++;

        let divenonce = $("<div class='field div_question' id='enonce_question" + nb_Questions + "'></div>");
        let divcontrolenonce = $("<div class='control'></div>");
        let labelquestion = "<label class='label' for='enonce" + nb_Questions + "'>Question " + nb_Questions + "</label>";
        let textareaquestion = "<textarea class='textarea is-primary is-small' id='enonce" + nb_Questions + "' name='enonce" + nb_Questions + "' placeholder='Texte de la question " + nb_Questions + " ...'></textarea>";
        let phrasewarningenonce = $("<p class='hidden-msg-w help is-danger'>Une question doit avoir un énoncé</p>");

        let divreponses = $("<div class='div_reponses' id='reponses_question" + nb_Questions + "'></div>");
        let txttitre = $("<br><h4>Réponses à la question " + nb_Questions + "</h4><br>");

        let divfieldrep1 = $("<div class='field'></div>");
        let divcontrolrep1 = $("<div class='control'></div>");
        let labelrep1 = $("<label class='label labelrep' for='reponse1q" + nb_Questions + "'>Réponse 1</label>");
        let textareareponse1 = $("<textarea class='textarea is-info is-small' id='reponse1q" + nb_Questions + "' name='reponse1q" + nb_Questions + "' placeholder='Texte de la réponse 1 ...'></textarea>");
        let phrasewarningrep1 = $("<p class='hidden-msg-w help is-danger'>Cette réponse ne doit pas être vide</p>");

        let divfieldrep2 = $("<div class='field'></div>");
        let divcontrolrep2 = $("<div class='control'></div>");
        let labelrep2 = $("<label class='label labelrep' for='reponse2q" + nb_Questions + "'>Réponse 2</label>");
        let textareareponse2 = $("<textarea class='textarea is-info is-small' id='reponse2q" + nb_Questions + "' name='reponse2q" + nb_Questions + "' placeholder='Texte de la réponse 2 ...'></textarea>");
        let phrasewarningrep2 = $("<p class='hidden-msg-w help is-danger'>Cette réponse ne doit pas être vide</p>");

        let divfieldrep3 = $("<div class='field'></div>");
        let divcontrolrep3 = $("<div class='control'></div>");
        let labelrep3 = $("<label class='label labelrep' for='reponse3q" + nb_Questions + "'>Réponse 3</label>");
        let textareareponse3 = $("<textarea class='textarea is-info is-small' id='reponse3q" + nb_Questions + "' name='reponse3q" + nb_Questions + "' placeholder='Texte de la réponse 3 ...'></textarea>");

        let divfieldrep4 = $("<div class='field'></div>");
        let divcontrolrep4 = $("<div class='control'></div>");
        let labelrep4 = $("<label class='label labelrep' for='reponse4q" + nb_Questions + "'>Réponse 4</label>");
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

        divenonce.append("<br><hr><br>", divcontrolenonce, phrasewarningenonce);
        divreponses.append(txttitre, divfieldrep1, "<br>", divfieldrep2, "<br>", divfieldrep3, "<br>", divfieldrep4, "<br>", divrepcorrectes, divfieldbtn);

        $('#questions').append(divenonce, divreponses);

        // Si le bouton Suppresion de question est désactivé, on le réactive
        if (nb_Questions > 1 && $('#btn_suppr_question1')[0].hasAttribute('disabled')){
            $('#btn_suppr_question1').removeAttr('disabled');
        }
    });

    // Si on se situe sur les pages de création ou administration des quiz
    if ((page === 'create_quiz.php' || page === 'admin_quiz.php') && nb_Questions === 1) {
        $('#btn_suppr_question1').attr('disabled', 'true');
    }

    // Clic sur un des boutons de suppression de question
    $('#questions').on('click', 'button[id*="btn_suppr_question"]', function () {
        if (page === 'create_quiz.php'){
            let num_question = parseInt($(this).attr('id').substr(18));

            // Suppression des éléments concernant la question à retirer
            $('#enonce_question' + num_question).remove();
            $('#reponses_question' + num_question).remove();
            nb_Questions--;

            // Parcours des éléments de classe "div_question" pour décrémenter le numéro de la question si supérieur à celui de la question supprimée
            $('.div_question').each(function () {
                let n_question = parseInt($(this).attr('id').substr(15));
                let num_q = n_question - 1;

                if (n_question > num_question){
                    $(this).attr('id', 'enonce_question' + num_q);
                    $(this).find('label').attr('for', 'enonce' + num_q).text('Question ' + num_q);
                    $(this).find('textarea').attr('id','enonce' + num_q).attr('name', 'enonce' + num_q).attr('placeholder', 'Texte de la question ' + num_q + " ...");
                }
            });

            // Parcours des éléments de classe "div_reponses" pour décrémenter le numéro de la question si supérieur à celui de la question supprimée
            $('.div_reponses').each(function () {
                let n_question = parseInt($(this).attr('id').substr(17));
                let num_q = n_question - 1;

                if (n_question > num_question){
                    let num_elem = 1;

                    $(this).attr('id', 'reponses_question' + num_q);
                    $(this).find('h4').text('Réponses à la question ' + num_q + ' :');

                    $(this).find('.labelrep').each(function () {
                        $(this).attr('for', 'reponse' + num_elem + 'q' + num_q);
                        $(this).siblings().attr('id', 'reponse' + num_elem + 'q' + num_q).attr('name', 'reponse' + num_elem + 'q' + num_q );
                        num_elem++;
                    });

                    num_elem = 1;

                    $(this).find('.radio').each(function () {
                        $(this).attr('for', 'rep' + num_elem + 'q' + num_q);
                        $(this).children().attr('id', 'rep' + num_elem + 'q' + num_q).attr('name', 'choix_repq' + num_q);
                        num_elem++;
                    });

                    $(this).find('.button').attr('id', 'btn_suppr_question' + num_q).attr('value', "" + (num_q - 1));
                }
            });

            // Si le nombre de question est de 1, on désactive le bouton de suppression de question
            if (nb_Questions < 2) $('#btn_suppr_question1').attr('disabled', 'true');
        } else {
            alert("non opérationnel");
        }
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
                alert('Une erreur de communication est survenue, veuillez retenter ultérieurement');
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
            dataType: 'json',
            success: function (liste_quiz) {
                for (let key in liste_quiz){
                    if (liste_quiz[key]['ispublic_quiz'] === '1'){
                        $('#pquiz_' + key).prop('checked', true);
                    }
                }
            },
            error: function () {
                alert('Une erreur de communication est survenue, veuillez retenter ultérieurement');
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

// Fonction d'affichage des résultats du quiz
function showResultatsQuiz() {
    // Affichage de la partie résultats
    $('#resultats_quiz').removeClass('hidden-msg-w');

    $.ajax({
        url: 'user/ajax.php',
        type: 'post',
        data: {
            get_infos_quiz: true
        },
        dataType: 'json',
        success: function (results) {
            let nb_rep_correctes = 0;
            let num_q;

            $('h2').text('Résultat du quiz "' + results['quiz']['quiz']['titre_quiz'] + '"');

            // Vérification des bonnes réponses
            for (num_q = 0; num_q < results['resultats'].length; num_q++){
                let reponse = $('#tablequestionres' + num_q + ' tr.trquestionsres #repres' + results['resultats'][num_q]);
                let correctfield = $('#correctornot' + num_q);
                if (results['quiz']['questions'][num_q]['reponses'][results['resultats'][num_q]]['iscorrect_reponse'] === '1'){
                    reponse.css('background-color', '#3ec46d');
                    correctfield.text("Correct").css('color', 'green');
                    nb_rep_correctes++;
                } else {
                    reponse.css('background-color', '#ff5b5b');
                    correctfield.text("Faux").css('color', 'red');

                    // Ajout d'un fond vert à la bonne réponse en cas de mauvaise réponse
                    for (let i = 0; i < results['quiz']['questions'][num_q]['reponses'].length; ++i) {
                        if (results['quiz']['questions'][num_q]['reponses'][i]['iscorrect_reponse'] === '1'){
                            $('#tablequestionres' + num_q + ' tr.trquestionsres #repres' + i).css('background-color', '#3aa553');
                        }
                    }
                }
            }

            // Ajout du texte indiquant le nombre de bonnes réponses
            $('#nbreponsescorrectes').text('Nombre de réponses correctes : ' + nb_rep_correctes + ' / ' + num_q);
        },
        error: function () {
            alert('Une erreur de communication est survenue, veuillez retenter ultérieurement');
        }
    });
}