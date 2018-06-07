<?php
    /*function getMusique($categorie, $lang) {
        // ETAPE 1 : Se connecter au serveur de base de données
        try {
            require("./param.inc.php");
            $pdo = new PDO("mysql:host=".MYHOST.";dbname=".MYDB, MYUSER, MYPASS);
            $pdo->query("SET NAMES utf8");
            $pdo->query("SET CHARACTER SET 'utf8'");
            
        // ETAPE 2 : Envoyer une requête SQL

            // conditions pour l'envoi de la requête en fonction du choix du joueur
            
                // cas où la catégorie est choisie et la langue est choisie
            $requeteSQL = "SELECT APPARTIENT_A_UNE.idCat, CHANSONS.lang, CHANSONS.nameSong, ARTISTES.nameArtist, CHANSONS.linkVideo, TIMECODES.startTimeCode, TIMECODES.timeCode, TIMECODES.previousLyrics, TIMECODES.trueRep, TIMECODES.falseRep1, TIMECODES.falseRep2, TIMECODES.falseRep3 FROM CHANSONS INNER JOIN APPARTIENT_A_UNE ON CHANSONS.idSong = APPARTIENT_A_UNE.idSong INNER JOIN TIMECODES ON CHANSONS.idSong = TIMECODES.idSong INNER JOIN A_UN ON CHANSONS.idSong = A_UN.idArtist INNER JOIN ARTISTES ON A_UN.idArtist = ARTISTES.idArtist WHERE lang =:paramLangue and idCat=:paramCategorie ORDER BY RAND() LIMIT 7";
            $statement = $pdo->prepare($requeteSQL);
            $statement->execute(array(":paramLangue" => $_GET["langue"],
                                      ":paramCategorie" => $_GET["categorie"]));
        } catch (Exception $e){
            echo($e);
        }
    }

    function getTimeStart($idTimeCode, idSong) {
        echo "test";
    }*/

    // Récupération des paramètres
    $chaine = 0;
    if( isset($_POST['cat']) ){
        $chaine = $_POST['cat'];
    }

    // Traitements
    $retour = array(
        'chaine'    => strtoupper($chaine),
        'date'      => date('d/m/Y H:i:s'),
        'phpversion'=> phpversion()
    );

    // Envoi du retour (on renvoi le tableau $retour encodé en JSON)
    header('Content-type: application/json');
    echo json_encode($retour);
?>