<?php

$page_title = "Home - Quiz 2019";

include('../header.php');

if (!isset($_SESSION['user'])) header('location: ../login.php'); // Si l'utilisateur n'est pas connecté, redirection
?>

<?php if ($_SESSION['user']['type_user'] === 'admin') : ?>
<section class="section font-titles has-colored-bg has-margin-top">
    <div class="container is-flex flex-center-hv">
        <div class="responsive-content no-border">
            <h3>Utilisateurs enregistrés</h3>
            <?php
            global $mysql_db;

            $query = $mysql_db -> query("SELECT * FROM users WHERE type_user = 'user'");
            if ($query -> num_rows > 0) : ?>
                <div class="table-container">
                    <table class="table is-bordered is-narrow is-hoverable is-fullwidth" id="tableuser">
                        <tr>
                            <th>Numéro</th>
                            <th>Pseudonyme</th>
                            <th>Suppression</th>
                        </tr>
                        <?php while ($row = $query -> fetch_array(MYSQLI_ASSOC)) : ?>
                            <tr class="truser dataline" id="rowu_<?= $row['id_user'] ?>">
                                <td><?= $row['id_user'] ?></td>
                                <td><?= $row['nom_user'] ?></td>
                                <td class="center-no-flex"><input type="checkbox" id="choix_user" value="<?= $row['id_user'] ?>"></td>
                            </tr>
                        <?php endwhile; ?>
                    </table>
                </div>

                <button class="button is-danger" name="suppr_user" id="suppr_user">
                    <span>Supprimer un utilisateur</span>
                    <span class="icon is-small">
                        <i class="fas fa-times"></i>
                    </span>
                </button>
            <?php else : ?>
                <p>Aucun utilisateur n'est enregistré !</p>
            <?php endif; ?>
            </div>
        </div>
    </section>
<?php endif ?>

<section class="section font-titles <?= $_SESSION['user']['type_user'] === 'user' ? 'has-margin-top' : '' ?>">
    <div class="container is-flex flex-center-hv">
        <div class="responsive-content no-border">
            <h3>Vos quiz</h3>

            <?php

            global $mysql_db;
            $query = $mysql_db -> query("SELECT * FROM quiz WHERE id_user =" . $_SESSION['user']['id_user'] . " ORDER BY id_quiz");

            if ($query -> num_rows == 0) : ?>
                <p>Vous n'avez aucun quiz</p>
            <?php else : ?>
                <div class="table-container">
                    <table class="table is-bordered is-narrow is-hoverable is-fullwidth" id="tablequiz">
                        <tr>
                            <th>ID quiz</th>
                            <th>Titre</th>
                            <th>Administrer</th>
                            <th>Rendre public</th>
                            <th>Suppression</th>
                        </tr>
                        <?php while ($row = $query -> fetch_array(MYSQLI_ASSOC)) : ?>
                            <tr class="dataline" id="rowq_<?= $row['id_quiz'] ?>">
                                <td><?= $row['id_quiz'] ?></td>
                                <td><?= $row['titre_quiz'] ?></td>
                                <td>
                                    <form action="admin_quiz.php" method="post">
                                        <button class="button is-info" type="submit" id="btn_get_quiz<?= $row['id_quiz'] ?>" name="btn_get_quiz" value="<?= $row['id_quiz'] ?>">Administrer</button>
                                    </form>
                                </td>
                                <td class="center-no-flex"><input type="checkbox" id="pquiz_<?= $row['id_quiz'] ?>" name="choix_public" value="<?= $row['id_quiz'] ?>"</td>
                                <td class="center-no-flex"><input type="checkbox" id="choix_quiz" value="<?= $row['id_quiz'] ?>"></td>
                            </tr>
                        <?php endwhile; ?>
                        <tr>
                            <td colspan="3"></td>
                            <td><button class="button is-success" name="btn_set_public" id="btn_set_public">Valider</button></td>
                            <td><button class="button is-danger" name="suppr_quiz" id="suppr_quiz">Supprimer</button></td>
                        </tr>
                    </table>
                </div>
            <?php endif; ?>

            <form action="create_quiz.php" method="post">
                <button class="button is-success" type="submit" name="btn_create_quiz">
                    <span>Créer un quiz</span>
                    <span class="icon is-small">
                        <i class="fas fa-check"></i>
                    </span>
                </button>
            </form>
        </div>
    </div>
</section>

<?php if ($_SESSION['user']['type_user'] === 'admin') : ?>
<section class="section font-titles has-colored-bg">
    <div class="container is-flex flex-center-hv">
        <div class="responsive-content no-border">
            <h3>Quiz enregistrés</h3>

            <?php

            global $mysql_db;
            $query = $mysql_db -> query("SELECT * FROM quiz ORDER BY id_quiz");

            if ($query -> num_rows == 0) : ?>
                <p>Aucun quiz enregistré</p>
            <?php else : ?>
                <div class="table-container">
                    <table class="table is-bordered is-narrow is-hoverable is-fullwidth" id="tablequizadmin">
                        <tr>
                            <th>ID quiz</th>
                            <th>Titre</th>
                            <th>Utilisateur</th>
                            <th>Public</th>
                            <th>Suppression</th>
                        </tr>
                        <?php while ($row = $query -> fetch_array(MYSQLI_ASSOC)) : ?>
                            <?php
                            $userquery = $mysql_db -> query("SELECT * FROM users WHERE id_user = ".$row['id_user']);
                            $user = $userquery -> fetch_array(MYSQLI_ASSOC);
                            ?>
                            <tr class="trquiz dataline" id="rowqa_<?= $row['id_quiz'] ?>">
                                <td><?= $row['id_quiz'] ?></td>
                                <td><?= $row['titre_quiz'] ?></td>
                                <td><?= $user['nom_user']?> (n°<?= $user['id_user']?>)</td>
                                <td><?= $row['ispublic_quiz'] === '1' ? 'Oui' : 'Non' ?></td>
                                <td class="center-no-flex"><input type="checkbox" id="choix_quiz_admin" value="<?= $row['id_quiz'] ?>"></td>
                            </tr>
                        <?php endwhile; ?>
                    </table>
                </div>
                <button class="button is-danger" name="suppr_quiz_admin" id="suppr_quiz_admin">
                    <span>Supprimer un quiz</span>
                    <span class="icon is-small">
                        <i class="fas fa-times"></i>
                    </span>
                </button>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php include '../footer.php'; ?>