<?php

include ('../functions.php');

$mysql_db = connexion_db();

if (isset($_POST['id_quiz'])) {
    foreach ($_POST['id_quiz'] as $id){
        $query = "DELETE FROM quiz WHERE id_quiz = '$id'";
        $mysql_db -> query($query);
    }
}