<?php include ('header.php'); ?>

<?php if (isset($_GET['id'])) : $_SESSION['quiz_to_do'] = get_data_quiz($_GET['id'], false);?>
<?php if (isset($_SESSION['result_quiz'])) unset($_SESSION['result_quiz']); ?>
<section class="section font-titles has-margin-top">
    <div class="container is-flex flex-center-hv">
        <div class="has-text-centered">
            <?php if ($_SESSION['quiz_to_do'] == null) : ?>
                <p>Ce quiz n'est pas disponible ou n'existe pas</p>
            <?php else : ?>
                <h2><?= $_SESSION['quiz_to_do']['quiz']['titre_quiz'] ?></h2><br><br>
                <button class="button is-info is-centered" type="button" id="btn_start_quiz" name="btn_start_quiz">Commencer</button>

                <div id="question_quiz">
                    <?php
                    $save_indices = [];
                    for ($i = 0; $i < count($_SESSION['quiz_to_do']['questions']); $i++) : ?>
                        <table class="table is-bordered" id="tablequestion<?= $i ?>" style="display: none">
                            <tr>
                                <?php if (count($_SESSION['quiz_to_do']['questions'][$i]['reponses']) != 3) : ?>
                                <td colspan="2"><?= $_SESSION['quiz_to_do']['questions'][$i]['texte_question'] ?></td>
                                <?php else : ?>
                                <td colspan="3"><?= $_SESSION['quiz_to_do']['questions'][$i]['texte_question'] ?></td>
                                <?php endif; ?>
                            </tr>
                            <tr class="trreponses">
                                <?php
                                    $indices = range(0, count($_SESSION['quiz_to_do']['questions'][$i]['reponses']) - 1);
                                    shuffle($indices);
                                    $save_indices[] = $indices;
                                ?>
                                <td id="rep<?= $indices[0] ?>">A : <?= $_SESSION['quiz_to_do']['questions'][$i]['reponses'][$indices[0]]['texte_reponse'] ?></td>
                                <td id="rep<?= $indices[1] ?>">B : <?= $_SESSION['quiz_to_do']['questions'][$i]['reponses'][$indices[1]]['texte_reponse'] ?></td>
                                <?php if (count($_SESSION['quiz_to_do']['questions'][$i]['reponses']) == 3) : ?>
                                    <td id="rep<?= $indices[2] ?>">C : <?= $_SESSION['quiz_to_do']['questions'][$i]['reponses'][$indices[2]]['texte_reponse'] ?></td>
                                <?php elseif (count($_SESSION['quiz_to_do']['questions'][$i]['reponses']) == 4) : ?>
                            </tr>
                            <tr class="trreponses">
                                <td id="rep<?= $indices[2] ?>">C : <?= $_SESSION['quiz_to_do']['questions'][$i]['reponses'][$indices[2]]['texte_reponse'] ?></td>
                                <td id="rep<?= $indices[3] ?>">D : <?= $_SESSION['quiz_to_do']['questions'][$i]['reponses'][$indices[3]]['texte_reponse'] ?></td>
                                <?php endif; ?>
                            </tr>
                        </table>
                    <?php endfor;?>
                </div>

                <div class="hidden-msg-w" id="resultats_quiz">
                    <h3>Vos résultats</h3>
                    <br><br>

                    <?php
                    for ($i = 0; $i < count($_SESSION['quiz_to_do']['questions']); $i++) : ?>
                        <h3>Question <?= $i + 1 ?></h3>
                        <table class="table is-bordered table-result" id="tablequestionres<?= $i ?>">
                            <tr>
                                <?php if (count($_SESSION['quiz_to_do']['questions'][$i]['reponses']) != 3) : ?>
                                    <td colspan="2"><?= $_SESSION['quiz_to_do']['questions'][$i]['texte_question'] ?></td>
                                <?php else : ?>
                                    <td colspan="3"><?= $_SESSION['quiz_to_do']['questions'][$i]['texte_question'] ?></td>
                                <?php endif; ?>
                            </tr>
                            <tr class="trquestionsres">
                                <td id="repres<?= $save_indices[$i][0] ?>">A : <?= $_SESSION['quiz_to_do']['questions'][$i]['reponses'][$save_indices[$i][0]]['texte_reponse'] ?></td>
                                <td id="repres<?= $save_indices[$i][1] ?>">B : <?= $_SESSION['quiz_to_do']['questions'][$i]['reponses'][$save_indices[$i][1]]['texte_reponse'] ?></td>
                                <?php if (count($_SESSION['quiz_to_do']['questions'][$i]['reponses']) == 3) : ?>
                                    <td id="repres<?= $save_indices[$i][2] ?>">C : <?= $_SESSION['quiz_to_do']['questions'][$i]['reponses'][$save_indices[$i][2]]['texte_reponse'] ?></td>
                                <?php elseif (count($_SESSION['quiz_to_do']['questions'][$i]['reponses']) == 4) : ?>
                            </tr>
                            <tr class="trquestionsres">
                                <td id="repres<?= $save_indices[$i][2] ?>">C : <?= $_SESSION['quiz_to_do']['questions'][$i]['reponses'][$save_indices[$i][2]]['texte_reponse'] ?></td>
                                <td id="repres<?= $save_indices[$i][3] ?>">D : <?= $_SESSION['quiz_to_do']['questions'][$i]['reponses'][$save_indices[$i][3]]['texte_reponse'] ?></td>
                                <?php endif; ?>
                            </tr>
                        </table>
                        <p id="correctornot<?= $i ?>"></p>
                    <br><br>
                    <?php endfor;?>
                    <br>
                    <p class="label" id="nbreponsescorrectes"></p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php else :
    header('location: index.php');
endif;?>

<?php include ('footer.php'); ?>
