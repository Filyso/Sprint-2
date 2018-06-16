<?php
    session_start();
	header("Content-type: text/html; charset: UTF-8");
?>

    <!DOCTYPE html>
    <html lang="fr">

    <head>
        <meta charset="utf-8">
        <title>Jeu en Solo</title>
        <meta name="description" content="Jouez !">
        <link rel="stylesheet" type="text/css" href="../css/new_style.css" />
        <script type="text/javascript" src="../javascript/popup_regles.js"></script>
    </head>

    <body>
        <?php include("./main_header.php");?>

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
                        <img alt="Photo de profil" src="<?php echo(Membre::isLogged() ? $_SESSION["icon"] : "../images/icons/default/mercury.jpg")?>" />
                    </figure>

                </div>

            </section>

            <div class="resultat">
                <div class="partieGauche">
                    <div class="cercleScore">
                        <p class="scoreResultat">Score</p>
                        <p class="chiffreScoreResultat" id="chiffreScoreResultat">85</p>
                    </div>
<!--
                    <div class="partageReseaux">
                        <img src="../images/share-on-facebook.png" alt="partager sur facebook">
                        <img src="../images/share-twitter.png" alt="partager sur twitter">
                    </div>
-->
                </div>
                <div class="partieDroite">
                    <div class="bonnesReponses">
                        <p class="nbBonneReponse" id="nbBonneReponse">6</p>
                        <p class="txtBonnesReponses">bonnes réponses</p>
                    </div>
                    <a href="pre_game_page.php"><button type="button" class="btnRejouer"><img src="../images/fleche.png" alt="fleche pour rejouer" class="imgReplay"><p>Rejouer</p></button></a>
                </div>
            </div>

        </main>

        <?php include("./main_footer.php");?>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script type="text/javascript" src="../javascript/game.js"></script>
    </body>

    </html>