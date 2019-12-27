<?php
    include ('functions.php');
    echo "A FAIRE<br>";
    echo " --- LISTER EN PLUS TOUS LES QUIZ SUR LA PAGE ADMIN AVEC POSSIBILITE DE LE SUPPRIMER<br>";
    echo " --- AJOUTER LA FONCTIONNALITE DES QUIZ PUBLICS<br>";
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <?php if (isset($page_title)) : ?>
            <title><?php echo $page_title?></title>
    <?php else : ?>
            <title>Quiz 2019</title>
    <?php endif ?>

    <!--<link rel="stylesheet" href="style.css">-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <?php if (basename(dirname($_SERVER['PHP_SELF'])) == 'user') : ?>
    <script type="text/javascript" src="../js/validation.js"></script>
    <script type="text/javascript" src="../js/functions.js"></script>
    <?php else : ?>
    <script type="text/javascript" src="js/validation.js"></script>
    <script type="text/javascript" src="js/functions.js"></script>
    <?php endif; ?>
</head>

<body>
    <header>
        <?php if (basename($_SERVER['PHP_SELF']) != 'login.php' && basename($_SERVER['PHP_SELF']) != 'inscription.php') : ?>
        <div>
            <?php if (isset($_SESSION['user'])) : ?>
            <p>Bonjour, <?= $_SESSION['user']->getNom() ?> (n°<?= $_SESSION['user']->getId() ?>) !</p>
            <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
                <button type="submit" name="deco" value="deco">Déconnexion</button>
            </form>
                <?php if (basename($_SERVER['PHP_SELF']) != 'home.php') : ?>
                    <?php if (basename(dirname($_SERVER['PHP_SELF'])) == 'user') : ?>
                        <a href="home.php">Home</a>
                    <?php else : ?>
                        <a href="user/home.php">Home</a>
                    <?php endif; ?>
                <?php else : ?>
                <a href="../index.php">Accueil</a>
                <?php endif; ?>
            <?php else : ?>
            <p><a href="login.php">Se connecter</a></p>
            <?php endif; ?>
        </div>
        <hr>
        <?php endif; ?>
    </header>
