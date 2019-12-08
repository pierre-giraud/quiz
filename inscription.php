<?php

$page_title = "Inscription - Quiz 2019";

include ('header.php');
include('functions.php');

session_start();

// Connexion à la base de données
$db_conn = connexion_db();
$username = "";

// Appel à la fonction enregistrer_user après avoir cliqué sur le bouton d'enregistrement
if (isset($_POST['reg_btn'])){
    echo 'test';
    enregistrer_user();
}

?>

<body>
    <h1>Inscription</h1>

    <section>
        <form id="inscription_form" method="post" action="inscription.php" onsubmit="return isFormOK()">
            <div>
                <label>Nom d'utilisateur</label>
                <input type="text" id="username" name="username" value="<?php echo $username?>">
            </div>

            <div>
                <label>Mot de passe</label>
                <input type="password" name="password1">
            </div>

            <div>
                <label>Confirmer mot de passe</label>
                <input type="password" name="password2">
            </div>

            <div>
                <button type="submit" name="reg_btn">S'inscrire</button>
            </div>

            <p>
                Déjà inscrit ? <a href="login.php">Se connecter</a>
            </p>
        </form>
    </section>
</body>

<?php

include 'footer.php';

?>