<?php include ('header.php'); ?>

<section class="section font-titles has-margin-top">
    <div class="container is-flex flex-center-hv">
        <div>
            <h1>Projet WEB 2019 - Quiz</h1>

            <?php
            global $mysql_db;

            $query = $mysql_db -> query("SELECT * FROM quiz WHERE ispublic_quiz = 1 ORDER BY id_quiz");

            if ($query -> num_rows > 0) : ?>
                <nav class="panel">
                    <p class="panel-heading">Quiz</p>
                    <div class="panel-block">
                        <p class="control has-icons-left">
                            <input class="input" id="searchquiz" type="text" placeholder="Rechercher">
                            <span class="icon is-left">
                                <i class="fas fa-search" aria-hidden="true"></i>
                            </span>
                        </p>
                    </div>

                    <div id="liste-quiz">
                        <?php while ($row = $query -> fetch_array(MYSQLI_ASSOC)) :
                            $userquery = $mysql_db -> query("SELECT * FROM users WHERE id_user = ".$row['id_user']);
                            $user = $userquery -> fetch_array(MYSQLI_ASSOC); ?>
                            <a class="panel-block" href="quiz.php?id=<?= $row['id_quiz'] ?>"><p><strong><?= $row['titre_quiz'] ?></strong> - <?= $user['nom_user'] ?></p></a>
                        <?php endwhile; ?>
                    </div>
                </nav>
            <?php else: ?>
                <p>Aucun quiz n'est publié</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>