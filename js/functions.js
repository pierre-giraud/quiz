$(document).ready(function(){
    let form_inscription = $('#inscription_form');
    let nb_Questions = $('div .div_question').length; // Nombre de questions du quiz affiché

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
                        }

                        // Si le tableau ne contient plus de quiz, on le supprime
                        if ($('#tablequiz tr').length === 1) {
                            $('#tablequiz').replaceWith("<p>Vous n'avez aucun quiz</p>");
                            $('#suppr_quiz').remove();
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
                        }

                        // Si le tableau ne contient plus de quiz, on le supprime
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
            success: function (data) {
                $('body').append('<p>' + data + '</p>')
            },
            error: function () {
                alert('Erreur AJAX');
            }
        });
    });

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

        col1row1.append(labelrep1, textareareponse1);
        col2row1.append(labelrep2, textareareponse2);
        col1row2.append(labelrep3, textareareponse3);
        col2row2.append(labelrep4, textareareponse4);
        row1.append(col1row1, col2row1);
        row2.append(col1row2, col2row2);
        table.append(row1, row2);
        divreponses.append(txttitre, table);
        divenonce.append(labelquestion, textareaquestion);

        $('#questions').append(divenonce, divreponses);
    });

    //validerFormulaire();

    // Fonction utilisée à chaque modification du formulaire
    form_inscription.change(function(){
        validerFormulaire();
    });

    // Fonction utilisée à chaque tentative d'envoie du formulaire
    form_inscription.submit(function(){
        return isFormOK();
    });

    // Cochage des cases dont le quiz est public si l'on se situe dans la page profil utilisateur
    if ($(location).attr('pathname').split('/').pop() === 'home.php') public_checkboxes();
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