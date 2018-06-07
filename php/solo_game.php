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
        <script type="text/javascript" src="../javascript/popup_regles.js"></script>

        <?php
    if(isset($_GET["categorie"])){
     // ETAPE 1 : Se connecter au serveur de base de données
        try {
            require("./param.inc.php");
            $pdo = new PDO("mysql:host=".MYHOST.";dbname=".MYDB, MYUSER, MYPASS);
            $pdo->query("SET NAMES utf8");
            $pdo->query("SET CHARACTER SET 'utf8'");
            
    // ETAPE 2 : Envoyer une requête SQL

            // conditions pour l'envoi de la requête en fonction du choix du joueur
            
            if($_GET["categorie"] != 0 && $_GET["langue"] != "bilingue"){
                // cas où la catégorie est choisie et la langue est choisie
                $requeteSQL = "SELECT APPARTIENT_A_UNE.idCat, CHANSONS.lang, CHANSONS.nameSong, ARTISTES.nameArtist, CHANSONS.linkVideo, TIMECODES.startTimeCode, TIMECODES.timeCode, TIMECODES.previousLyrics, TIMECODES.trueRep, TIMECODES.falseRep1, TIMECODES.falseRep2, TIMECODES.falseRep3 FROM CHANSONS INNER JOIN APPARTIENT_A_UNE ON CHANSONS.idSong = APPARTIENT_A_UNE.idSong INNER JOIN TIMECODES ON CHANSONS.idSong = TIMECODES.idSong INNER JOIN A_UN ON CHANSONS.idSong = A_UN.idArtist INNER JOIN ARTISTES ON A_UN.idArtist = ARTISTES.idArtist WHERE lang =:paramLangue and idCat=:paramCategorie ORDER BY RAND() LIMIT 7";
                $statement = $pdo->prepare($requeteSQL);
                $statement->execute(array(":paramLangue" => $_GET["langue"],
                                          ":paramCategorie" => $_GET["categorie"]));

            } else if($_GET["categorie"] == 0 && $_GET["langue"] != "bilingue") { 
                // cas où la catégorie n'est pas choisie et la langue est choisie
                $requeteSQL = "SELECT CHANSONS.lang, CHANSONS.nameSong, ARTISTES.nameArtist, CHANSONS.linkVideo, TIMECODES.startTimeCode, TIMECODES.timeCode, TIMECODES.previousLyrics, TIMECODES.trueRep, TIMECODES.falseRep1, TIMECODES.falseRep2, TIMECODES.falseRep3 FROM CHANSONS INNER JOIN APPARTIENT_A_UNE ON CHANSONS.idSong = APPARTIENT_A_UNE.idSong INNER JOIN TIMECODES ON CHANSONS.idSong = TIMECODES.idSong INNER JOIN A_UN ON CHANSONS.idSong = A_UN.idArtist INNER JOIN ARTISTES ON A_UN.idArtist = ARTISTES.idArtist WHERE lang =:paramLangue ORDER BY RAND() LIMIT 7";
                $statement = $pdo->prepare($requeteSQL);
                $statement->execute(array(":paramLangue" => $_GET["langue"]));

            } else if($_GET["categorie"] == 0 && $_GET["langue"] == "bilingue"){
                // cas où la catégorie n'est pas choisie et la langue n'est pas choisie
                $requeteSQL = "SELECT CHANSONS.nameSong, ARTISTES.nameArtist, CHANSONS.linkVideo, TIMECODES.startTimeCode, TIMECODES.timeCode, TIMECODES.previousLyrics, TIMECODES.trueRep, TIMECODES.falseRep1, TIMECODES.falseRep2, TIMECODES.falseRep3 FROM CHANSONS INNER JOIN TIMECODES ON CHANSONS.idSong = TIMECODES.idSong INNER JOIN A_UN ON CHANSONS.idSong = A_UN.idArtist INNER JOIN ARTISTES ON A_UN.idArtist = ARTISTES.idArtist ORDER BY RAND() LIMIT 7";
                $statement = $pdo->query($requeteSQL);

            } else if ($_GET["categorie"] != 0 && $_GET["langue"] == "bilingue"){
                // cas où la catégorie est choisie et la langue n'est pas choisie
                $requeteSQL = "SELECT APPARTIENT_A_UNE.idCat, CHANSONS.nameSong, ARTISTES.nameArtist, CHANSONS.linkVideo, TIMECODES.startTimeCode, TIMECODES.timeCode, TIMECODES.previousLyrics, TIMECODES.trueRep, TIMECODES.falseRep1, TIMECODES.falseRep2, TIMECODES.falseRep3 FROM CHANSONS INNER JOIN APPARTIENT_A_UNE ON CHANSONS.idSong = APPARTIENT_A_UNE.idSong INNER JOIN TIMECODES ON CHANSONS.idSong = TIMECODES.idSong INNER JOIN A_UN ON CHANSONS.idSong = A_UN.idArtist INNER JOIN ARTISTES ON A_UN.idArtist = ARTISTES.idArtist WHERE idCat=:paramCategorie ORDER BY RAND() LIMIT 7";
                $statement = $pdo->prepare($requeteSQL);
                $statement->execute(array(":paramCategorie" => $_GET["categorie"]));
            }
               
            $ligne = $statement->fetch(PDO::FETCH_ASSOC);
?>
            <script>
                function Musique(nom, nomAutheur, url, timeCodeStart, timeCodeEnd, quest, reponse, false1, false2, false3) {
                    this.nom = nom;
                    this.nomAutheur = nomAutheur;
                    this.url = url;
                    this.timeCodeStart = timeCodeStart;
                    this.timeCodeEnd = timeCodeEnd;
                    this.quest = quest;
                    this.reponse = reponse;
                    this.false1 = false1;
                    this.false2 = false2;
                    this.false3 = false3;
                }

                <?php            
            $currentMusic = 0;
            
            while($ligne != false) {
                
                //Conversion des time codes en secondes
            
                $time0 = $ligne["startTimeCode"];
                $timeSegment0 = explode(":",$time0);
                $minute0 = intval($timeSegment0[1]);
                $seconde0 = intval($timeSegment0[2]);
                $startTime = 60*$minute0 + $seconde0;
                
                $time1 = $ligne["timeCode"];
                $timeSegment1 = explode(":",$time1);
                $minute1 = intval($timeSegment1[1]);
                $seconde1 = intval($timeSegment1[2]);
                $endTime = 60*$minute1 + $seconde1;      
                
                //Récupère la partie de l'URL qui nous intéresse
                
                $url = $ligne["linkVideo"];
                $urlSegment = explode("=",$url);
                $url = $urlSegment[1];
                
                $currentMusic += 1;

?>

                var musique<?php echo($currentMusic) ?> = new Musique(<?php echo('"'.$ligne["nameSong"].'"') ?>, <?php echo('"'.$ligne["nameArtist"].'"') ?>, <?php echo('"'.$url.'"') ?>, <?php echo('"'.$startTime.'"') ?>, <?php echo('"'.$endTime.'"') ?>, <?php echo('"'.$ligne["previousLyrics"].'"') ?>, <?php echo('"'.$ligne["trueRep"].'"') ?>, <?php echo('"'.$ligne["falseRep1"].'"') ?>, <?php echo('"'.$ligne["falseRep2"].'"') ?>, <?php echo('"'.$ligne["falseRep3"].'"') ?>);

                <?php
                    
            //Fin de la boucle
                    
                $ligne = $statement->fetch(PDO::FETCH_ASSOC);
            }
?>
                var tabMusique = new Array(musique1, musique2, musique3, musique4, musique5, musique6, musique7);

            </script>
            <?php                                   
        // ETAPE 3 : Déconnecter du serveur
                                           
            $pdo = null;
        
        } catch (Exception $e){
            echo($e);
        }
                                           
    }

?>
        <script type="text/javascript" src="../javascript/game.js"></script>
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
    </body>

    </html>
