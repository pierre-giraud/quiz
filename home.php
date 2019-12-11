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
            <ul>
            <?php while ($row = $query -> fetch_array(MYSQLI_ASSOC)) : ?>
                <li>Utilisateur n°<?= $row['id_user'] ?> : <?= $row['nom_user'] ?></li>
            <?php endwhile; ?>
            </ul>
        <?php endif; ?>
    <?php else : ?>
    <p>Page HOME de <strong>l'utilisateur</strong></p>
    <?php endif ?>
</section>

<?php include 'footer.php'; ?>