<?php
	header("Content-type: text/html; charset: UTF-8");
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="" content="">
        <title></title>
        <meta name="" content="">
        <link rel="stylesheet" href="../css/style_index.css">

    </head>

    <body>
        <?php /*include("./main_header.php") */?>

        <main class="mainIndex">
            <h1>FILYSO</h1>

            <section class="indexLink">
                <a href="./select_game.php">JOUER</a>
            </section>

            <section class="welcomeIndex">
                <h2>Qu'est-ce que Filyso ?</h2>
                <p>Filyso est né dans le cadre d'un <strong>projet étudiant en 2018</strong>. Il s'agit d'un site vous proposant quelques <strong>jeux basés sur les paroles de chansons</strong>. Les jeux sont répartis en modes de jeu, en <strong>solo ou en multijoueur</strong>.<br/> Notre application est développée au département MMI de l'IUT de Laval, en France.</p>
            </section>

        </main>
        <?php include("./main_footer.php"); ?>
    </body>

</html>
