<?php

$page_title = "Inscription - Quiz 2019";

include ('header.php');

// Appel à la fonction enregistrer_user après avoir cliqué sur le bouton d'enregistrement
if (isset($_SESSION['bad_login'])) unset($_SESSION['bad_login']);

if (isset($_POST['reg_btn'])) enregistrer_user();
?>

<section class="section font-titles has-margin-top">
    <div class="container is-flex flex-center-hv">
        <div class="responsive-content is-one-third-desktop">
            <h2>Inscription</h2>
            <form id="inscription_form" method="post" action="<?= $_SERVER['PHP_SELF'] ?>">
                <div class="field">
                    <label class="label" for="username">Nom d'utilisateur</label>
                    <div class="control has-icons-left has-icons-right">
                        <input class="input <?= isset($_SESSION['bad_login']) ? 'is-danger' : '' ?>"
                               type="text" id="username" name="username" placeholder="Nom d'utilisateur">
                        <span class="icon is-small is-left">
                            <i class="fas fa-user"></i>
                        </span>
                        <?php if (isset($_SESSION['bad_login'])) : ?>
                            <span class="icon is-small is-right">
                            <i class="fas fa-exclamation-triangle"></i>
                        </span>
                        <?php endif; ?>
                    </div>
                    <p class="hidden-msg-w help is-danger" id="msg-incorrect-username">Taille minimale : 4 caractères (25 caractères maximum)</p>
                    <?php if (isset($_SESSION['bad_login'])) : ?>
                        <p class="help is-danger"><?= $_SESSION['bad_login'] ?></p>
                    <?php endif ?>
                </div>

                <div class="field">
                    <label class="label" for="password1">Mot de passe</label>
                    <div class="control">
                        <input class="input" type="password" id="password1" name="password1">
                    </div>
                </div>

                <div class="field">
                    <label class="label" for="password2">Confirmer mot de passe</label>
                    <div class="control">
                        <input class="input" type="password" id="password2" name="password2">
                    </div>
                </div>

                <div class="field">
                    <div class="control">
                        <button class="button is-success" type="submit" name="reg_btn">S'inscrire</button>
                    </div>
                </div>

                <p>Déjà inscrit ? <a href="login.php">Se connecter</a></p>
            </form>
            <a class="button is-link" href="index.php">Accueil</a>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>