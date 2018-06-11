<?php
    echo "test";
    header('Content-type: application/json');


    if (isset($_POST["function"])) {
        
        switch ($_POST["function"]) {
            case "getMusique":
                if(isset($_POST['categorie']) && isset($_POST['lang'])) {
                    getMusique($_POST['categorie'], $_POST['lang']);
                }
                break;
            case "getTimeCodeAnswer":
                if(isset($_POST['idTimeCode'])) {
                    getMusiqueAnswer($_POST['idTimeCode']);
                }
                break;
            default:
                echo "{error: Fonction non défini}";
        }
    }


    function getMusique($categorie, $lang) {
        // ETAPE 1 : Se connecter au serveur de base de données
        try {
            require("./param.inc.php");
            $pdo = new PDO("mysql:host=".MYHOST.";dbname=".MYDB, MYUSER, MYPASS);
            $pdo->query("SET NAMES utf8");
            $pdo->query("SET CHARACTER SET 'utf8'");
            
        // ETAPE 2 : Envoyer une requête SQL
            // conditions pour l'envoi de la requête en fonction du choix du joueur
            
            if($categorie != 0 && $lang != "bilingue"){
                // cas où la catégorie est choisie et la langue est choisie
                $requeteSQL = "SELECT APPARTIENT_A_UNE.idCat, CHANSONS.lang, CHANSONS.nameSong, ARTISTES.nameArtist, CHANSONS.linkVideo, TIMECODES.idTimeCode, TIMECODES.startTimeCode, TIMECODES.timeCode, TIMECODES.previousLyrics, TIMECODES.trueRep, TIMECODES.falseRep1, TIMECODES.falseRep2, TIMECODES.falseRep3 FROM CHANSONS INNER JOIN APPARTIENT_A_UNE ON CHANSONS.idSong = APPARTIENT_A_UNE.idSong INNER JOIN TIMECODES ON CHANSONS.idSong = TIMECODES.idSong INNER JOIN A_UN ON CHANSONS.idSong = A_UN.idArtist INNER JOIN ARTISTES ON A_UN.idArtist = ARTISTES.idArtist WHERE lang =:paramLangue and idCat=:paramCategorie ORDER BY RAND() LIMIT 1";
                $statement = $pdo->prepare($requeteSQL);
                $statement->execute(array(":paramLangue" => $lang,
                                          ":paramCategorie" => $categorie));

            } else if($categorie == 0 && $lang != "bilingue") { 
                // cas où la catégorie n'est pas choisie et la langue est choisie
                $requeteSQL = "SELECT CHANSONS.lang, CHANSONS.nameSong, ARTISTES.nameArtist, CHANSONS.linkVideo, TIMECODES.idTimeCode, TIMECODES.startTimeCode, TIMECODES.timeCode, TIMECODES.previousLyrics, TIMECODES.trueRep, TIMECODES.falseRep1, TIMECODES.falseRep2, TIMECODES.falseRep3 FROM CHANSONS INNER JOIN APPARTIENT_A_UNE ON CHANSONS.idSong = APPARTIENT_A_UNE.idSong INNER JOIN TIMECODES ON CHANSONS.idSong = TIMECODES.idSong INNER JOIN A_UN ON CHANSONS.idSong = A_UN.idArtist INNER JOIN ARTISTES ON A_UN.idArtist = ARTISTES.idArtist WHERE lang =:paramLangue ORDER BY RAND() LIMIT 1";
                $statement = $pdo->prepare($requeteSQL);
                $statement->execute(array(":paramLangue" => $lang));

            } else if($categorie == 0 && $lang == "bilingue"){
                // cas où la catégorie n'est pas choisie et la langue n'est pas choisie
                $requeteSQL = "SELECT CHANSONS.nameSong, ARTISTES.nameArtist, CHANSONS.linkVideo, TIMECODES.idTimeCode, TIMECODES.startTimeCode, TIMECODES.timeCode, TIMECODES.previousLyrics, TIMECODES.trueRep, TIMECODES.falseRep1, TIMECODES.falseRep2, TIMECODES.falseRep3 FROM CHANSONS INNER JOIN TIMECODES ON CHANSONS.idSong = TIMECODES.idSong INNER JOIN A_UN ON CHANSONS.idSong = A_UN.idArtist INNER JOIN ARTISTES ON A_UN.idArtist = ARTISTES.idArtist ORDER BY RAND() LIMIT 1";
                $statement = $pdo->query($requeteSQL);

            } else if ($categorie != 0 && $lang == "bilingue"){
                // cas où la catégorie est choisie et la langue n'est pas choisie
                $requeteSQL = "SELECT APPARTIENT_A_UNE.idCat, CHANSONS.nameSong, ARTISTES.nameArtist, CHANSONS.linkVideo, TIMECODES.idTimeCode, TIMECODES.startTimeCode, TIMECODES.timeCode, TIMECODES.previousLyrics, TIMECODES.trueRep, TIMECODES.falseRep1, TIMECODES.falseRep2, TIMECODES.falseRep3 FROM CHANSONS INNER JOIN APPARTIENT_A_UNE ON CHANSONS.idSong = APPARTIENT_A_UNE.idSong INNER JOIN TIMECODES ON CHANSONS.idSong = TIMECODES.idSong INNER JOIN A_UN ON CHANSONS.idSong = A_UN.idArtist INNER JOIN ARTISTES ON A_UN.idArtist = ARTISTES.idArtist WHERE idCat=:paramCategorie ORDER BY RAND() LIMIT 1";
                $statement = $pdo->prepare($requeteSQL);
                $statement->execute(array(":paramCategorie" => $categorie));
            }
               
            $ligne = $statement->fetch(PDO::FETCH_ASSOC); 
            $currentMusic = 0;
            
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
            
            $retour = array(
                'idTimeCode'     => $ligne["idTimeCode"],
                'nameSong'       => $ligne["nameSong"],
                'nameArtist'     => $ligne["nameArtist"],
                'url'            => $url,
                'timeCodeStart'  => $startTime,
                'timeCodeEnd'    => $endTime,
                'previousLyrics' => $ligne["previousLyrics"],
                'answers'        => array(
                    'rep1'           => $ligne["trueRep"],
                    'rep2'           => $ligne["falseRep1"],
                    'rep3'           => $ligne["falseRep2"],
                    'rep4'           => $ligne["falseRep3"]
                )
            );
            
        // ETAPE 3 : Déconnecter du serveur                        
            $pdo = null;
        } catch (Exception $e) {
        }
        
        // Envoi du retour (on renvoi le tableau $retour encodé en JSON)
        echo json_encode($retour);
                                           
    }

    function getTimeCodeAnswer($idTimeCode) {
        // ETAPE 1 : Se connecter au serveur de base de données
        try {
            require("./param.inc.php");
            $pdo = new PDO("mysql:host=".MYHOST.";dbname=".MYDB, MYUSER, MYPASS);
            $pdo->query("SET NAMES utf8");
            $pdo->query("SET CHARACTER SET 'utf8'");
            
        // ETAPE 2 : Envoyer une requête SQL
            // conditions pour l'envoi de la requête en fonction du choix du joueur
            
            $requeteSQL = "SELECT trueRep FROM TIMECODES WHERE TIMECODES.idTimeCode = :paramIdTimeCode";
            
            $statement = $pdo->prepare($requeteSQL);
            $statement->execute(array(":paramIdTimeCode" => $idTimeCode));
            $ligne = $statement->fetch(PDO::FETCH_ASSOC);
            
            $retour = array('trueRep' => $ligne["trueRep"]);
            
        // ETAPE 3 : Déconnecter du serveur                        
            $pdo = null;
            
            // Envoi du retour (on renvoi le tableau $retour encodé en JSON)
            echo json_encode($retour);
        } catch (Exception $e) {
        }
    }
?>