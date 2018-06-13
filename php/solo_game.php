<?php
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
                        <div class="buttonTuto">
                        <input type="button" value="?" id="tutoButton" class="tutoButton"/>
                            </div>
                        

                        <p id="numQuestion" class="numQuestion">Question n°1</p>
                        <p id="NomEtArtiste" class="NomEtArtiste">Bella - Maître Gims</p>

                    </div>

                    <p id="phraseACompleter" class="phraseACompleter">"Phrase à compléter ... qui peut être très longue aaaaaaaaa jebg sdgjzeruhzeae g"</p>

                    <div class="reponses">
                        <div class="Sousreponses">
                            <button id="reponse1Button" class="reponseButton"> EXEMPLE DE REPONSE</button>

                            <button id="reponse2Button" class="reponseButton"> Lalalallalalaalaa </button>
                        </div>
                        <div class="divTimer">
                            <p id="timer" class="timer">10</p>
                        </div>
                        <div class="Sousreponses">
                            <button id="reponse3Button" class="reponseButton">Exemple Exemple Exemple Lalalallalalaalaa Exemple Exemple Exemple Exemple Lalalallalalaalaa  </button>

                            <button id="reponse4Button" class="reponseButton">Exemple de réponse</button>
                        </div>

                    </div>
                
                </div>

            </section>
            
            <div class="resultat">
                <div class="partieGauche">
                    <div class="cercleScore">
                        <p class="scoreResultat">Score</p>
                        <p class="chiffreScoreResultat" id="chiffreScoreResultat">85</p>
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
        
        <?php include("./main_footer.php");?>
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script type="text/javascript" src="../javascript/game.js"></script>
    </body>

    </html>
