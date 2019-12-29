<?php

$page_title = "Création d'un quiz - Quiz 2019";

include('../header.php');

if (!isset($_SESSION['user'])) header('location: ../login.php'); // Si l'utilisateur n'est pas connecté, redirection
if (isset($_POST['btn_confirm_creation_quiz'])) create_quiz();
?>

<section>
    <h2>Création d'un quiz</h2>

    <form id="form_create_quiz" action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
        <div>
            <label for="quizname">Titre du quiz</label>
            <input type="text" id="quizname" name="quizname">
        </div>

        <br>

        <div id="questions">
            <div class="div_question" id="enonce_question1">
                <label for="enonce1">Question 1</label><br>
                <textarea id="enonce1" name="enonce1"></textarea>
            </div>

            <div id="reponses_question1">
                <p>Réponses à la question 1 :</p>
                <table>
                    <tr>
                        <td>
                            <label for="reponse1q1">Réponse 1</label><br>
                            <textarea id="reponse1q1" name="reponse1q1"></textarea>
                        </td>
                        <td>
                            <label for="reponse2q1">Réponse 2</label><br>
                            <textarea id="reponse2q1" name="reponse2q1"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="reponse3q1">Réponse 3</label><br>
                            <textarea id="reponse3q1" name="reponse3q1"></textarea>
                        </td>
                        <td>
                            <label for="reponse4q1">Réponse 4</label><br>
                            <textarea id="reponse4q1" name="reponse4q1"></textarea>
                        </td>
                    </tr>
                </table>

                <div style="display: flex; align-items: center;">
                    <p>Réponse correcte : </p>

                    <input type="radio" id="rep1q1" name="choix_repq1" value="0" checked>
                    <label for="rep1q1">Réponse 1</label>

                    <input type="radio" id="rep2q1" name="choix_repq1" value="1">
                    <label for="rep2q1">Réponse 2</label>

                    <input type="radio" id="rep3q1" name="choix_repq1" value="2">
                    <label for="rep3q1">Réponse 3</label>

                    <input type="radio" id="rep4q1" name="choix_repq1" value="3">
                    <label for="rep4q1">Réponse 4</label>
                </div>
            </div>
        </div>

        <button type="button" id="btn_add_question">Ajouter une question</button>

        <br><br>
        <div>
            <button type="submit" name="btn_confirm_creation_quiz">Créer</button>
        </div>
    </form>
</section>

<?php include ('../footer.php');

