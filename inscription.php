<?php

$page_title = "Inscription - Quiz 2019";

include ('header.php');

// Appel à la fonction enregistrer_user après avoir cliqué sur le bouton d'enregistrement
if (isset($_SESSION['bad_login'])) unset($_SESSION['bad_login']);

if (isset($_POST['reg_btn'])){
    enregistrer_user();
}
?>

<h2>Inscription</h2>

<section>
    <form id="inscription_form" method="post" action="<?= $_SERVER['PHP_SELF'] ?>">
        <div>
            <label for="username">Nom d'utilisateur</label>
            <input type="text" id="username" name="username">
            <?php if (isset($_SESSION['bad_login'])) : ?>
                <p style="color: red"><?= $_SESSION['bad_login'] ?></p>
            <?php endif ?>
        </div>

        <div>
            <label for="password1">Mot de passe</label>
            <input type="password" id="password1" name="password1">
        </div>

        <div>
            <label for="password2">Confirmer mot de passe</label>
            <input type="password" id="password2" name="password2">
        </div>

        <button type="submit" name="reg_btn">S'inscrire</button>
    </form>
    <p>Déjà inscrit ? <a href="login.php">Se connecter</a></p>
    <a href="index.php">Accueil</a>
</section>

<?php include 'footer.php'; ?>