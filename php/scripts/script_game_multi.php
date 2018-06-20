<?php
session_start();
header('Content-type: application/json');

if (isset($_POST["function"])) {
    switch ($_POST["function"]) {
        case "arePlayersReady":
            arePlayersReady();
            break;
        case "checkQueue":
            checkQueue();
            break;
        case "getTimeCode":
            if (isset($_POST["forbiddenTimeCode"])) {
                getTimeCode(json_decode($_POST['forbiddenTimeCode']));
            };
            break;
        case "playerIsReady":
            if (isset($_POST["playerIsReady"])) {
                playerIsReady($_POST["playerIsReady"]);
            };
            break;
        case "setSessionIdLobby":
            setSessionIdLobby();
            break;
        case "delLobby":
            delLobby();
            break;
        default:
            echo "{error: Fonction non défini}";
    }
}

function checkQueue() {
    // ETAPE 1 : Se connecter au serveur de base de données
    try {
        require("../param.inc.php");
        $pdo = new PDO("mysql:host=".MYHOST.";dbname=".MYDB, MYUSER, MYPASS);
        $pdo->query("SET NAMES utf8");
        $pdo->query("SET CHARACTER SET 'utf8'");
        
    // ETAPE 2 : Envoyer une requête SQL
        // conditions pour l'envoi de la requête en fonction du choix du joueur
        $requeteSQL = "SELECT MEMBRES.idLobby FROM MEMBRES WHERE MEMBRES.IdMbr = " . $_SESSION["id"];
        $statement = $pdo->query($requeteSQL);
        $ligne = $statement->fetch(PDO::FETCH_ASSOC);
        
        if ($ligne["idLobby"] == NULL) {
            $requeteSQL = "SELECT MEMBRES.idMbr, LISTE_ATTENTE.idCat, LISTE_ATTENTE.lang FROM MEMBRES INNER JOIN LISTE_ATTENTE ON MEMBRES.idLA = LISTE_ATTENTE.idLA WHERE MEMBRES.idLA =" . $_SESSION["idLA"] . " AND MEMBRES.idMbr <>" . $_SESSION["id"] . "";

            $statement = $pdo->query($requeteSQL);
            $ligne = $statement->fetch(PDO::FETCH_ASSOC);

            if ($ligne != false) {
                $requeteSQL3 = "INSERT INTO LOBBY (waitingP1, waitingP2, idCat, lang) VALUES (0,0," . ($ligne["idCat"] != "" ? $ligne["idCat"] : "NULL") . ", '" . $ligne["lang"] . "')";
                $statement2 = $pdo->query($requeteSQL3);

                $requeteSQL2 = "SELECT LAST_INSERT_ID() AS idLobby";
                $statement2 = $pdo->query($requeteSQL2);
                $ligne2 = $statement2->fetch(PDO::FETCH_ASSOC);

                $requeteSQL2 = "UPDATE MEMBRES SET idLA = NULL, idLobby = " . $ligne2["idLobby"] . " WHERE idMbr = " . $_SESSION["id"] . " OR idMbr = " . $ligne["idMbr"];
                $statement2 = $pdo->query($requeteSQL2);
                
                $_SESSION["idLobby"] = $ligne2["idLobby"];

                $retour = array('competitorFind' => false,
                               'requete' => $requeteSQL3);
            } else {
                $retour = array('competitorFind' => false,
                               'requete' => $requeteSQL);
            }
        } else {
            $_SESSION["idLobby"] = $ligne["idLobby"];
            $retour = array('competitorFind' => true);
        }
        
    // ETAPE 3 : Déconnecter du serveur                        
        $pdo = null;
        
        // Envoi du retour (on renvoi le tableau $retour encodé en JSON)
        echo json_encode($retour);
    } catch (Exception $e) {
    }
}

