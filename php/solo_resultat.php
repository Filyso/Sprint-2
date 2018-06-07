<?php
	header("Content-type: text/html; charset: UTF-8");
?>
<head>
    <link rel="stylesheet" href="../style.css" type="text/css" media="screen" />
    <link href="https://fonts.googleapis.com/css?family=Montserrat:600,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,500,700" rel="stylesheet">
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
                        <img src="../images/share-on-facebook.png" alt="partager sur facebook">
                        <img src="../images/share-twitter.png" alt="partager sur twitter">
                    </div>
                </div>
                <div class="partieDroite">
                    <div class="bonnesReponses">
                        <p class="nbBonneReponse" id="nbBonneReponse">6</p>
                        <p class="txtBonnesReponses">bonnes réponses</p>
                    </div>
                    <a href="pre_game_page.php"><button type="button" class="btnRejouer"><img src="../images/fleche.png" alt="fleche pour rejouer" class="imgReplay"><p>Rejouer</p></button></a>
                    <div class="badgesObtenus">
                        <img src="../images/tropheeexemple.png" alt="exemples de badges gagnés">
                        <p>Badges obtenus</p>
                    </div>
                </div>
            </div>
        </main>
    <?php include("./main_footer.php"); ?>
</body>