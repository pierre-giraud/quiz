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
        <p>Liste des utilisateurs : </p>
        <?php
            global $mysql_db;

            $query = $mysql_db -> query("SELECT * FROM users WHERE type_user = 'user'");
            if ($query -> num_rows > 0) : ?>
                <table border="1">
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
            <p>Aucun utilisateur n'est encore enregistré !</p>l
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
        <table border="1">
            <tr>
                <th>ID quiz</th>
                <th>Titre</th>
                <th>Administrer</th>
                <th>Suppression</th>
            </tr>
            <?php while ($row = $query -> fetch_array(MYSQLI_ASSOC)) : ?>
                <tr id="rowq_<?= $row['id_quiz'] ?>">
                    <td><?= $row['id_quiz'] ?></td>
                    <td><?= $row['titre_quiz'] ?></td>
                    <td><button type="button" name="btn_choose_quiz" value="<?= $row['id_quiz'] ?>">Voir</td>
                    <td><input type="checkbox" id="choix_quiz" value="<?= $row['id_quiz'] ?>"></td>
                </tr>
            <?php endwhile; ?>
        </table>
        <button type="button" name="suppr_quiz" id="suppr_quiz">Supprimer</button>
    <?php endif; ?>
    <br><br>
    <form action="create_quiz.php" method="post">
        <button type="submit" name="btn_create_quiz">Créer un quiz</button>
    </form>
</section>

<?php include '../footer.php'; ?>