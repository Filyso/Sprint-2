<?php
    session_start();
?>
    <!DOCTYPE html>
    <html lang="fr">

    <head>

        <meta charset="utf-8">
        <title>Classement des joueurs</title>
        <meta name="description" content="Bienvenue sur la page de classement de Filyso. Vous pouvez consulter votre propre classement et celui des autres joueurs. C'est l'esprit de compétition !">
        <link rel="stylesheet" href="../css/new_style.css">
        <link rel="shortcut icon" href="../images/favicon.png" />
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

                        $requeteSQL="SELECT MEMBRES.idMbr, MEMBRES.pseudoMbr AS 'nom', MEMBRES.linkIconMbr AS 'lien', SUM(JOUE.score) AS 'score' ".
                                    "FROM MEMBRES ".
                                    "LEFT OUTER JOIN JOUE ".
                                    "ON MEMBRES.idMbr = JOUE.idMbr ".
                                    "WHERE MEMBRES.isVerif = 1 ".
                                    "GROUP BY MEMBRES.idMbr ".
                                    "ORDER BY SUM(JOUE.score) DESC";

               

                        $statement = $pdo->query($requeteSQL);
           
                        // Etape 3 : traite les données
                    
                        $ligne = $statement->fetch(PDO::FETCH_OBJ);

                        $currentPosition = 1;
                        $previousPlace = $currentPosition;
                        $previousScore = $ligne->score;
                            
                        if($ligne->score == "" || $ligne->score == "0"){
                            $previousScore = 0;
                        }    
                            
                        while($ligne->idMbr != $_SESSION["id"] && $ligne != false){
                            
                            $currentPosition += 1;

                            
                            $ligne = $statement->fetch(PDO::FETCH_OBJ);
                            
                            
                            if($ligne != false){
                                
                                if($ligne->score != $previousScore){

                                    $previousScore=$ligne->score;
                                    $previousPlace=$currentPosition;
                                }
                                if($ligne->score == "" || $ligne->score == "0"){
                                    $previousScore = 0;
                                    
                                }
                                
                            }
                                                   


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
                                <?php echo($previousScore) ?>
                            </td>
                            <td>
                                <?php echo($previousPlace) ?>
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
    
                        $requeteSQL2="SELECT MEMBRES.pseudoMbr AS 'nom', MEMBRES.linkIconMbr AS 'lien', SUM(JOUE.score) AS 'score' ".
                                    "FROM MEMBRES ".
                                    "LEFT OUTER JOIN JOUE ".
                                    "ON MEMBRES.idMbr = JOUE.idMbr ".
                                    "WHERE MEMBRES.isVerif = 1 ".
                                    "GROUP BY MEMBRES.idMbr ".
                                    "ORDER BY SUM(JOUE.score) DESC ".
                                    "LIMIT 10";

  

                        $statement2 = $pdo->query($requeteSQL2) ;

                        // Etape 3 : traite les données
                        
                        $currentPosition = 1;
                    
                        //Premier membre
                        $ligne2 = $statement2->fetch(PDO::FETCH_OBJ);
                    
                        $previousScore=$ligne2->score;
                        $previousPlace=$currentPosition;
                        //Boucle sur chaque membre (BDD)
                        if($ligne2->score == ""){
                            $previousScore = 0;
                        }
                        while($currentPosition<=10 && $ligne2 != false){
                            
            
                            
                            
                            
                            
                            
	               ?>

                        <tr>
                            <td>
                                <figure>
                                    <img alt="Photo de profil joueur" src="<?php echo($ligne2->lien); ?>" />
                                </figure>
                                <p>
                                    <?php echo($ligne2->nom); ?>
                                </p>
                            </td>
                            <td>
                                <?php echo("<p>".$previousScore."</p>"); ?>
                            </td>
                            <td>
                                <?php echo("<p>".$previousPlace."</p>"); ?>
                            </td>
                        </tr>

                        <?php
                            //Membre suivant
                       
                            $currentPosition += 1; 
                            
                            $ligne2 = $statement2->fetch(PDO::FETCH_OBJ);
                            
                            if($ligne2 != false){
                                if($ligne2->score != $previousScore){

                                    $previousScore=$ligne2->score;
                                    $previousPlace=$currentPosition;
                                }
                                if($ligne2->score == "" || $ligne2->score == "0"){
                                    $previousScore = 0;
                                    
                                }
                                
                                
                            }
                            
                            

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