<?php

include ('../functions.php');

$mysql_db = connexion_db();

if (isset($_POST['id_user'])) {
    foreach ($_POST['id_user'] as $id){
        $query = "DELETE FROM users WHERE id_user = '$id'";
        $mysql_db -> query($query);
    }
}

if (isset($_POST['id_quiz'])) {
    foreach ($_POST['id_quiz'] as $id){
        $query = "DELETE FROM quiz WHERE id_quiz = '$id'";
        $mysql_db -> query($query);
    }
}

if (isset($_POST['id_quiz_public'])) {
    $list_quiz = array();

    foreach ($_POST['id_quiz_public'] as $id){
        $result = $mysql_db -> query("SELECT * FROM quiz WHERE id_quiz = '$id'");
        $quiz = $result -> fetch_array(MYSQLI_ASSOC);
        $list_quiz[$id] = $quiz;
    }

    echo json_encode($list_quiz);
}

if (isset($_POST['id_quiz_set_public'])) {
    $post = $_POST['id_quiz_set_public'];

    for ($i = 0; $i < count($post['id_quiz']); $i++){
        $id_quiz = $post['id_quiz'][$i];
        $is_public = $post['is_public'][$i];
        $result = $mysql_db -> query("UPDATE quiz SET ispublic_quiz = ".$is_public." WHERE id_quiz = '$id_quiz'");
    }
}

if (isset($_POST['save_reponse'])) {
    $num_question = $_POST['save_reponse']['num_question_quiz'];
    $num_reponse = $_POST['save_reponse']['num_reponse'];

    $_SESSION['result_quiz'][$num_question] = $num_reponse;
}

if (isset($_POST['get_infos_quiz'])) {
    $result['resultats'] = $_SESSION['result_quiz'];
    $result['quiz'] = $_SESSION['quiz_to_do'];

    echo json_encode($result);
}