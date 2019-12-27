<?php include ('header.php'); ?>

    <h1>Page d'accueil</h1>

<?php
    global $mysql_db;

    $query = $mysql_db -> query("SELECT * FROM quiz WHERE ispublic_quiz = 1");

    if ($query -> num_rows > 0) : ?>
        <table id="tablepublicquiz" border="1">
            <tr>
                <th>Numéro</th>
                <th>Intitulé</th>
                <th>Créateur</th>
            </tr>
            <?php while ($row = $query -> fetch_array(MYSQLI_ASSOC)) :
                $userquery = $mysql_db -> query("SELECT * FROM users WHERE id_user = ".$row['id_user']);
                $user = $userquery -> fetch_array(MYSQLI_ASSOC); ?>
                <tr id="rowpq_<?= $row['id_quiz'] ?>">
                    <td><?= $row['id_user'] ?></td>
                    <td><?= $row['titre_quiz'] ?></td>
                    <td><?= $user['nom_user'] ?></td>
                    <td><button type="button" name="access_quiz" id="acess_quiz" value="<?= $row['id_user'] ?>">Accéder</button></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>Aucun quiz n'est publié</p>
    <?php endif; ?>

<?php include 'footer.php'; ?>