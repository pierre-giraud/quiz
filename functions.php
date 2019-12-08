<?php

/*
 * Fonction servant à se connecter à la base de données
 */
function connexion_db(){
    $db_host = "localhost:3308";
    $db_user = 'root';
    $db_pass = NULL;
    $db_name = 'quiz_db';

    $db_connexion = new mysqli($db_host, $db_user, $db_pass, $db_name) or die("Echec de la connexion");

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
    global $db_conn, $username;

    $username = mysqli_real_escape_string($db_conn, trim($_POST['username']));
    $password1 = mysqli_real_escape_string($db_conn, trim($_POST['password1']));

    $password = password_hash($password1, PASSWORD_DEFAULT);

    $query = "INSERT INTO users VALUES ('$username', '$password', 'user')";
    mysqli_query($db_conn, $query);
}