<?php

$page_title = "Création d'un quiz - Quiz 2019";

include('../header.php');

if (!isset($_SESSION['user'])) header('location: ../login.php'); // Si l'utilisateur n'est pas connecté, redirection
?>

<section>
    <h2>Création d'un quiz</h2>

    <form id="form_create_quiz" action="../home.php" method="post">
        <div>
            <label for="quizname">Titre du quiz</label>
            <input type="text" id="quizname" name="quizname">
        </div>
        <div>
            <button type="submit" name="btn_confirm_creation_quiz">Créer</button>
        </div>
    </form>
</section>

<?php include ('../footer.php');

