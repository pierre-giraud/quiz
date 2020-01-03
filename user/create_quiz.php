<?php

$page_title = "Création d'un quiz - Quiz 2019";

include('../header.php');

if (!isset($_SESSION['user'])) header('location: ../login.php'); // Si l'utilisateur n'est pas connecté, redirection
if (isset($_POST['btn_confirm_creation_quiz'])) create_quiz();
?>

<section class="section font-titles has-margin-top">
    <div class="container is-flex flex-center-hv">
        <div class="responsive-content no-border is-half-desktop">
            <h2>Création d'un quiz</h2><br>

            <form id="form_create_quiz" action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
                <div class="field">
                    <label class="label" for="quizname">Titre du quiz</label>
                    <div class="control">
                        <input class="input is-primary" type="text" id="quizname" name="quizname">
                    </div>
                    <p class="hidden-msg-w help is-danger">Un quiz doit comporter un nom</p>
                </div>

                <div id="questions">
                    <div class="field div_question" id="enonce_question1">
                        <br>
                        <hr>
                        <br>
                        <div class="control">
                            <label class="label" for="enonce1">Question 1</label>
                            <textarea class="textarea is-primary is-small" id="enonce1" name="enonce1" placeholder="Texte de la question 1 ..."></textarea>
                        </div>
                        <p class="hidden-msg-w help is-danger">Une question doit avoir un énoncé</p>
                    </div>

                    <div class="div_reponses" id="reponses_question1">
                        <br>
                        <h4>Réponses à la question 1 :</h4>
                        <br>

                        <div class="field">
                            <div class="control">
                                <label class="label labelrep" for="reponse1q1">Réponse 1</label>
                                <textarea class="textarea is-info is-small" id="reponse1q1" name="reponse1q1" placeholder="Texte de la réponse 1 ..."></textarea>
                            </div>
                            <p class="hidden-msg-w help is-danger">Cette réponse ne doit pas être vide</p>
                        </div>

                        <br>

                        <div class="field">
                            <div class="control">
                                <label class="label labelrep" for="reponse2q1">Réponse 2</label>
                                <textarea class="textarea is-info is-small" id="reponse2q1" name="reponse2q1" placeholder="Texte de la réponse 2 ..."></textarea>
                            </div>
                            <p class="hidden-msg-w help is-danger">Cette réponse ne doit pas être vide</p>
                        </div>

                        <br>

                        <div class="field">
                            <div class="control">
                                <label class="label labelrep" for="reponse3q1">Réponse 3</label>
                                <textarea class="textarea is-info is-small" id="reponse3q1" name="reponse3q1" placeholder="Texte de la réponse 3 ..."></textarea>
                            </div>
                        </div>

                        <br>

                        <div class="field">
                            <div class="control">
                                <label class="label labelrep" for="reponse4q1">Réponse 4</label>
                                <textarea class="textarea is-info is-small" id="reponse4q1" name="reponse4q1" placeholder="Texte de la réponse 4 ..."></textarea>
                            </div>
                        </div>

                        <br>

                        <div class="field">
                            <div class="control">
                                <label class="label">Réponse correcte</label>

                                <label class="radio" for="rep1q1">
                                    <input type="radio" id="rep1q1" name="choix_repq1" value="0" checked>
                                    Réponse 1
                                </label>

                                <label class="radio" for="rep2q1">
                                    <input type="radio" id="rep2q1" name="choix_repq1" value="1">
                                    Réponse 2
                                </label>

                                <label class="radio" for="rep3q1">
                                    <input type="radio" id="rep3q1" name="choix_repq1" value="2">
                                    Réponse 3
                                </label>

                                <label class="radio" for="rep4q1">
                                    <input type="radio" id="rep4q1" name="choix_repq1" value="3">
                                    Réponse 4
                                </label>
                            </div>
                        </div>

                        <div class="field">
                            <div class="control">
                                <button class="button is-danger" type="button" id="btn_suppr_question1" value="0">Supprimer la question</button>
                            </div>
                        </div>

                        <br>
                    </div>
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
                        <button class="button is-success" type="submit" name="btn_confirm_creation_quiz">Créer</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<?php include ('../footer.php');

