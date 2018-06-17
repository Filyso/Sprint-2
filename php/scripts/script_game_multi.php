<?php
header('Content-type: application/json');

if (isset($_POST["function"])) {
    switch ($_POST["function"]) {
        case "checkQueue":
            if(isset($_POST['idQueue'])) {
                checkQueue();
            };
            break;
        default:
            echo "{error: Fonction non défini}";
    }
}
    

function checkQueue($idQueue) {
    // ETAPE 1 : Se connecter au serveur de base de données
    try {
        require("../param.inc.php");
        $pdo = new PDO("mysql:host=".MYHOST.";dbname=".MYDB, MYUSER, MYPASS);
        $pdo->query("SET NAMES utf8");
        $pdo->query("SET CHARACTER SET 'utf8'");
        
    // ETAPE 2 : Envoyer une requête SQL
        // conditions pour l'envoi de la requête en fonction du choix du joueur
        $requeteSQL = "SELECT idLA FROM LISTE_ATTENTE WHERE TIMECODES.idTimeCode=:paramIdTimeCode";
    
        $statement = $pdo->prepare($requeteSQL);
        $statement->execute(array(":paramIdTimeCode" => $idTimeCode));
        $ligne = $statement->fetch(PDO::FETCH_ASSOC);
    
        $retour = array('previousLyrics' => stripslashes($ligne["previousLyrics"]));

    // ETAPE 3 : Déconnecter du serveur                        
        $pdo = null;
    } catch (Exception $e) {
    }
}
?>