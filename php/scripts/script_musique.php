<?php
    header('Content-type: application/json');

    if (isset($_POST["function"])) {
        
        switch ($_POST["function"]) {
            case "getMusique":
                if(isset($_POST['categorie']) && isset($_POST['lang']) && isset($_POST['forbiddenTimeCode'])) {
                    getMusique($_POST['categorie'], $_POST['lang'], json_decode($_POST['forbiddenTimeCode']));
                };
                break;
            case "getTimeCodeAnswer":
                if(isset($_POST['idTimeCode'])) {
                    getTimeCodeAnswer($_POST['idTimeCode']);
                };
                break;
            case "getTimeCodeAnswers":
                if(isset($_POST['idTimeCode'])) {
                    getTimeCodeAnswers($_POST['idTimeCode']);
                };
                break;
            case "getQuestion7":
                if(isset($_POST['idTimeCode'])) {
                    getQuestion7($_POST['idTimeCode']);
                };
                break;
            case "checkAnswer":
                if(isset($_POST['idTimeCode']) && isset($_POST['playerAnswer'])) {
                    checkAnswer($_POST['idTimeCode'], $_POST['playerAnswer']);
                };
                break;
            default:
                echo "{error: Fonction non défini}";
        }
        
    }


    function getMusique($categorie, $lang, $tabTimeCode) {
        
        // ETAPE 1 : Se connecter au serveur de base de données
        try {
            require("../param.inc.php");
            $pdo = new PDO("mysql:host=".MYHOST.";dbname=".MYDB, MYUSER, MYPASS);
            $pdo->query("SET NAMES utf8");
            $pdo->query("SET CHARACTER SET 'utf8'");
            
        // ETAPE 2 : Envoyer une requête SQL
            // conditions pour l'envoi de la requête en fonction du choix du joueur
            $conditionSQL = "";
            for($i = 0; $i < count($tabTimeCode); $i++) {
                $conditionSQL = $conditionSQL . " AND TIMECODES.idTimeCode != " . $tabTimeCode[$i];
            }
            
            if($categorie != 0 && $lang != "bilingue"){
                // cas où la catégorie est choisie et la langue est choisie
                $requeteSQL = "SELECT APPARTIENT_A_UNE.idCat, CHANSONS.lang, CHANSONS.nameSong, ARTISTES.nameArtist, CHANSONS.linkVideo, TIMECODES.idTimeCode, TIMECODES.startTimeCode, TIMECODES.timeCode, TIMECODES.previousLyrics, TIMECODES.trueRep, TIMECODES.falseRep1, TIMECODES.falseRep2, TIMECODES.falseRep3 FROM CHANSONS INNER JOIN APPARTIENT_A_UNE ON CHANSONS.idSong = APPARTIENT_A_UNE.idSong INNER JOIN TIMECODES ON CHANSONS.idSong = TIMECODES.idSong INNER JOIN A_UN ON CHANSONS.idSong = A_UN.idSong INNER JOIN ARTISTES ON A_UN.idArtist = ARTISTES.idArtist WHERE lang =:paramLangue and idCat=:paramCategorie".$conditionSQL." ORDER BY RAND() LIMIT 1";
                $statement = $pdo->prepare($requeteSQL);
                $statement->execute(array(":paramLangue" => $lang,
                                          ":paramCategorie" => $categorie));

            } else if($categorie == 0 && $lang != "bilingue") { 
                // cas où la catégorie n'est pas choisie et la langue est choisie
                $requeteSQL = "SELECT CHANSONS.lang, CHANSONS.nameSong, ARTISTES.nameArtist, CHANSONS.linkVideo, TIMECODES.idTimeCode, TIMECODES.startTimeCode, TIMECODES.timeCode, TIMECODES.previousLyrics, TIMECODES.trueRep, TIMECODES.falseRep1, TIMECODES.falseRep2, TIMECODES.falseRep3 FROM CHANSONS INNER JOIN APPARTIENT_A_UNE ON CHANSONS.idSong = APPARTIENT_A_UNE.idSong INNER JOIN TIMECODES ON CHANSONS.idSong = TIMECODES.idSong INNER JOIN A_UN ON CHANSONS.idSong = A_UN.idSong INNER JOIN ARTISTES ON A_UN.idArtist = ARTISTES.idArtist WHERE lang =:paramLangue".$conditionSQL." ORDER BY RAND() LIMIT 1";
                $statement = $pdo->prepare($requeteSQL);
                $statement->execute(array(":paramLangue" => $lang));

            } else if($categorie == 0 && $lang == "bilingue"){
                // cas où la catégorie n'est pas choisie et la langue n'est pas choisie
                $requeteSQL = "SELECT CHANSONS.nameSong, ARTISTES.nameArtist, CHANSONS.linkVideo, TIMECODES.idTimeCode, TIMECODES.startTimeCode, TIMECODES.timeCode, TIMECODES.previousLyrics, TIMECODES.trueRep, TIMECODES.falseRep1, TIMECODES.falseRep2, TIMECODES.falseRep3 FROM CHANSONS INNER JOIN TIMECODES ON CHANSONS.idSong = TIMECODES.idSong INNER JOIN A_UN ON CHANSONS.idSong = A_UN.idSong INNER JOIN ARTISTES ON A_UN.idArtist = ARTISTES.idArtist WHERE 1=1".$conditionSQL." ORDER BY RAND() LIMIT 1";
                $statement = $pdo->query($requeteSQL);

            } else if ($categorie != 0 && $lang == "bilingue"){
                // cas où la catégorie est choisie et la langue n'est pas choisie
                $requeteSQL = "SELECT APPARTIENT_A_UNE.idCat, CHANSONS.nameSong, ARTISTES.nameArtist, CHANSONS.linkVideo, TIMECODES.idTimeCode, TIMECODES.startTimeCode, TIMECODES.timeCode, TIMECODES.previousLyrics, TIMECODES.trueRep, TIMECODES.falseRep1, TIMECODES.falseRep2, TIMECODES.falseRep3 FROM CHANSONS INNER JOIN APPARTIENT_A_UNE ON CHANSONS.idSong = APPARTIENT_A_UNE.idSong INNER JOIN TIMECODES ON CHANSONS.idSong = TIMECODES.idSong INNER JOIN A_UN ON CHANSONS.idSong = A_UN.idSong INNER JOIN ARTISTES ON A_UN.idArtist = ARTISTES.idArtist WHERE idCat=:paramCategorie".$conditionSQL." ORDER BY RAND() LIMIT 1";
                $statement = $pdo->prepare($requeteSQL);
                $statement->execute(array(":paramCategorie" => $categorie));
            }
               
            $ligne = $statement->fetch(PDO::FETCH_ASSOC); 
            
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
                
            $retour = array(
                'idTimeCode'     => $ligne["idTimeCode"],
                'nameSong'       => $ligne["nameSong"],
                'nameArtist'     => $ligne["nameArtist"],
                'url'            => $url,
                'timeCodeStart'  => $startTime,
                'timeCodeEnd'    => $endTime,
                'previousLyrics' => stripslashes($ligne["previousLyrics"]),
            );
            
        // ETAPE 3 : Déconnecter du serveur                        
            $pdo = null;
            
            // Envoi du retour (on renvoi le tableau $retour encodé en JSON)
            echo json_encode($retour);
        } catch (Exception $e) {
        }
                                           
    }

    function getTimeCodeAnswers($idTimeCode) {
        // ETAPE 1 : Se connecter au serveur de base de données
        try {
            require("../param.inc.php");
            $pdo = new PDO("mysql:host=".MYHOST.";dbname=".MYDB, MYUSER, MYPASS);
            $pdo->query("SET NAMES utf8");
            $pdo->query("SET CHARACTER SET 'utf8'");
            
        // ETAPE 2 : Envoyer une requête SQL
            // conditions pour l'envoi de la requête en fonction du choix du joueur
            
            $requeteSQL = "SELECT previousLyrics, trueRep, falseRep1, falseRep2, falseRep3 FROM TIMECODES WHERE TIMECODES.idTimeCode=:paramIdTimeCode";
            
            $statement = $pdo->prepare($requeteSQL);
            $statement->execute(array(":paramIdTimeCode" => $idTimeCode));
            $ligne = $statement->fetch(PDO::FETCH_ASSOC);
            
            $retour = array('previousLyrics' => stripslashes($ligne["previousLyrics"]),
                            'answers'        => array(
                                    'rep1' => stripslashes($ligne["trueRep"]),
                                    'rep2' => stripslashes($ligne["falseRep1"]),
                                    'rep3' => stripslashes($ligne["falseRep2"]),
                                    'rep4' => stripslashes($ligne["falseRep3"])
                                ),
                            );
            
        // ETAPE 3 : Déconnecter du serveur                        
            $pdo = null;
            
            // Envoi du retour (on renvoi le tableau $retour encodé en JSON)
            echo json_encode($retour);
        } catch (Exception $e) {
        }
    }

    function getTimeCodeAnswer($idTimeCode) {
        // ETAPE 1 : Se connecter au serveur de base de données
        try {
            require("../param.inc.php");
            $pdo = new PDO("mysql:host=".MYHOST.";dbname=".MYDB, MYUSER, MYPASS);
            $pdo->query("SET NAMES utf8");
            $pdo->query("SET CHARACTER SET 'utf8'");
            
        // ETAPE 2 : Envoyer une requête SQL
            // conditions pour l'envoi de la requête en fonction du choix du joueur
            
            $requeteSQL = "SELECT trueRep FROM TIMECODES WHERE TIMECODES.idTimeCode=:paramIdTimeCode";
            
            $statement = $pdo->prepare($requeteSQL);
            $statement->execute(array(":paramIdTimeCode" => $idTimeCode));
            $ligne = $statement->fetch(PDO::FETCH_ASSOC);
            
            $retour = array('trueRep' => stripslashes($ligne["trueRep"]));
            
        // ETAPE 3 : Déconnecter du serveur                        
            $pdo = null;
            
            // Envoi du retour (on renvoi le tableau $retour encodé en JSON)
            echo json_encode($retour);
        } catch (Exception $e) {
        }
    }

    function getQuestion7($idTimeCode) {
        // ETAPE 1 : Se connecter au serveur de base de données
        try {
            require("../param.inc.php");
            $pdo = new PDO("mysql:host=".MYHOST.";dbname=".MYDB, MYUSER, MYPASS);
            $pdo->query("SET NAMES utf8");
            $pdo->query("SET CHARACTER SET 'utf8'");
            
        // ETAPE 2 : Envoyer une requête SQL
            // conditions pour l'envoi de la requête en fonction du choix du joueur
            
            $requeteSQL = "SELECT trueRep FROM TIMECODES WHERE TIMECODES.idTimeCode=:paramIdTimeCode";
            
            $statement = $pdo->prepare($requeteSQL);
            $statement->execute(array(":paramIdTimeCode" => $idTimeCode));
            $ligne = $statement->fetch(PDO::FETCH_ASSOC);
            
            $str = stripslashes($ligne["trueRep"]);
            $tabWords = explode(" ", $str);
            $wordIndex = rand(0, count($tabWords) - 1);
            
            $rightStr = "";
            for ($i = 0; $i < $wordIndex; $i++) {
                $rightStr = $rightStr . $tabWords[$i] . " ";
            }
            
            $leftStr = "";
            for ($i = $wordIndex + 1; $i < count($tabWords); $i++) {
                $leftStr = $leftStr  . " " . $tabWords[$i];
            }
            
            
            $retour = array('rightStr' => $rightStr,
                           'leftStr' => $leftStr);
            
        // ETAPE 3 : Déconnecter du serveur                        
            $pdo = null;
            
            // Envoi du retour (on renvoi le tableau $retour encodé en JSON)
            echo json_encode($retour);
        } catch (Exception $e) {
        }
    }

    function checkAnswer($idTimeCode, $playerAnswer) {
        // ETAPE 1 : Se connecter au serveur de base de données
        try {
            require("../param.inc.php");
            $pdo = new PDO("mysql:host=".MYHOST.";dbname=".MYDB, MYUSER, MYPASS);
            $pdo->query("SET NAMES utf8");
            $pdo->query("SET CHARACTER SET 'utf8'");
            
        // ETAPE 2 : Envoyer une requête SQL
            // conditions pour l'envoi de la requête en fonction du choix du joueur
            
            $requeteSQL = "SELECT LOWER(trueRep) AS trueRep FROM TIMECODES WHERE TIMECODES.idTimeCode=:paramIdTimeCode";
            
            $statement = $pdo->prepare($requeteSQL);
            $statement->execute(array(":paramIdTimeCode" => $idTimeCode));
            $ligne = $statement->fetch(PDO::FETCH_ASSOC);
            
            if ($playerAnswer == stripslashes($ligne['trueRep'])) {
                $retour = array('answerIsGood' => true);
            } else {
                $retour = array('answerIsGood' => false);
            }
            
        // ETAPE 3 : Déconnecter du serveur                        
            $pdo = null;
            
            // Envoi du retour (on renvoi le tableau $retour encodé en JSON)
            echo json_encode($retour);
        } catch (Exception $e) {
        }
    }
?>