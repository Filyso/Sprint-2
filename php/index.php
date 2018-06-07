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
        <link href="https://fonts.googleapis.com/css?family=Montserrat:600,900" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Raleway:300,500,700" rel="stylesheet">
    </head>

    <body>
        <?php /*include("./main_header.php") */?>
        <main class="mainIndex">
            <h1>Bienvenue sur Filyso !</h1>
            <section>
                <h2>Qu'est-ce que Filsyo ?</h2>
                <p>Filyso est né dans le cadre d'un projet étudiant en 2018. Il s'agit d'un site vous proposant quelques jeux basés sur les paroles de chansons. Les jeux sont répartis en modes de jeu, en solo ou en multijoueur.<br/> Notre application est développée au département MMI de l'IUT de Laval, en France. Le but est d'imaginer et de concevoir une application en rapport avec un certain sujet et présentant certaines fonctionnalités. La première version que nous vous présentons ici est un prototype dans lequel seul le mode de jeu en solo n'est disponible.</p>
            </section>
            <a href="./select_game.php">JOUER</a>
            
            <div class="divVideo">
                <video autoplay muted loop id="video">
                    <source src="../videos/animation_principale.mp4" type="video/mp4">
                </video>
            </div>
        </main>

        <?php /*include("./main_footer.php")*/?>
    </body>

    </html>