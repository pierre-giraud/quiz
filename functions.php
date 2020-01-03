<?php

include('configuration.php');

// Démarre ou continue une session
session_start();

// Connexion à la base de données
$mysql_db = connexion_db();

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

    // Si l'utilisateur enregistré est le premier, il est administrateur
    $res_seul = $mysql_db -> query("SELECT * FROM users");
    if ($res_seul -> num_rows === 0) {
        $mysql_db -> query("INSERT INTO users (nom_user, mdp_user, type_user) VALUES ('$username', '$password', 'admin')");
        $user_id = $mysql_db -> insert_id;
        $_SESSION['user'] = getUserById($user_id);
        header('location: user/home.php');

        exit();
    }

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
        unset($_SESSION['bad_login']);
        header('location: user/home.php');
    } else {
        $_SESSION['bad_login'] = "Ce nom d'utilisateur est déjà pris";
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
    session_unset();

    if (basename(dirname($_SERVER['PHP_SELF'])) == 'user'){
        header('location: ../login.php');
    } else {
        header('location: login.php');
    }
}

/*
 * Fonction qui retourne un objet de type Utilisateur contenant les informations de l'utilisateur
 * dont l'identifiant est passé en paramètre
 */
function getUserById($id){
    global $mysql_db;

    $result = $mysql_db -> query("SELECT id_user, nom_user, type_user FROM users WHERE id_user = " . $id);

    return $result -> fetch_array(MYSQLI_ASSOC);
}

function create_quiz(){
    global $mysql_db;
    $id_quiz = 0;
    $id_question = 0;
    $id_reponses = []; //Tableau utilisé pour modifier la base de données pour les réponses correctes

    // Parcours des données de $_POST
   foreach ($_POST as $key => $value){
        // Remplissage de la table quiz
        if ($key == "quizname") {
            $quizname = $mysql_db -> real_escape_string(trim($value));
            $mysql_db -> query("INSERT INTO quiz (titre_quiz, ispublic_quiz, id_user) VALUES ('$quizname', 0," . $_SESSION['user']['id_user'] . ")");
            $id_quiz = $mysql_db -> insert_id;
        // Remplissage de la table questions
        } elseif (strpos($key, "enonce") !== false){
            $question = $mysql_db -> real_escape_string(trim($value));
            $mysql_db -> query("INSERT INTO questions (texte_question, id_quiz) VALUES ('$question'," . $id_quiz . ")");
            $id_question = $mysql_db -> insert_id;
        // Remplissage de la table reponses
        } elseif (strpos($key,"reponse") !== false) {
            if (trim($value) != ''){ // Si l'utilisateur a rempli ce champ
                $reponse = $mysql_db -> real_escape_string(trim($value));
                $mysql_db -> query("INSERT INTO reponses (texte_reponse, iscorrect_reponse, id_question) VALUES ('$reponse', 0," . $id_question . ")");
                $id_reponses[] = $mysql_db -> insert_id;
            }
        } elseif (strpos($key, "choix_repq") !== false){
            $mysql_db -> query("UPDATE reponses SET iscorrect_reponse = 1 WHERE id_reponse = " . $id_reponses[$value]);
            $id_reponses = []; // Reset du tableau
        }
    }

   header('location: home.php');
}

