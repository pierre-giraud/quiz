<?php

$page_title = "Home - Quiz 2019";

include('../header.php');

if (!isset($_SESSION['user'])) header('location: ../login.php'); // Si l'utilisateur n'est pas connecté, redirection
?>

<section>
    <?php if (isset($_SESSION['logged'])) : ?>
        <h3><?= $_SESSION['logged'] ?></h3>
    <?php unset($_SESSION['logged']); endif ?>

    <?php if ($_SESSION['user']->getType() === 'admin') : ?>
        <h2>Page HOME de <strong>l'administrateur</strong></h2>
        <h3>Liste des utilisateurs : </h3>
        <?php
            global $mysql_db;

            $query = $mysql_db -> query("SELECT * FROM users WHERE type_user = 'user'");
            if ($query -> num_rows > 0) : ?>
                <table id="tableuser" border="1">
                    <tr>
                        <th>Numéro</th>
                        <th>Pseudonyme</th>
                        <th>Suppression</th>
                    </tr>
                <?php while ($row = $query -> fetch_array(MYSQLI_ASSOC)) : ?>
                    <tr id="rowu_<?= $row['id_user'] ?>">
                        <td><?= $row['id_user'] ?></td>
                        <td><?= $row['nom_user'] ?></td>
                        <td><input type="checkbox" id="choix_user" value="<?= $row['id_user'] ?>"></td>
                    </tr>
                <?php endwhile; ?>
                </table>
                <button type="button" name="suppr_user" id="suppr_user">Supprimer</button>
        <?php else : ?>
            <p>Aucun utilisateur n'est enregistré !</p>
        <?php endif; ?>
    <?php else : ?>
        <h2>Page HOME de <strong>l'utilisateur</strong></h2>
    <?php endif ?>
</section>
<br><br>
<section>
    <h3>Vos quiz</h3>

    <?php

    global $mysql_db;
    $query = $mysql_db -> query("SELECT * FROM quiz WHERE id_user =" . $_SESSION['user']->getId());

    if ($query -> num_rows == 0) : ?>
        <p>Vous n'avez aucun quiz</p>
    <?php else : ?>
        <table id="tablequiz" border="1">
            <tr>
                <th>ID quiz</th>
                <th>Titre</th>
                <th>Administrer</th>
                <th>Rendre public</th>
                <th>Suppression</th>
            </tr>
            <?php while ($row = $query -> fetch_array(MYSQLI_ASSOC)) : ?>
            <tr id="rowq_<?= $row['id_quiz'] ?>">
                <td><?= $row['id_quiz'] ?></td>
                <td><?= $row['titre_quiz'] ?></td>
                <td>
                    <form action="admin_quiz.php" method="post">
                        <button type="submit" id="btn_get_quiz" name="btn_get_quiz" value="<?= $row['id_quiz'] ?>">Administrer
                    </form>
                </td>
                <td><input type="checkbox" id="pquiz_<?= $row['id_quiz'] ?>" name="choix_public" value="<?= $row['id_quiz'] ?>"</td>
                <td><input type="checkbox" id="choix_quiz" value="<?= $row['id_quiz'] ?>"></td>
            </tr>
            <?php endwhile; ?>
            <tr>
                <td colspan="3"></td>
                <td><button type="button" name="btn_set_public" id="btn_set_public">Valider</button></td>
                <td><button type="button" name="suppr_quiz" id="suppr_quiz">Supprimer</button></td>
            </tr>
        </table>
    <?php endif; ?>
    <br><br>
    <form action="create_quiz.php" method="post">
        <button type="submit" name="btn_create_quiz">Créer un quiz</button>
    </form>
</section>

<?php if ($_SESSION['user']->getType() === 'admin') : ?>
<section>
    <h3>Liste des quiz</h3>

    <?php

    global $mysql_db;
    $query = $mysql_db -> query("SELECT * FROM quiz");

    if ($query -> num_rows == 0) : ?>
        <p>Aucun quiz enregistré</p>
    <?php else : ?>
        <table id="tablequizadmin" border="1">
            <tr>
                <th>ID quiz</th>
                <th>Titre</th>
                <th>Utilisateur</th>
                <th>Suppression</th>
            </tr>
            <?php while ($row = $query -> fetch_array(MYSQLI_ASSOC)) : ?>
                <?php
                    $userquery = $mysql_db -> query("SELECT * FROM users WHERE id_user = ".$row['id_user']);
                    $user = $userquery -> fetch_array(MYSQLI_ASSOC);
                ?>
                <tr id="rowqa_<?= $row['id_quiz'] ?>">
                    <td><?= $row['id_quiz'] ?></td>
                    <td><?= $row['titre_quiz'] ?></td>
                    <td><?= $user['nom_user']?> (n°<?= $user['id_user']?>)</td>
                    <td><input type="checkbox" id="choix_quiz_admin" value="<?= $row['id_quiz'] ?>"></td>
                </tr>
            <?php endwhile; ?>
        </table>
        <button type="button" name="suppr_quiz_admin" id="suppr_quiz_admin">Supprimer</button>
    <?php endif; ?>
</section>
<?php endif; ?>

<?php include '../footer.php'; ?>