<?php
    session_start();
?>
    <!DOCTYPE html>
    <html lang="fr">

    <head>
        <meta http-equiv="" content="">
        <title>Jeux multijoueur Filyso</title>
        <meta name="description" content="Bienvenue sur le jeu multijoueur de Filyso. Vous pourrez affronter d'autres joueurs en duel pour encore plus de fun !">
        <link rel="stylesheet" href="../css/new_style.css">
        <link rel="shortcut icon" href="../images/favicon.png" />
    </head>

    <body>
        <?php include("./main_header.php")?>

        <main class="mainJeuSolo">

            <div class="popup_regle">
                <div class="popup-content_regle">
                    <span class="close_regle">&times;</span>
                    <h2>RÈGLES</h2>
                    <ul>
                        <li>
                            <p>Écoutez la chanson diffusée par la vidéo ;</p>
                        </li>
                        <li>
                            <p>Des propositions de réponse vont s'afficher ;</p>
                        </li>
                        <li>
                            <p>Cliquer sur la bonne proposition pour compléter la phrase !</p>
                        </li>
                    </ul>
                </div>
            </div>

            <section class="sectionSolo">

                <div class="score">

                    <figure>
                        <img alt="Photo de profil" src="<?php echo(Membre::isLogged() ? $_SESSION["icon"] : "../images/icons/default/mercury.jpg ")?>" />
                    </figure>

                </div>
                
                <div class="score">
                    <figure>
                        <img alt="Photo de profil" src="<?php echo(Membre::isLogged() ? $_SESSION["icon"] : "../images/icons/default/mercury.jpg ")?>" />
                    </figure>
                </div>

            </section>

        </main>

        <?php include("./main_footer.php")?>
        <script src="../javascript/multi_game.js"></script>
        <script type="text/javascript" src="../javascript/popup_regles.js"></script>
    </body>

    </html>