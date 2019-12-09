<?php

$page_title = "Home - Quiz 2019";

include ('header.php');
include ('functions.php');

if (!isset($_SESSION['user'])) header('location: login.php'); // Si l'utilisateur n'est pas connecté, redirection

?>

<h2>Profil utilisateur</h2>

<section>
    <?php if (isset($_SESSION['logged'])) : ?>
        <h3><?= $_SESSION['logged'] ?></h3>
    <?php unset($_SESSION['logged']); endif ?>

    <?php if ($_SESSION['user']->getType() === 'admin') : ?>
    <h3>Informations de l'administrateur</h3>
    <?php else : ?>
    <h3>Informations de l'utilisateur</h3>
    <?php endif ?>

    <div>
        <p>Utilisateur  : <?= $_SESSION['user']->getNom(); ?> (n°<?= $_SESSION['user']->getId() ?>)</p>
    </div>
    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
        <button type="submit" name="deco" value="deco">Déconnexion</button>
    </form>
</section>

<?php include 'footer.php'; ?>