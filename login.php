<?php

$page_title = "Connexion - Quiz 2019";

include ('header.php');

// Appel à la fonction connecter_user après avoir cliqué sur le bouton Connexion
unset($_SESSION['bad_login']);
unset($_SESSION['bad_passwd']);
unset($_SESSION['username']);

if (isset($_POST['con_btn'])){
    connecter_user();
}
?>

<section class="section font-titles has-margin-top">
    <div class="container is-flex flex-center-hv">
        <div class="responsive-content is-one-third-desktop">
            <h2>Connexion</h2>
            <form id="connexion_form" method="post" action="<?= $_SERVER['PHP_SELF'] ?>">
                <div class="field">
                    <label class="label" for="username">Nom d'utilisateur</label>
                    <div class="control has-icons-left has-icons-right">
                        <input class="input <?= isset($_SESSION['bad_login']) ? 'is-danger' : '' ?> <?= isset($_SESSION['bad_passwd']) ? 'is-success' : '' ?>"
                               type="text" id="username" name="username" placeholder="Nom d'utilisateur"
                               value="<?php if (isset($_SESSION['username'])) echo $_SESSION['username'] ?>">
                        <span class="icon is-small is-left">
                            <i class="fas fa-user"></i>
                        </span>
                        <?php if (isset($_SESSION['bad_login'])) : ?>
                        <span class="icon is-small is-right">
                            <i class="fas fa-exclamation-triangle"></i>
                        </span>
                        <?php elseif (isset($_SESSION['bad_passwd'])) : ?>
                        <span class="icon is-small is-right">
                            <i class="fas fa-check"></i>
                        </span>
                        <?php endif; ?>
                    </div>
                    <?php if (isset($_SESSION['bad_login'])) : ?>
                    <p class="help is-danger"><?= $_SESSION['bad_login'] ?></p>
                    <?php endif ?>
                </div>

                <div class="field">
                    <label class="label" for="password">Mot de passe</label>
                    <div class="control">
                        <input class="input <?= isset($_SESSION['bad_passwd']) ? 'is-danger' : '' ?>"
                               type="password" id="password" name="password">
                    </div>
                    <?php if (isset($_SESSION['bad_passwd'])) : ?>
                        <p class="help is-danger"><?= $_SESSION['bad_passwd'] ?></p>
                    <?php endif ?>
                </div>

                <div class="field">
                    <div class="control">
                        <button class="button is-success" type="submit" name="con_btn">Se connecter</button>
                    </div>
                </div>
                <p>Pas encore membre ? <a href="inscription.php">Inscrivez-vous !</a></p>
            </form>
            <a class="button is-link" href="index.php">Accueil</a>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>
