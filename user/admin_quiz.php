<?php

$page_title = "Administration des quiz - Quiz 2019";

include('../header.php');

if (!isset($_SESSION['user'])) header('location: ../login.php'); // Si l'utilisateur n'est pas connecté, redirection
if (isset($_POST['btn_confirm_modif_quiz'])) update_quiz();
// Si un bouton d'administration de quiz est utilisé
if (isset($_POST['btn_get_quiz'])) get_data_quiz($_POST['btn_get_quiz'], true);
// Si on rafraichit la page et qu'un quiz a été sélectionné
if (isset($_SESSION['quiz_to_admin'])) get_data_quiz($_SESSION['quiz_to_admin']['quiz']['id_quiz'], true);

// Récupération des données concernant le quiz en question
if (isset($_SESSION['quiz_to_admin'])) : ?>
    <section class="section font-titles has-margin-top">
        <div class="container is-flex flex-center-hv">
            <div class="responsive-content no-border is-half-desktop">
                <h2>Modification du quiz : <?= $_SESSION['quiz_to_admin']['quiz']['titre_quiz'] ?></h2>

                <form id="form_create_quiz" action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
                    <div class="field">
                        <label class="label" for="quizname">Titre du quiz</label>
                        <div class="control">
                            <input class="input is-primary" type="text" id="quizname" name="quizname" value="<?= $_SESSION['quiz_to_admin']['quiz']['titre_quiz'] ?>">
                        </div>
                        <p class="hidden-msg-w help is-danger">Un quiz doit comporter un nom</p>
                    </div>

                    <br><hr><br>

                    <div id="questions">
                        <?php
                        $num_r = 0;
                        for ($i = 0; $i < count($_SESSION['quiz_to_admin']['questions']); $i++) : $num_q = ($i + 1) ?>

                            <div class="field div_question" id="enonce_question<?= $num_q ?>">
                                <div class="control">
                                    <label class="label" for="enonce<?= $num_q ?>">Question <?= $num_q ?></label>
                                    <textarea class="textarea is-primary is-small" id="enonce<?= $num_q ?>" name="enonce<?= $num_q ?>" placeholder="Texte de la question <?= $num_q ?> ..."><?= $_SESSION['quiz_to_admin']['questions'][$i]['texte_question'] ?></textarea>
                                </div>
                                <p class="hidden-msg-w help is-danger">Une question doit avoir un énoncé</p>
                            </div>

                            <div id="reponses_question<?= $num_q ?>">
                                <br>
                                <h4>Réponses à la question <?= $num_q ?> :</h4>
                                <br>

                                <div class="field">
                                    <div class="control">
                                        <label class="label" for="reponse1q<?= $num_q ?>">Réponse 1</label>
                                        <textarea class="textarea is-info is-small" id="reponse1q<?= $num_q ?>" name="reponse1q<?= $num_q ?>" placeholder="Texte de la réponse <?= $num_q ?> ..."><?= $_SESSION['quiz_to_admin']['questions'][$i]['reponses'][0]['texte_reponse']?></textarea>
                                    </div>
                                    <p class="hidden-msg-w help is-danger">Cette réponse ne doit pas être vide</p>
                                </div>

                                <br>

                                <div class="field">
                                    <div class="control">
                                        <label class="label" for="reponse2q<?= $num_q ?>">Réponse 2</label>
                                        <textarea class="textarea is-info is-small" id="reponse2q<?= $num_q ?>" name="reponse2q<?= $num_q ?>" placeholder="Texte de la réponse <?= $num_q ?> ..."><?= $_SESSION['quiz_to_admin']['questions'][$i]['reponses'][1]['texte_reponse']?></textarea>
                                    </div>
                                    <p class="hidden-msg-w help is-danger">Cette réponse ne doit pas être vide</p>
                                </div>

                                <br>

                                <div class="field">
                                    <div class="control">
                                        <label class="label" for="reponse3q<?= $num_q ?>">Réponse 3</label>
                                        <textarea class="textarea is-info is-small" id="reponse3q<?= $num_q ?>" name="reponse3q<?= $num_q ?>" placeholder="Texte de la réponse <?= $num_q ?> ..."><?php if (count($_SESSION['quiz_to_admin']['questions'][$i]['reponses']) > 2) echo $_SESSION['quiz_to_admin']['questions'][$i]['reponses'][2]['texte_reponse']?></textarea>
                                    </div>
                                </div>

                                <br>

                                <div class="field">
                                    <div class="control">
                                        <label class="label" for="reponse4q<?= $num_q ?>">Réponse 4</label>
                                        <textarea class="textarea is-info is-small" id="reponse4q<?= $num_q ?>" name="reponse4q<?= $num_q ?>" placeholder="Texte de la réponse <?= $num_q ?> ..."><?php if (count($_SESSION['quiz_to_admin']['questions'][$i]['reponses']) > 3) echo $_SESSION['quiz_to_admin']['questions'][$i]['reponses'][3]['texte_reponse']?></textarea>
                                    </div>
                                </div>

                                <br>

                                <div class="field">
                                    <div class="control">
                                        <label class="label">Réponse correcte</label>

                                        <label class="radio" for="rep1q<?= $num_q ?>">
                                            <input type="radio" id="rep1q<?= $num_q ?>" name="choix_repq<?= $num_q ?>" value="0" <?php if ($_SESSION['quiz_to_admin']['questions'][$i]['reponses'][0]['iscorrect_reponse'] == 1) : ?>checked<?php endif; ?>>
                                            Réponse 1
                                        </label>

                                        <label class="radio" for="rep2q<?= $num_q ?>">
                                            <input type="radio" id="rep2q<?= $num_q ?>" name="choix_repq<?= $num_q ?>" value="1" <?php if ($_SESSION['quiz_to_admin']['questions'][$i]['reponses'][1]['iscorrect_reponse'] == 1) : ?>checked<?php endif; ?>>
                                            Réponse 2
                                        </label>

                                        <label class="radio" for="rep3q<?= $num_q ?>">
                                            <input type="radio" id="rep3q<?= $num_q ?>" name="choix_repq<?= $num_q ?>" value="2" <?php if (isset($_SESSION['quiz_to_admin']['questions'][$i]['reponses'][2]) && $_SESSION['quiz_to_admin']['questions'][$i]['reponses'][2]['iscorrect_reponse'] == 1) : ?>checked<?php endif; ?>>
                                            Réponse 3
                                        </label>

                                        <label class="radio" for="rep4q<?= $num_q ?>">
                                            <input type="radio" id="rep4q<?= $num_q ?>" name="choix_repq<?= $num_q ?>" value="3" <?php if (isset($_SESSION['quiz_to_admin']['questions'][$i]['reponses'][3]) && $_SESSION['quiz_to_admin']['questions'][$i]['reponses'][3]['iscorrect_reponse'] == 1) : ?>checked<?php endif; ?>>
                                            Réponse 4
                                        </label>
                                    </div>
                                </div>

                                <div class="field">
                                    <div class="control">
                                        <button class="button is-danger" type="button" id="btn_suppr_question<?= $num_q ?>" value="<?= $i ?>">Supprimer la question</button>
                                    </div>
                                </div>

                                <br>
                            </div>
                        <?php endfor; ?>
                    </div>

                    <br>

                    <div class="field">
                        <div class="control">
                            <button class="button is-link" type="button" id="btn_add_question">Ajouter une question</button>
                        </div>
                    </div>

                    <br><br>

                    <div class="field">
                        <div class="control">
                            <button class="button is-success" type="submit" name="btn_confirm_modif_quiz">Modifier</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
<?php else :
    header('location: home.php');
endif; ?>

<?php include ('../footer.php');
