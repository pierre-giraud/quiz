$(document).ready(function(){
    let form_inscription = $('#inscription_form');
    let nb_Questions = 1;

    // Fonction lors d'un clic pour supprimer un utilisateur
    $('#suppr_user').click(function(){
       if (confirm("Êtes-vous sûr de vouloir supprimer les utilisateurs sélectionnés ?")) {
           let id_user = [];

           $(':checkbox:checked').each(function(i){
               id_user[i] = $(this).val();
           });

           if (id_user.length > 0){
               $.ajax({
                   url: 'user/suppression_utilisateur.php',
                   type: 'post',
                   data: {
                       id_user: id_user
                   },
                   success:function(){
                       for (let i = 0; i < id_user.length; ++i) {
                           $('tr#row_' + id_user[i] + '').css('background-color', '#cdaa90');
                           $('tr#row_' + id_user[i] + '').fadeOut('slow');
                       }
                   },
                   error:function(){
                       alert('Erreur AJAX');
                   }
               });
            /*$.post("user/suppression_utilisateur.php",
            {
                id_user: id_user
            },
            function(){
                alert('kek');
                for (id in id_user){
                    $('tr#' + id).css('background-color', '#cdaa90');
                    $('tr#' + id).fadeOut('slow');
            }});*/
           }
       }
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
});