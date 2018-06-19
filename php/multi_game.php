<?php
    session_start();
	header("Content-type: text/html; charset: UTF-8");
?>
    <!DOCTYPE html>
    <html lang="fr">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="" content="">
        <title>Jeux multijoueur Filyso</title>
        <meta name="description" content="Bienvenue sur le jeu multijoueur de Filyso. Vous pourrez affronter d'autres joueurs en duel pour encore plus de fun !">
        <link rel="stylesheet" href="../css/new_style.css">
    </head>

    <body>
        <?php include("./main_header.php")?>
        
<!--
        <main class="selectMulti">
            <h1>Le jeu en multijoueur est encore en développement !</h1>
        </main>
-->

        <?php include("./main_footer.php")?>
        <script src="../javascript/multi_game.js"></script>
    </body>

    </html>
