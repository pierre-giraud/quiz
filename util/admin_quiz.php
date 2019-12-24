<?php

$page_title = "Administration des quiz - Quiz 2019";

include('../header.php');

if (isset($_POST['btn_create_quiz'])) : ?>
<section>
    <h2>Création d'un quiz</h2>

    <form id="form_create_quiz" action="../home.php" method="post">
        <label for="quizname">Titre du quiz</label>
        <input type="text" id="quizname" name="quizname">
    </form>
</section>
<?php else : ?>
<section>
    <p>kek</p>
</section>
<?php endif; ?>

<?php include ('../footer.php');
