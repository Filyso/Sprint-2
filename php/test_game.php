<?php
	header("Content-type: text/html; charset: UTF-8");
?>

    <!DOCTYPE html>
    <html lang="fr">

    <head>

        <meta charset="utf-8">
        <title>Jeu en Solo</title>
        <meta name="description" content="Jouez !">
        <link href="https://fonts.googleapis.com/css?family=Montserrat:600,900" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="../style.css" />
    </head>

    <body>
        <?php include("./main_header.php");?>

        <main class="mainJeuSolo">

            <section class="sectionSolo">
                <div id="ytplayer" class="ytplayer"></div>

                <div class="score">
                    <figure>
                        <img alt="Photo de profil" src="../images/chat.jpg" />
                    </figure>

                    <div class="barScoreMax">
                        <div class="barScore">
                        </div>
                    </div>
                </div>

                <div class="contenu">
                    <div class="numEtTuto">

                        <input type="button" value="?" id="tutoButton" class="tutoButton" />

                        <p id="numQuestion" class="numQuestion">Question n°1</p>

                    </div>

                    <p id="phraseACompleter" class="phraseACompleter">Phrase à compléter</p>

                    <div class="reponses">
                        <div class="Sousreponses">
                            <button id="reponse1Button" class="reponseButton"></button>
                            <button id="reponse2Button" class="reponseButton"></button>
                        </div>
                        <div class="divTimer">
                            <p id="timer" class="timer">10</p>
                        </div>
                        <div class="Sousreponses">
                            <button id="reponse3Button" class="reponseButton"></button>
                            <button id="reponse4Button" class="reponseButton"></button>
                        </div>

                    </div>
                </div>
            </section>
        </main>

        <?php include("./main_footer.php");?>
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script type="text/javascript" src="../javascript/test_game.js"></script>
    </body>

    </html>