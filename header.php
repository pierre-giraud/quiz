<?php
/*
 * Fichier d'entête
 */
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <?php
        if (isset($page_title)){ ?>
            <title><?php echo $page_title?></title>
    <?php
        } else { ?>
            <title>Quiz 2019</title>
    <?php
        }
    ?>

    <!--<link rel="stylesheet" href="style.css">-->
    <script type="text/javascript" src="js/validation.js"></script>
</head>
