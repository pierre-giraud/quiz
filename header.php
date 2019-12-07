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
        if (isset($GLOBALS["page_title"])){ ?>
            <title><?php echo $GLOBALS["page_title"]?></title>
        <?php
        } else { ?>
            <title>Quiz 2019</title>
        <?php
        }
        ?>

    <!--<link rel="stylesheet" href="style.css">-->
    <!--<script src="script.js"></script>-->
</head>
