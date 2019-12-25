<?php

include ('../functions.php');

$mysql_db = connexion_db();

if (isset($_POST['id_user'])) {
    foreach ($_POST['id_user'] as $id){
        $query = "DELETE FROM users WHERE id_user = '$id'";
        $mysql_db -> query($query);
    }
}