$(document).ready(function(){
    let form_inscription = $('#inscription_form');

    // Fonction lors d'un clic pour supprimer un utilisateur
    $('#suppr_user').click(function(){
       if (confirm("Êtes-vous sûr de vouloir supprimer les utilisateurs sélectionnés ?")) {
           let id_user = [];

           $(':checkbox:checked').each(function(i){
               id_user[i] = $(this).val();
           });

           if (id_user.length > 0){
               $.ajax({
                   url: 'util/suppression_utilisateur.php',
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
            /*$.post("util/suppression_utilisateur.php",
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
});