<?php
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
        <link rel="stylesheet" href="../css/style_index.css">
        <link rel="stylesheet" href="../css/style_rank.css">
    </head>

    <body>
        <?php //include("./main_header.php")?>
            <main class="mainRank">
                <h1>Classement des joueurs</h1>
                <table>

                    <?php
                    
	                   //Etape 1 : connection à la base de données
		
                        require("param.inc.php") ;
                        $pdo=new PDO("mysql:host=".MYHOST.";dbname=".MYDB, MYUSER, MYPASS) ;
                        $pdo->query("SET NAMES utf8");
                        $pdo->query("SET CHARACTER SET 'utf8'");

                        //Etape 2 : envoie la requête SQL au serveur
                    
                     $requeteSQL="SELECT membres.pseudoMbr AS 'nom', membres.linkIconMbr AS 'lien', COUNT(joue.score) AS 'score' ".
                                    "FROM membres ".
                                    "INNER JOIN joue ".
                                    "ON membres.idMbr = joue.idMbr ".
                                    "LIMIT 10 ".
                                    "ORDER BY joue.score DESC";
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
                </table>
                <table>
                    <tr>
                        <th>Joueur</th>
                        <th>Score</th>
                        <th>Classement</th>
                    </tr>

                    <?php
                        $requeteSQL2="SELECT membres.pseudoMbr AS 'nom', membres.linkIconMbr AS 'lien', COUNT(joue.score) AS 'score' ".
                                    "FROM membres ".
                                    "INNER JOIN joue ".
                                    "ON membres.idMbr = joue.idMbr ".
                                    "LIMIT 10 ".
                                    "ORDER BY joue.score DESC";

                        $tabParam = array();

                        $statement = $pdo->prepare($requeteSQL2) ;
                        $statement->execute($tabParam);

                        // Etape 3 : traite les données
                        
                        $currentPosition = 1;
                    
                        //Premier membre
                        $ligne = $statement->fetch(PDO::FETCH_OBJ);

                        //Boucle sur chaque membre (BDD)
                        while($ligne != false){
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
                            //Membre suivant
                       
                            $currentPosition += 1; 
                            
                            $ligne = $statement->fetch(PDO::FETCH_OBJ);
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