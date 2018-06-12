<?php
	header("Content-type: text/html; charset: UTF-8");
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="" content="">
        <title>Bienvenue sur Filyso</title>
        <meta name="" content="">
        <link rel="stylesheet" href="../css/new_style.css">
        <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    </head>

    <body class="indexColor">
        <?php include("./main_header.php") ?>

        <main class="mainIndex" >
            <h1>FILYSO</h1>
            
            <section class="indexLink" id="particle">
                <a href="./select_game.php">JOUER</a>
            </section>

            <section class="welcomeIndex" >
                <h2>Qu'est-ce que Filyso ?</h2>
                <p>Filyso est né dans le cadre d'un <strong>projet étudiant en 2018</strong>. Il s'agit d'un site vous proposant quelques <strong>jeux basés sur les paroles de chansons</strong>. Les jeux sont répartis en modes de jeu, en <strong>solo ou en multijoueur</strong>.<br/> Notre application est développée au département MMI de l'IUT de Laval, en France.</p>
            </section>

        </main>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <?php include("./main_footer.php"); ?>
        <script type="text/javascript" src="../javascript/jsAnimParticules.js"></script>
    </body>

</html>
