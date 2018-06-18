<?php
    session_start();
	header("Content-type: text/html; charset: UTF-8");
?>
    <!DOCTYPE html>
    <html lang="fr">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="" content="">
        <title></title>
        <meta name="" content="">
        <link rel="stylesheet" href="../css/new_style.css">
    </head>

    <body>
        <?php include("./main_header.php")?>
        
        <?php
            try {
            // ETAPE 1 : Se connecter au serveur de base de données
                require("./param.inc.php");
                $pdo = new PDO("mysql:host=".MYHOST.";dbname=".MYDB, MYUSER, MYPASS);
                $pdo->query("SET NAMES utf8");
                $pdo->query("SET CHARACTER SET 'utf8'");

            // ETAPE 2 : Envoyer une requête SQL (demander la liste des données)
                $requeteSQL = "SELECT idLA FROM LISTE_ATTENTE WHERE lang = :paramLang AND idCat = :paramIdCat";
                $statement = $pdo->prepare($requeteSQL);
                $statement->execute(array(":paramLang" => $_GET["langue"],
                                          ":paramIdCat" => $_GET["categorie"]));
            / ETAPE 3 : Traiter les données retourner
                $ligne = $statement->fetch(PDO::FETCH_ASSOC);
                
                if($ligne == false) {
                    $requeteSQL2 = "INSERT INTO (lang, idCat) LISTE_ATTENTE VALUES (:paramLang, :paramIdCat)";
                    $statement = $pdo->prepare($requeteSQL2);
                    $statement->execute(array(":paramLang" => $_GET["langue"],
                                              ":paramIdCat" => $_GET["categorie"]));
                    $idLA = 
                } else {
                    $idLA = $ligne['idLA'];
                }
                
                
            // ETAPE 4 : Déconnecter du serveur
                $pdo = null;
            } catch (Exception $e) {
                echo($e);
            }
        ?>
        
        <main class="selectMulti">
            <h1>Le jeu en multijoueur est encore en développement !</h1>
        </main>

        <?php include("./main_footer.php")?>
    </body>

    </html>