function update_quiz(){
    global $mysql_db;
    $id_quiz = $_SESSION['quiz_to_admin']['quiz']['id_quiz'];
    $cpt_question = 0;
    $cpt_reponse = 0;
    $id_question = 0;

    // Parcours des données de $_POST
    foreach ($_POST as $key => $value){
        // Remplissage de la table quiz
        if ($key == "quizname") {
            $quizname = $mysql_db -> real_escape_string(trim($value));
            $mysql_db -> query("UPDATE quiz SET titre_quiz = '$quizname' WHERE id_quiz = ".$id_quiz);
            // Remplissage de la table questions
        } elseif (strpos($key, "enonce") !== false){
            $question = $mysql_db -> real_escape_string(trim($value));

            // Si la question existe, on la modifie sinon on l'ajoute
            if (isset($_SESSION['quiz_to_admin']['questions'][$cpt_question]['id_question'])){
                $id_question = $_SESSION['quiz_to_admin']['questions'][$cpt_question]['id_question'];
                $mysql_db -> query("UPDATE questions SET texte_question = '$question' WHERE id_question = ".$id_question);
            } else {
                $mysql_db -> query("INSERT INTO questions (texte_question, id_quiz) VALUES ('$question'," . $id_quiz . ")");
                $id_question = $mysql_db -> insert_id;
            }

            $cpt_question++;
            // Remplissage de la table reponses
        } elseif (strpos($key,"reponse") !== false) {
            $num_question = $cpt_question - 1;
            $reponse = $mysql_db -> real_escape_string(trim($value));

            if ($reponse != ''){ // Si l'utilisateur a rempli ce champ
                // Vérification de l'existence de la réponse
                if (isset($_SESSION['quiz_to_admin']['questions'][$num_question]['reponses'][$cpt_reponse]['id_reponse'])) {
                    $id_reponse = $_SESSION['quiz_to_admin']['questions'][$num_question]['reponses'][$cpt_reponse]['id_reponse'];
                    $mysql_db -> query("UPDATE reponses SET texte_reponse = '$reponse' WHERE id_reponse = ".$id_reponse);
                } else {
                    $mysql_db -> query("INSERT INTO reponses (texte_reponse, iscorrect_reponse, id_question) VALUES ('$reponse', 0," . $id_question . ")");
                    $id_reponse = $mysql_db -> insert_id;
                    $result = $mysql_db -> query("SELECT * FROM reponses WHERE id_reponse = ".$id_reponse);
                    $rep = $result -> fetch_array(MYSQLI_ASSOC);
                    $_SESSION['quiz_to_admin']['questions'][$num_question]['reponses'][$cpt_reponse] = $rep; // Mise à jour de $_SESSION pour les updates plus bas
                }
            } else {
                // Si une réponse existe, elle est supprimé car le champ est vide
                if (isset($_SESSION['quiz_to_admin']['questions'][$num_question]['reponses'][$cpt_reponse]['id_reponse'])) {
                    $id_reponse = $_SESSION['quiz_to_admin']['questions'][$num_question]['reponses'][$cpt_reponse]['id_reponse'];
                    $mysql_db -> query("DELETE FROM reponses WHERE id_reponse = ".$id_reponse);
                }
            }

            $cpt_reponse++;
            if ($cpt_reponse == 4) $cpt_reponse = 0;
        } elseif (strpos($key, "choix_repq") !== false){
            $num_question = $cpt_question - 1;

            // Remise à faux pour toutes les réponses
            $mysql_db -> query("UPDATE reponses SET iscorrect_reponse = 0 WHERE id_question = " . $id_question);
            // On met à vrai la bonne réponse à partir des données de $_SESSION
            $mysql_db -> query("UPDATE reponses SET iscorrect_reponse = 1 WHERE id_reponse = " . $_SESSION['quiz_to_admin']['questions'][$num_question]['reponses'][$value]['id_reponse']);
        }
    }
}

function get_data_quiz($id, $admin_is_on){
    /*global $mysql_db;

    // Récupération des données de la table quiz
    $result = $mysql_db -> query("SELECT id_quiz, titre_quiz, ispublic_quiz FROM quiz WHERE id_quiz = " . $id);
    if ($result -> num_rows > 0) {
        $_SESSION['quiz_to_admin'] = array();
        $_SESSION['quiz_to_admin']['quiz'] = $result->fetch_array(MYSQLI_ASSOC);

        // Récupération des données de la table questions et réponses
        $result = $mysql_db -> query("SELECT id_question, texte_question FROM questions WHERE id_quiz = " . $id);
        if ($result -> num_rows > 0) {
            $questions = [];

            $cpt = 0;
            while ($row = $result -> fetch_array(MYSQLI_ASSOC)){
                $questions[$cpt] = $row;

                $res = $mysql_db -> query("SELECT * FROM reponses WHERE id_question = " . $row['id_question']);
                while ($roww = $res -> fetch_array(MYSQLI_ASSOC)){
                    $questions[$cpt]['reponses'][] = $roww;
                }
                $cpt++;
            }

            $_SESSION['quiz_to_admin']['questions'] = $questions;
        }
    }*/
    global $mysql_db;

    $quiz = array();
    $return = NULL;

    // Récupération des données de la table quiz
    $result = $mysql_db -> query("SELECT id_quiz, titre_quiz, ispublic_quiz FROM quiz WHERE id_quiz = " . $id);
    if ($result -> num_rows > 0) {
        //$quiz['quiz_to_admin'] = array();
        $quiz['quiz'] = $result->fetch_array(MYSQLI_ASSOC);

        // Récupération des données de la table questions
        $result = $mysql_db -> query("SELECT id_question, texte_question FROM questions WHERE id_quiz = " . $id . " ORDER BY id_question");
        if ($result -> num_rows > 0) {
            $questions = [];

            $cpt = 0;
            while ($row = $result -> fetch_array(MYSQLI_ASSOC)){
                $questions[$cpt] = $row;

                // Récupération des données de la table reponses
                $res = $mysql_db -> query("SELECT * FROM reponses WHERE id_question = " . $row['id_question'] . " ORDER BY id_reponse");
                while ($roww = $res -> fetch_array(MYSQLI_ASSOC)){
                    $questions[$cpt]['reponses'][] = $roww;
                }
                $cpt++;
            }

            $quiz['questions'] = $questions;
        }

        // Si la fonction est appelée pour une administration
        if ($admin_is_on){
            $_SESSION['quiz_to_admin'] = $quiz;
        } else { // Si non, on vérifie que le quiz est public
            if ($quiz['quiz']['ispublic_quiz']) $return = $quiz;
        }
    }

    return $return;
}