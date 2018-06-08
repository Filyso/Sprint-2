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
        <link rel="stylesheet" href="../css/style.css">
        <link href="https://fonts.googleapis.com/css?family=Montserrat:600,900" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Raleway:300,500,700" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    </head>

    <body>
       
        <?php include("./main_header.php")?>
        <main class="mainIndex particle-net" id="particle">
            <h1>Bienvenue sur</h1>

            <section>
<!--                <h2>Qu'est-ce que Filsyo ?</h2>-->
<!--                <p>Filyso est né dans le cadre d'un projet étudiant en 2018. Il s'agit d'un site vous proposant quelques jeux basés sur les paroles de chansons. Les jeux sont répartis en modes de jeu, en solo ou en multijoueur.<br/> Notre application est développée au département MMI de l'IUT de Laval, en France. Le but est d'imaginer et de concevoir une application en rapport avec un certain sujet et présentant certaines fonctionnalités. La première version que nous vous présentons ici est un prototype dans lequel seul le mode de jeu en solo n'est disponible.</p>-->
            </section>
            <a href="./select_game.php">JOUER</a>
        </main>
         

        <?php include("./main_footer.php")?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script type="text/javascript" src="../javascript/jsmaintest.js"></script>

    </body>

    </html>
