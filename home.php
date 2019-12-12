<?php

$page_title = "Home - Quiz 2019";

include ('header.php');

if (!isset($_SESSION['user'])) header('location: login.php'); // Si l'utilisateur n'est pas connecté, redirection

?>

<h2>Profil utilisateur</h2>

<section>
    <?php if (isset($_SESSION['logged'])) : ?>
        <h3><?= $_SESSION['logged'] ?></h3>
    <?php unset($_SESSION['logged']); endif ?>

    <?php if ($_SESSION['user']->getType() === 'admin') : ?>
        <p>Page HOME de <strong>l'administrateur</strong></p>
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
                    <tr id="row_<?= $row['id_user'] ?>">
                        <td><?= $row['id_user'] ?></td>
                        <td><?= $row['nom_user'] ?></td>
                        <td><input type="checkbox" name="choix_user" value="<?= $row['id_user'] ?>"></td>
                    </tr>
                <?php endwhile; ?>
                </table>
                <button type="button" name="suppr_user" id="suppr_user">Supprimer</button>
        <?php else : ?>
            <p>Aucun utilisateur n'est encore enregistré !</p>
        <?php endif; ?>
    <?php else : ?>
        <p>Page HOME de <strong>l'utilisateur</strong></p>
    <?php endif ?>
</section>

<?php include 'footer.php'; ?>