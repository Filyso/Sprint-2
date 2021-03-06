<?php
    session_start();
    if($_POST["autorisation"] != true){
        header("Location: index.php");
    }



	




?>
    <!DOCTYPE html>
    <html lang="fr">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="" content="">
        <title></title>
        <meta name="" content="">
        <link rel="stylesheet" href="../css/new_style.css">
        <link rel="shortcut icon" href="../images/favicon.png" />
    </head>

    <body>
        <?php include("./main_header.php")?>
        
        <?php
            try {
                $lang = $_POST["langue"] == "bilingue" ? "all" : $_POST["langue"];
            // ETAPE 1 : Se connecter au serveur de base de données
                require("./param.inc.php");
                $pdo = new PDO("mysql:host=".MYHOST.";dbname=".MYDB, MYUSER, MYPASS);
                $pdo->query("SET NAMES utf8");
                $pdo->query("SET CHARACTER SET 'utf8'");

            // ETAPE 2 : Envoyer une requête SQL (demander la liste des données)
                $requeteSQL = "SELECT idLA FROM LISTE_ATTENTE WHERE lang = '" . $lang . "' AND idCat ".($_POST["categorie"] == "0" ? "IS NULL" : ("= " . addslashes($_POST["categorie"])));
                $statement = $pdo->query($requeteSQL);


            // ETAPE 3 : Traiter les données retourner
                $ligne = $statement->fetch(PDO::FETCH_ASSOC);
                
                if($ligne == false) {
                    $requeteSQL2 = "INSERT INTO LISTE_ATTENTE (lang, idCat) VALUES (:paramLang, :paramIdCat)";
                    $statement2 = $pdo->prepare($requeteSQL2);
                    $statement2->execute(array(":paramLang" => $lang,
                                              ":paramIdCat" => $_POST["categorie"] == "0" ? NULL : $_POST["categorie"]));
                    
                    $requeteSQL3 = "SELECT LAST_INSERT_ID() AS idLA";
                    $statement3 = $pdo->query($requeteSQL3);
                    $ligne2 = $statement3->fetch(PDO::FETCH_ASSOC);
                    $idLA = $ligne2["idLA"];
                } else {
                    $idLA = $ligne["idLA"];
                }
                
                $_SESSION["idLA"] = $idLA;
                
                $requeteSQL = "UPDATE MEMBRES SET MEMBRES.idLA =" . $idLA . " WHERE MEMBRES.idMbr =" . $_SESSION["id"];
                $statement = $pdo->query($requeteSQL);
                
                
            // ETAPE 4 : Déconnecter du serveur
                $pdo = null;
            } catch (Exception $e) {
                echo($e);
            }
        ?>
        
        <main class="selectMulti">
            
           <div class="loaderMulti">
                <div class="loading">
           
                    <div class="loading-block"></div>
                    <div class="loading-block"></div>
                    <div class="loading-block"></div>       
                    
                </div>
                
                <p class="loading-label">EN ATTENTE D'ADVERSAIRES</p>
            </div>
                
        </main>

        <?php include("./main_footer.php")?>
        
        <script src="../javascript/matchmaking.js"></script>
    </body>

    </html>
