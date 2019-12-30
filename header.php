<?php
    include ('functions.php');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php if (isset($page_title)) : ?>
            <title><?php echo $page_title?></title>
    <?php else : ?>
            <title>Quiz 2019</title>
    <?php endif ?>

    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <?php if (basename(dirname($_SERVER['PHP_SELF'])) == 'user') : ?>
    <link rel="stylesheet" href="../css/style.css">
    <script type="text/javascript" src="../js/validation.js"></script>
    <script type="text/javascript" src="../js/functions.js"></script>
    <?php else : ?>
    <link rel="stylesheet" href="css/style.css">
    <script type="text/javascript" src="js/validation.js"></script>
    <script type="text/javascript" src="js/functions.js"></script>
    <?php endif; ?>
</head>

<body>
    <header>
        <?php if (basename($_SERVER['PHP_SELF']) != 'login.php' && basename($_SERVER['PHP_SELF']) != 'inscription.php') : ?>
        <div class="header-container">
            <?php if (isset($_SESSION['user'])) : ?>
            <div class="name-user-div">
                <p>Connecté en tant que <strong> <?= $_SESSION['user']['nom_user'] ?></strong> (<?= $_SESSION['user']['type_user'] === 'admin' ? 'administrateur' : 'utilisateur' ?>)</p>
                <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
                    <button class="button is-link" type="submit" name="deco" value="deco">Déconnexion</button>
                </form>
            </div>
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
            <a href="login.php">Se connecter</a><br>
            <a href="index.php">Accueil</a>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </header>