function getTimeCode($tabTimeCode) {
            
    // ETAPE 1 : Se connecter au serveur de base de données
    try {
        require("../param.inc.php");
        $pdo = new PDO("mysql:host=".MYHOST.";dbname=".MYDB, MYUSER, MYPASS);
        $pdo->query("SET NAMES utf8");
        $pdo->query("SET CHARACTER SET 'utf8'");
        
        $requeteSQL = "SELECT idTC" . (count($tabTimeCode) + 1) . " AS 'idTC', lang, idCat FROM LOBBY WHERE idLobby = " . $_SESSION["idLobby"];
        $statement = $pdo->query($requeteSQL);
        $ligne = $statement->fetch(PDO::FETCH_ASSOC);
        $retour = array('requete' => $requeteSQL);
        
        $categorie = ($ligne["idCat"] == NULL ? "0" : $ligne["idCat"]);
        $lang = $ligne["lang"];
        
        if($ligne["idTC"] == NULL) {

        // ETAPE 2 : Envoyer une requête SQL
            // conditions pour l'envoi de la requête en fonction du choix du joueur
            $conditionSQL = "";
            for($i = 0; $i < count($tabTimeCode); $i++) {
                $conditionSQL = $conditionSQL . " AND TIMECODES.idTimeCode != " . $tabTimeCode[$i];
            }

            if($categorie != 0 && $lang != "all"){
                // cas où la catégorie est choisie et la langue est choisie
                $requeteSQL = "SELECT APPARTIENT_A_UNE.idCat, CHANSONS.lang, CHANSONS.nameSong, ARTISTES.nameArtist, CHANSONS.linkVideo, TIMECODES.idTimeCode, TIMECODES.startTimeCode, TIMECODES.timeCode, TIMECODES.previousLyrics, TIMECODES.trueRep, TIMECODES.falseRep1, TIMECODES.falseRep2, TIMECODES.falseRep3 FROM CHANSONS INNER JOIN APPARTIENT_A_UNE ON CHANSONS.idSong = APPARTIENT_A_UNE.idSong INNER JOIN TIMECODES ON CHANSONS.idSong = TIMECODES.idSong INNER JOIN A_UN ON CHANSONS.idSong = A_UN.idSong INNER JOIN ARTISTES ON A_UN.idArtist = ARTISTES.idArtist WHERE lang =:paramLangue and idCat=:paramCategorie".$conditionSQL." ORDER BY RAND() LIMIT 1";
                $statement = $pdo->prepare($requeteSQL);
                $statement->execute(array(":paramLangue" => $lang,
                                          ":paramCategorie" => $categorie));

            } else if($categorie == 0 && $lang != "all") { 
                // cas où la catégorie n'est pas choisie et la langue est choisie
                $requeteSQL = "SELECT CHANSONS.lang, CHANSONS.nameSong, ARTISTES.nameArtist, CHANSONS.linkVideo, TIMECODES.idTimeCode, TIMECODES.startTimeCode, TIMECODES.timeCode, TIMECODES.previousLyrics, TIMECODES.trueRep, TIMECODES.falseRep1, TIMECODES.falseRep2, TIMECODES.falseRep3 FROM CHANSONS INNER JOIN APPARTIENT_A_UNE ON CHANSONS.idSong = APPARTIENT_A_UNE.idSong INNER JOIN TIMECODES ON CHANSONS.idSong = TIMECODES.idSong INNER JOIN A_UN ON CHANSONS.idSong = A_UN.idSong INNER JOIN ARTISTES ON A_UN.idArtist = ARTISTES.idArtist WHERE lang =:paramLangue".$conditionSQL." ORDER BY RAND() LIMIT 1";
                $statement = $pdo->prepare($requeteSQL);
                $statement->execute(array(":paramLangue" => $lang));

            } else if($categorie == 0 && $lang == "all"){
                // cas où la catégorie n'est pas choisie et la langue n'est pas choisie
                $requeteSQL = "SELECT CHANSONS.nameSong, ARTISTES.nameArtist, CHANSONS.linkVideo, TIMECODES.idTimeCode, TIMECODES.startTimeCode, TIMECODES.timeCode, TIMECODES.previousLyrics FROM CHANSONS INNER JOIN TIMECODES ON CHANSONS.idSong = TIMECODES.idSong INNER JOIN A_UN ON CHANSONS.idSong = A_UN.idSong INNER JOIN ARTISTES ON A_UN.idArtist = ARTISTES.idArtist WHERE 1=1".$conditionSQL." ORDER BY RAND() LIMIT 1";
                $statement = $pdo->query($requeteSQL);

            } else if ($categorie != 0 && $lang == "all"){
                // cas où la catégorie est choisie et la langue n'est pas choisie
                $requeteSQL = "SELECT APPARTIENT_A_UNE.idCat, CHANSONS.nameSong, ARTISTES.nameArtist, CHANSONS.linkVideo, TIMECODES.idTimeCode, TIMECODES.startTimeCode, TIMECODES.timeCode, TIMECODES.previousLyrics FROM CHANSONS INNER JOIN APPARTIENT_A_UNE ON CHANSONS.idSong = APPARTIENT_A_UNE.idSong INNER JOIN TIMECODES ON CHANSONS.idSong = TIMECODES.idSong INNER JOIN A_UN ON CHANSONS.idSong = A_UN.idSong INNER JOIN ARTISTES ON A_UN.idArtist = ARTISTES.idArtist WHERE idCat=:paramCategorie".$conditionSQL." ORDER BY RAND() LIMIT 1";
                $statement = $pdo->prepare($requeteSQL);
                $statement->execute(array(":paramCategorie" => $categorie));
            }
            
            $ligne = $statement->fetch(PDO::FETCH_ASSOC);
            
            $requeteSQL = "UPDATE LOBBY SET idTC" . (count($tabTimeCode) + 1) . "=" . $ligne["idTimeCode"] . " WHERE idLobby = " . $_SESSION["idLobby"];
            $statement = $pdo->query($requeteSQL);
            
        } else {
            $requeteSQL = "SELECT CHANSONS.nameSong, ARTISTES.nameArtist, CHANSONS.linkVideo, TIMECODES.idTimeCode, TIMECODES.startTimeCode, TIMECODES.timeCode, TIMECODES.previousLyrics FROM CHANSONS INNER JOIN APPARTIENT_A_UNE ON CHANSONS.idSong = APPARTIENT_A_UNE.idSong INNER JOIN TIMECODES ON CHANSONS.idSong = TIMECODES.idSong INNER JOIN A_UN ON CHANSONS.idSong = A_UN.idSong INNER JOIN ARTISTES ON A_UN.idArtist = ARTISTES.idArtist WHERE TIMECODES.idTimeCode = " . $ligne["idTC"];
            $statement = $pdo->query($requeteSQL);
            $ligne = $statement->fetch(PDO::FETCH_ASSOC);
        }
        
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

        $retour = array('idTimeCode'     => $ligne["idTimeCode"],
                        'nameSong'       => $ligne["nameSong"],
                        'nameArtist'     => $ligne["nameArtist"],
                        'url'            => $url,
                        'timeCodeStart'  => $startTime,
                        'timeCodeEnd'    => $endTime,
                        'previousLyrics' => stripslashes($ligne["previousLyrics"]));
            
    //ETAPE 3 : Déconnecter du serveur                        
        $pdo = null;
        
        // Envoi du retour (on renvoi le tableau $retour encodé en JSON)
        echo json_encode($retour);
    } catch (Exception $e) {
    }
                                           
}

