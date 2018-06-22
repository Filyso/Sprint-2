<?php
    session_start();
?>
    <!DOCTYPE html>
    <html lang="fr">

    <head>
        <meta charset="utf-8" />
        <title>Bienvenue sur Filyso</title>
        <meta name="description" content="Bienvenue sur Filyso! Ce site vous propose des jeux musicaux totalement inédits et très divertissants. Vous pouvez jouer seul ou contre d'autres joueurs, alors n'attendez plus !">
        <link rel="stylesheet" href="../css/new_style.css" />
        <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
        <link rel="shortcut icon" href="../images/favicon.png" />
    </head>

    <body class="indexColor">
        <?php include("./main_header.php") ?>

        <main class="mainIndex">
            <h1>FILYSO</h1>
            <h2 class="slogan">Listen, Find, Enjoy !</h2>
            <section class="indexLink" id="particle">
                <a href="./select_game.php">JOUER</a>
            </section>

            <section class="welcomeIndex">
                <h2>Bienvenue sur le site Filyso !</h2>
                <p>Prenez part à la compétition en rejoignant une communauté réunie autour de l’amour de la musique. Affrontez des joueurs et des amis à travers des séries de quiz, où vous devrez retrouver les paroles de vos chansons préférées à travers de nombreux thèmes musicaux. <br>Défiez les plus grands, et tentez de devenir le grand champion ! Besoin de vous faire la main avant d’entrer dans l’arène ?<br> Envie de vous tester dans une catégorie en particulier ?<br> Notre mode solo est là pour ça ! <br>Pour gagner en expérience, étoffez votre culture musicale, prenez du galon, enchaînez les exploits et hissez vous en tête du classement ! <strong>Et rappelez-vous : on ne gagne pas sans s’amuser !</strong> <br>En savoir plus sur <a href="about.php" class="lienAbout">notre équipe...</a></p>
            </section>

        </main>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <?php include("./main_footer.php"); ?>
        <script type="text/javascript" src="../javascript/jsAnimParticules.js"></script>
    </body>

    </html>
