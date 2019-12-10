<?php

$page_title = "Connexion - Quiz 2019";

include ('header.php');

// Connexion à la base de données
//$mysql_db = connexion_db();

// Appel à la fonction connecter_user après avoir cliqué sur le bouton Connexion
unset($_SESSION['bad_login']);
unset($_SESSION['bad_passwd']);
unset($_SESSION['username']);

if (isset($_POST['con_btn'])){
    connecter_user();
}
?>

<h2>Connexion</h2>

<section>
    <form id="connexion_form" method="post" action="<?= $_SERVER['PHP_SELF'] ?>">
        <div>
            <label for="username">Nom d'utilisateur</label>
            <input type="text" id="username" name="username" value="<?php if (isset($_SESSION['username'])) echo $_SESSION['username'] ?>">
            <?php if (isset($_SESSION['bad_login'])) : ?>
                <p style="color: red"><?= $_SESSION['bad_login'] ?></p>
            <?php endif ?>
        </div>

        <div>
            <label for="password">Mot de passe</label>
            <input id="password" type="password" name="password">
            <?php if (isset($_SESSION['bad_passwd'])) : ?>
                <p style="color: red"><?= $_SESSION['bad_passwd'] ?></p>
            <?php endif ?>
        </div>

        <div>
            <button type="submit" name="con_btn">Se connecter</button>
        </div>

        <p>Pas encore membre ? <a href="inscription.php">Inscrivez-vous !</a></p>
    </form>
</section>

<?php include 'footer.php'; ?>