function arePlayersReady() {
    try {
        require("../param.inc.php");
        $pdo = new PDO("mysql:host=".MYHOST.";dbname=".MYDB, MYUSER, MYPASS);
        $pdo->query("SET NAMES utf8");
        $pdo->query("SET CHARACTER SET 'utf8'");
        
    // ETAPE 2 : Envoyer une requête SQL
        // conditions pour l'envoi de la requête en fonction du choix du joueur
        $requeteSQL = "SELECT waitingP1, waitingP2 FROM LOBBY WHERE idLobby = " . $_SESSION["idLobby"];
        $statement = $pdo->query($requeteSQL);
        $ligne = $statement->fetch(PDO::FETCH_ASSOC);

        $playersAreReady = false;
        
        if ($ligne["waitingP1"] == 1 && $ligne["waitingP2"] == 1) {
            $playersAreReady = true;
        }
        
        $retour = array('playersAreReady' => $playersAreReady);
        
    // ETAPE 3 : Déconnecter du serveur                        
        $pdo = null;
        
    } catch (Exception $e) {
    }
}

function playerIsReady($bool) {
    try {
        require("../param.inc.php");
        $pdo = new PDO("mysql:host=".MYHOST.";dbname=".MYDB, MYUSER, MYPASS);
        $pdo->query("SET NAMES utf8");
        $pdo->query("SET CHARACTER SET 'utf8'");
        
    // ETAPE 2 : Envoyer une requête SQL
        // conditions pour l'envoi de la requête en fonction du choix du joueur
        $requeteSQL = "UPDATE LOBBY SET waitingP" . $_SESSION["playerNumber"] . " = " . ($bool ? "1":"0") . " WHERE idLobby = " . $_SESSION["idLobby"];
        $statement = $pdo->query($requeteSQL);
        $_SESSION["playerNumber"] = 1;
        
    // ETAPE 3 : Déconnecter du serveur                        
        $pdo = null;
        
    } catch (Exception $e) {
    }
}

