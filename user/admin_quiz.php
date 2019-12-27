<?php

$page_title = "Administration des quiz - Quiz 2019";

include('../header.php');

if (!isset($_SESSION['user'])) header('location: ../login.php'); // Si l'utilisateur n'est pas connecté, redirection
if (isset($_POST['btn_confirm_modif_quiz'])) update_quiz();
// Si un bouton d'administration de quiz est utilisé
if (isset($_POST['btn_get_quiz'])) get_data_quiz($_POST['btn_get_quiz']);
// Si on rafraichit la page et qu'un quiz a été sélectionné
if (isset($_SESSION['quiz_to_admin'])) get_data_quiz($_SESSION['quiz_to_admin']['quiz']['id_quiz']);

// Récupération des données concernant le quiz en question
if (isset($_SESSION['quiz_to_admin'])) : ?>
    <section>
        <h2>Modification du quiz : <?= $_SESSION['quiz_to_admin']['quiz']['titre_quiz'] ?></h2>

        <form id="form_create_quiz" action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
            <div>
                <label for="quizname">Titre du quiz</label>
                <input type="text" id="quizname" name="quizname" value="<?= $_SESSION['quiz_to_admin']['quiz']['titre_quiz'] ?>">
            </div>

            <br>

            <div id="questions">
                <?php
                $num_r = 0;
                for ($i = 0; $i < count($_SESSION['quiz_to_admin']['questions']); $i++) : $num_q = ($i + 1) ?>
                    <br>
                    <div class="div_question" id="enonce_question<?= $num_q ?>">
                        <label for="enonce<?= $num_q ?>">Question <?= $num_q ?></label><br>
                        <textarea id="enonce<?= $num_q ?>" name="enonce<?= $num_q ?>"><?= $_SESSION['quiz_to_admin']['questions'][$i]['texte_question'] ?></textarea>
                    </div>

                    <div id="reponses_question<?= $num_q ?>">
                        <p>Réponses à la question <?= $num_q ?> :</p>
                        <table>
                            <tr>
                                <td>
                                    <label for="reponse1q<?= $num_q ?>">Réponse 1</label><br>
                                    <textarea id="reponse1q<?= $num_q ?>" name="reponse1q<?= $num_q ?>"><?= $_SESSION['quiz_to_admin']['questions'][$i]['reponses'][0]['texte_reponse']?></textarea>
                                </td>
                                <td>
                                    <label for="reponse2q<?= $num_q ?>">Réponse 2</label><br>
                                    <textarea id="reponse2q<?= $num_q ?>" name="reponse2q<?= $num_q ?>"><?= $_SESSION['quiz_to_admin']['questions'][$i]['reponses'][1]['texte_reponse'] ?></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="reponse3q<?= $num_q ?>">Réponse 3</label><br>
                                    <textarea id="reponse3q<?= $num_q ?>" name="reponse3q<?= $num_q ?>"><?php if (count($_SESSION['quiz_to_admin']['questions'][$i]['reponses']) > 2) echo $_SESSION['quiz_to_admin']['questions'][$i]['reponses'][2]['texte_reponse'] ?></textarea>
                                </td>
                                <td>
                                    <label for="reponse4q<?= $num_q ?>">Réponse 4</label><br>
                                    <textarea id="reponse4q<?= $num_q ?>" name="reponse4q<?= $num_q ?>"><?php if (count($_SESSION['quiz_to_admin']['questions'][$i]['reponses']) > 3) echo $_SESSION['quiz_to_admin']['questions'][$i]['reponses'][3]['texte_reponse'] ?></textarea>
                                </td>
                            </tr>
                        </table>
                    </div>
                <?php endfor; ?>
            </div>

            <button type="button" id="btn_add_question">Ajouter une question</button>

            <br><br>
            <div>
                <button type="submit" name="btn_confirm_modif_quiz">Modifier</button>
            </div>
        </form>

        <?php var_dump($_SESSION['quiz_to_admin']) ?>
    </section>
<?php else :
    header('location: home.php');
endif; ?>

<?php include ('../footer.php');
