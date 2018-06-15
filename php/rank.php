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
        <!--        <link rel="stylesheet" href="../style.css">-->
        <link rel="stylesheet" href="../css/new_style.css">
    </head>

    <body>
        <?php include("./main_header.php"); ?>
            <main class="mainRank">
                <h1>Classement des joueurs</h1>
                <table>

                    <?php

                       //Etape 1 : connection à la base de données

                        require("param.inc.php") ;
                        $pdo=new PDO("mysql:host=".MYHOST.";dbname=".MYDB, MYUSER, MYPASS) ;
                        $pdo->query("SET NAMES utf8");
                        $pdo->query("SET CHARACTER SET 'utf8'");

                        //Etape 2 : envoie de la première requête SQL au serveur
                    
                        if (Membre::isLogged()){

                        $requeteSQL="SELECT membres.pseudoMbr AS 'nom', membres.linkIconMbr AS 'lien', COUNT(joue.score) AS 'score' ".
                                    "FROM membres ".
                                    "INNER JOIN joue ".
                                    "ON membres.idMbr = joue.idMbr ".
                                    "ORDER BY joue.score DESC";

                        $tabParam = array();

                        $statement = $pdo->prepare($requeteSQL) ;
                        $statement->execute($tabParam);

                        // Etape 3 : traite les données
                    
                        $ligne = $statement->fetch(PDO::FETCH_OBJ);
                            
                        $currentPosition = 1;
                            
                        while($ligne != $_POST[SESSION]){
                            $currentPosition += 1;
                            $ligne = $statement->fetch(PDO::FETCH_OBJ);
                        }

                    ?>

                        <tr>
                            <td>
                                <figure>
                                    <img alt="Photo de profil joueur" src="<?php echo($ligne->lien) ?>" />
                                </figure>
                                <p>
                                    <?php echo($ligne->nom) ?>
                                </p>
                            </td>
                            <td>
                                <?php echo($ligne->score) ?>
                            </td>
                            <td>
                                <?php echo($currentPosition) ?>
                            </td>
                        </tr>

                        <?php
                        }
                        ?>

                </table>
                <table>
                    <tr>
                        <th>Joueur</th>
                        <th>Score</th>
                        <th>Classement</th>
                    </tr>

                    <?php
                        
                        //Envoie de la seconde requête SQL au serveur
    
                        $requeteSQL2="SELECT membres.pseudoMbr AS 'nom', membres.linkIconMbr AS 'lien', COUNT(joue.score) AS 'score' ".
                                    "FROM membres ".
                                    "INNER JOIN joue ".
                                    "ON membres.idMbr = joue.idMbr ".
                                    "LIMIT 10 ".
                                    "ORDER BY joue.score DESC";

                        $tabParam2 = array();

                        $statement2 = $pdo->prepare($requeteSQL2) ;
                        $statement2->execute($tabParam2);

                        // Etape 3 : traite les données
                        
                        $currentPosition = 1;
                    
                        //Premier membre
                        $ligne2 = $statement2->fetch(PDO::FETCH_OBJ);

                        //Boucle sur chaque membre (BDD)
                        while($ligne2 != false){
	               ?>

                        <tr>
                            <td>
                                <figure>
                                    <img alt="Photo de profil joueur" src="<?php echo($ligne2->lien) ?>" />
                                </figure>
                                <p>
                                    <?php echo($ligne2->nom) ?>
                                </p>
                            </td>
                            <td>
                                <?php echo($ligne2->score) ?>
                            </td>
                            <td>
                                <?php echo($currentPosition) ?>
                            </td>
                        </tr>

                        <?php
                            //Membre suivant
                       
                            $currentPosition += 1; 
                            
                            $ligne2 = $statement2->fetch(PDO::FETCH_OBJ);
                            }
                    
                            //Fin boucle

                            // Etape 4 : ferme la connexion

                            $pdo = null;
                     ?>

                </table>
            </main>
            <?php include("./main_footer.php")?>
        
    </body>

    </html>