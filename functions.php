<?php

include ('model/Utilisateur.php');
include ('constants.php');

// Démarre ou continue une session
session_start();

// Si le bouton de déconnexion est utilisé
if (isset($_POST['deco'])) deconnexion_user();

/*
 * Fonction servant à se connecter à la base de données
 */
function connexion_db(){
    $db_connexion = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die("Echec de la connexion");
    return $db_connexion;
}

/*
 * Fonction servant à se déconnecter de la base de données
 */
function deconnexion_db($db){
    mysqli_close($db);
}

/*
 * Fonction servant à enregistrer un utilisateur dans la base de données
 */
function enregistrer_user(){
    global $mysql_db, $username;

    $username  = $mysql_db -> real_escape_string(trim($_POST['username']));
    $password1 = $mysql_db -> real_escape_string(trim($_POST['password1']));

    $password = password_hash($password1, PASSWORD_DEFAULT);

    // Vérification des doublons utilisateurs
    $query_verif = "SELECT * FROM users WHERE nom_user = '$username'";
    $results = $mysql_db -> query($query_verif);

    // Vérifie que l'utilisateur n'existe pas déjà
    if ($results -> num_rows === 0) {
        // Insertion du nouvel utilisateur
        $query = "INSERT INTO users (nom_user, mdp_user, type_user) VALUES ('$username', '$password', 'user')";
        $mysql_db -> query($query);

        $user_id = $mysql_db -> insert_id;
        $_SESSION['user'] = getUserById($user_id);
        $_SESSION['logged'] = "Vous êtes maintenant connecté !";
        unset($_SESSION['bad_login']);
        header('location: user/home.php');
    } else {
        $_SESSION['bad_login'] = "Nom d'utilisateur déjà utilisé";
    }
}

function connecter_user(){
    global $mysql_db;

    $username = $mysql_db -> real_escape_string(trim($_POST['username']));
    $password = $mysql_db -> real_escape_string(trim($_POST['password']));

    $query  = "SELECT * FROM users WHERE nom_user = '$username'";
    $result = $mysql_db -> query($query);

    // Si un utilisateur est trouvé
    if ($result -> num_rows === 1){
        $row = $result -> fetch_array(MYSQLI_ASSOC);
        $hashed_password = $row['mdp_user'];

        if (password_verify($password, $hashed_password)){
            $_SESSION['user'] = getUserById($row['id_user']);
            $_SESSION['logged'] = "Vous êtes maintenant connecté !";
            unset($_SESSION['bad_login']);
            unset($_SESSION['bad_passwd']);
            header('location: user/home.php');
        } else {
            $_SESSION['username'] = $username;
            $_SESSION['bad_passwd'] = "Mot de passe incorrect";
        }
    } else {
        $_SESSION['bad_login'] = "Cet utilisateur n'existe pas";
    }
}

function deconnexion_user(){
    session_destroy();
    unset($_SESSION['user']);
    header('location: login.php');
}

/*
 * Fonction qui retourne un objet de type Utilisateur contenant les informations de l'utilisateur
 * dont l'identifiant est passé en paramètre
 */
function getUserById($id){
    global $mysql_db;

    $result = $mysql_db -> query("SELECT id_user, nom_user, type_user FROM users WHERE id_user = " . $id);
    $user_instance = NULL;

    if ($obj = $result -> fetch_object()){
        $user_instance = new Utilisateur($obj->id_user, $obj->nom_user, $obj->type_user);
    }

    return $user_instance;
}

function create_quiz(){
    global $mysql_db;
    $id_quiz = 0;
    $id_question = 0;

    // Parcours des données de $_POST pour les trier
   foreach ($_POST as $key => $value){
        // Remplissage de la table quiz
        if ($key == "quizname") {
            $quizname = $mysql_db -> real_escape_string(trim($value));
            $mysql_db -> query("INSERT INTO quiz (titre_quiz, ispublic_quiz, id_user) VALUES ('$quizname', 0," . $_SESSION['user']->getId() . ")");
            $id_quiz = $mysql_db -> insert_id;
        } elseif (strpos($key, "enonce") !== false){
            $question = $mysql_db -> real_escape_string(htmlspecialchars($value));
            $mysql_db -> query("INSERT INTO questions (texte_question, id_quiz) VALUES ('$question'," . $id_quiz . ")");
            $id_question = $mysql_db -> insert_id;
        } elseif (strpos($key,"reponse") !== false) {
            $reponse = $mysql_db -> real_escape_string(htmlspecialchars($value));
            $mysql_db -> query("INSERT INTO reponses (texte_reponse, iscorrect_reponse, id_question) VALUES ('$reponse', 0," . $id_question . ")");
        }
    }

    header('location: home.php');
}