<?php
session_start();
header('Content-type: application/json');

if (isset($_POST["function"])) {
    switch ($_POST["function"]) {
        case "checkQueue":
            checkQueue();
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
        $requeteSQL = "SELECT MEMBRES.idMbr, LISTE_ATTENTE.idCat FROM MEMBRES INNER JOIN LISTE_ATTENTE ON MEMBRES.idLA = LISTE_ATTENTE.idLA WHERE MEMBRES.idLA =" . $_SESSION["idLA"] . " AND MEMBRES.idMbr <>" . $_SESSION["id"] . "";
    
        $statement = $pdo->query($requeteSQL);
        $ligne = $statement->fetch(PDO::FETCH_ASSOC);
        
        if (ligne != false) {
            $requeteSQL2 = "INSERT INTO LOBBY (waitingP1, waitingP2, idCat) VALUES (0,0,".$ligne["idCat"].")";
            $statement2 = $pdo->query($requeteSQL2);
            
            $requeteSQL2 = "SELECT LAST_INSERT_ID() AS idLobby";
            $statement2 = $pdo->query($requeteSQL2);
            $ligne2 = $statement2->fetch(PDO::FETCH_ASSOC);
            
            $requeteSQL2 = "UPDATE MEMBRES SET idLA = NULL, idLobby = " . $ligne2["idLobby"] . " WHERE idMbr = " . $_SESSION["id"] . " OR idMbr = " . $ligne["idMbr"];
            $statement2 = $pdo->query($requeteSQL2);
            
            $retour = array('competitorFind' => true,
                           'requete' => $requeteSQL);
        } else {
            $retour = array('competitorFind' => false,
                           'requete' => $requeteSQL);
        }
        
    // ETAPE 3 : Déconnecter du serveur                        
        $pdo = null;
        
        // Envoi du retour (on renvoi le tableau $retour encodé en JSON)
        echo json_encode($retour);
    } catch (Exception $e) {
    }
}
?>