function setPlayerNumber() {
    try {
        require("../param.inc.php");
        $pdo = new PDO("mysql:host=".MYHOST.";dbname=".MYDB, MYUSER, MYPASS);
        $pdo->query("SET NAMES utf8");
        $pdo->query("SET CHARACTER SET 'utf8'");
        
    // ETAPE 2 : Envoyer une requête SQL
        // conditions pour l'envoi de la requête en fonction du choix du joueur        
        $requeteSQL = "SELECT LOBBY.waitingP1 FROM LOBBY WHERE Lobby.idLobby = " . $_SESSION["idLobby"];
        $statement = $pdo->query($requeteSQL);
        $ligne = $statement->fetch(PDO::FETCH_ASSOC);
        
        if ($ligne["waitingP1"] == 0) {
            $requeteSQL = "UPDATE LOBBY SET waitingP1 = 1 WHERE idLobby = " . $_SESSION["idLobby"];
            $statement = $pdo->query($requeteSQL);
            $_SESSION["playerNumber"] = 1;
        } else {
            $requeteSQL = "UPDATE LOBBY SET waitingP1 = 0 WHERE idLobby = " . $_SESSION["idLobby"];
            $statement = $pdo->query($requeteSQL);
            $_SESSION["playerNumber"] = 2;
        }
        
    // ETAPE 3 : Déconnecter du serveur                        
        $pdo = null;
        
    } catch (Exception $e) {
    }
}

function setSessionIdLobby() {
    try {
        require("../param.inc.php");
        $pdo = new PDO("mysql:host=".MYHOST.";dbname=".MYDB, MYUSER, MYPASS);
        $pdo->query("SET NAMES utf8");
        $pdo->query("SET CHARACTER SET 'utf8'");
        
    // ETAPE 2 : Envoyer une requête SQL
        // conditions pour l'envoi de la requête en fonction du choix du joueur        
        $requeteSQL = "SELECT MEMBRES.idLobby FROM MEMBRES WHERE MEMBRES.idMbr = " . $_SESSION["id"];
        $statement = $pdo->query($requeteSQL);
        $ligne = $statement->fetch(PDO::FETCH_ASSOC);
        
        $_SESSION["idLobby"] = $ligne["idLobby"];
        
        setPlayerNumber();
        
    // ETAPE 3 : Déconnecter du serveur                        
        $pdo = null;
        
        // Envoi du retour (on renvoi le tableau $retour encodé en JSON)
        echo json_encode($retour);
    } catch (Exception $e) {
    }
}

function delLobby() {
    try {
        require("../param.inc.php");
        $pdo = new PDO("mysql:host=".MYHOST.";dbname=".MYDB, MYUSER, MYPASS);
        $pdo->query("SET NAMES utf8");
        $pdo->query("SET CHARACTER SET 'utf8'");
        
    // ETAPE 2 : Envoyer une requête SQL
        // conditions pour l'envoi de la requête en fonction du choix du joueur        
        $requeteSQL = "DELETE FROM LOBBY WHERE LOBBY.idLobby = " . $_SESSION["idLobby"];
        $statement = $pdo->query($requeteSQL);
        
        $_SESSION["idLobby"] = NULL;
        
    // ETAPE 3 : Déconnecter du serveur                        
        $pdo = null;
        
        // Envoi du retour (on renvoi le tableau $retour encodé en JSON)
        echo json_encode($retour);
    } catch (Exception $e) {
    }
}
?>