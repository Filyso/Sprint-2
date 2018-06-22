<?php
    session_start();
?>
    <html lang="fr">

    <head>
        <meta charset="UTF-8" />
        <title>Résultats de la partie SOLO</title>
        <meta name="description" content="Le jeu est terminé ! vous pouvez consulter les résultats et statistiques de votre partie en SOLO !"/>
        <link rel="stylesheet" href="../css/new_style.css" type="text/css" media="screen" />
        <link rel="shortcut icon" href="../images/favicon.png" />
    </head>

    <body>
        <?php include("./main_header.php"); ?>
        <main class="mainResultat">
            <div class="resultat">
                <div class="partieGauche">
                    <div class="cercleScore">
                        <p class="scoreResultat">Score</p>
                        <p class="chiffreScoreResultat">85</p>
                        <button type="button" class="btnSaveScore">Enregistrer</button>
                    </div>
                    <div class="partageReseaux">
                        <img src="../images/share_facebook.png" alt="partager sur facebook">
                        <img src="../images/share_twitter.png" alt="partager sur twitter">
                    </div>
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
        <?php include("./main_footer.php"); ?>
    </body>

    </html>
