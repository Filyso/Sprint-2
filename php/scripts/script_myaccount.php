<?php 
    
    $pdo=new PDO("mysql:host=".MYHOST.";dbname=".MYDB, MYUSER, MYPASS) ;
    $pdo->query("SET NAMES utf8");
    $pdo->query("SET CHARACTER SET 'utf8'");

    if(isset($_POST["amiSup"])){
                            

                            
        $requeteSQL = "SELECT idMbr FROM MEMBRES WHERE pseudoMbr='".$_POST["amiSup"]."'";
        $statement = $pdo->query($requeteSQL);
        $ligne = $statement->fetch(PDO::FETCH_ASSOC);
                            
        $requeteSQL = "DELETE FROM AMIS WHERE (idMbr_Ami1 = '".$ligne["idMbr"]."' AND idMbr_Ami2 = '".$_SESSION["id"]."') OR (idMbr_Ami1 = ".$_SESSION["id"]." AND idMbr_Ami2 = '".$ligne["idMbr"]."') ";
        $statement = $pdo->query($requeteSQL);
                           
                            
    }
    

    //Etape 2 : envoie de la première requête SQL au serveur
                    
    
        ?>

        <main class="mainAccount">
            <div class="infoJoueur">
                <figure class="figureImgJoueurAccount">
                    <img src="<?php echo($_SESSION["icon"]); ?>" class="imgJoueurAccount"/>
                </figure>
                    <p class="pseudoJoueurAccount"><?php echo($_SESSION["pseudo"]); ?></p>
                    <p class="nomJoueurAccount">Nom : <?php echo($_SESSION["nom"]); ?></p>
                    <p class="prenomJoueurAccount">Prénom : <?php echo($_SESSION["prenom"]); ?></p>
                    <p class="mailJoueurAccount">Mail : <?php echo($_SESSION["mail"]); ?></p>
                <input class="btnEdit" id="btnEdit" type="button" value="Editer" onClick='document.location.href="./edit_account.php"'>
            </div>
            <div class="classementAccount">
                <table class="tableauAccount">
                    <tr>
                        <th>Joueur</th>
                        <th>Score</th>
                        <th>Classement</th>
                    </tr>
                    
<?php
  


        $requeteSQL="SELECT MEMBRES.idMbr, MEMBRES.pseudoMbr AS 'pseudo', MEMBRES.linkIconMbr AS 'icon', SUM(JOUE.score) AS 'score' ".
                                    "FROM MEMBRES ".
                                    "LEFT OUTER JOIN JOUE ".
                                    "ON MEMBRES.idMbr = JOUE.idMbr ".
                                    "GROUP BY MEMBRES.idMbr ".
                                    "ORDER BY SUM(JOUE.score) DESC";

               

        $statement = $pdo->query($requeteSQL);
           
        // Etape 3 : traite les données
                   
        //premier
        $ligne = $statement->fetch(PDO::FETCH_ASSOC);
        $currentPosition = 1;
        
                    
        $pseudoPlayer[$currentPosition] = $ligne["pseudo"];
        $iconPlayer[$currentPosition] = $ligne["icon"];
        $scorePlayer[$currentPosition] = $ligne["score"];
        $placePlayer[$currentPosition] = $currentPosition;
        
        $previousScore =  $ligne["score"];  
                    
                    
        if($pseudoPlayer[$currentPosition] == $_SESSION["pseudo"]){
            
            while($currentPosition<=5 && $ligne != false){
                
?>
                    <tr <?php if($pseudoPlayer[$currentPosition] == $_SESSION["pseudo"]){echo("class=\"vous\"");} ?></tr>
                        <td>
                            <figure>
                                <img src="<?php echo($iconPlayer[$currentPosition]); ?>" alt="Photo de profil de <?php echo($pseudoPlayer[$currentPosition]); ?>"/>
                            </figure>
                            <p><?php echo($pseudoPlayer[$currentPosition]); ?></p>
                        </td>
                        <td><?php echo($scorePlayer[$currentPosition]); ?></td>
                        <td><?php echo($placePlayer[$currentPosition]); ?></td>
                    </tr>                 
<?php

                $ligne = $statement->fetch(PDO::FETCH_ASSOC);
                $currentPosition += 1;
            
                                       
                                       
                if($ligne != false){
                    
                    if($ligne != false){
                        
                        if($ligne["score"] == ""){
                            $previousScore = 0;
                        } 
                        
                        if($ligne["score"] != $previousScore){
                            $previousScore=$ligne["score"];
                            $previousPlace=$currentPosition;
                                    
                        }

                    }
                    
                    $pseudoPlayer[$currentPosition] = $ligne["pseudo"];
                    $iconPlayer[$currentPosition] = $ligne["icon"];
                    $scorePlayer[$currentPosition] = $previousScore;
                    $placePlayer[$currentPosition] = $previousPlace;
            
                }
                                       
            
            }
              
        }else{
            //deuxieme
            $ligne = $statement->fetch(PDO::FETCH_ASSOC);
            $currentPosition += 1;
            $compteur = 1;
            $pret = false;
            $previousScore =  $ligne["score"]; 
            
            $pseudoPlayer[$currentPosition] = $ligne["pseudo"];
            $iconPlayer[$currentPosition] = $ligne["icon"];
            $scorePlayer[$currentPosition] = $ligne["score"];
            $placePlayer[$currentPosition] = $currentPosition;
            
            
            $fin = false;
            $idTrouvee = false;
            $finboucle2 = false;
                
                
            if($_SESSION["pseudo"] == $ligne["pseudo"]){
                while(!$idTrouvee){

                        if($pseudoPlayer[$currentPosition] == $_SESSION["pseudo"]){
                            $idTrouvee = true;
                           
                        }else{



                            $ligne = $statement->fetch(PDO::FETCH_ASSOC);
                            $currentPosition += 1;

                            if($ligne != false){
                                
                                if($ligne["score"] == ""){
                                    $previousScore = 0;
                                } 
                                
                                if($ligne["score"] != $previousScore){
                                    $previousScore=$ligne["score"];
                                    $previousPlace=$currentPosition;

                                }

                            }

                            $pseudoPlayer[$currentPosition] = $ligne["pseudo"];
                            $iconPlayer[$currentPosition] = $ligne["icon"];
                            $scorePlayer[$currentPosition] = $previousScore;
                            $placePlayer[$currentPosition] = $previousPlace;


                        }   
                    }
                    while($idTrouvee && !$finboucle2){

                        $ligne = $statement->fetch(PDO::FETCH_ASSOC);
                        $currentPosition += 1;

                        if($ligne != false){
                            
                            if($ligne["score"] == ""){
                                $previousScore = 0;
                            } 
                            
                            if($ligne["score"] != $previousScore){
                                $previousScore=$ligne["score"];
                                $previousPlace=$currentPosition;

                            }

                        }

                        $pseudoPlayer[$currentPosition] = $ligne["pseudo"];
                        $iconPlayer[$currentPosition] = $ligne["icon"];
                        $scorePlayer[$currentPosition] = $previousScore;
                        $placePlayer[$currentPosition] = $previousPlace;

                        $compteur +=1;
                       
                        if($compteur == 4){
                            $pret = true;
                            $compteur = 0;
                            $finboucle2 = true;
                            $currentPosition += -4;
                        }

                    }

                    while($pret && !$fin){


    ?>
                        <tr class="<?php if($pseudoPlayer[$currentPosition] == $_SESSION["pseudo"]){echo("vous");} ?>">
                            <td>
                                <figure>
                                    <img src="<?php echo($iconPlayer[$currentPosition]); ?>" alt="Photo de profil de <?php echo($pseudoPlayer[$currentPosition]); ?>"/>
                                </figure>
                                <p><?php echo($pseudoPlayer[$currentPosition]); ?></p>
                            </td>
                            <td><?php echo($scorePlayer[$currentPosition]); ?></td>
                            <td><?php echo($placePlayer[$currentPosition]); ?></td>
                        </tr>                 
    <?php               
                        $currentPosition += 1;
                        $compteur += 1;
                        
                        if($compteur>=5){
                            $fin = true;
                        }


                    }
                
            }else{
            

            //troisième
            $ligne = $statement->fetch(PDO::FETCH_ASSOC);
            $currentPosition += 1;
            $compteur = 1;
            $pret = false;
            $previousScore =  $ligne["score"]; 
            
            $pseudoPlayer[$currentPosition] = $ligne["pseudo"];
            $iconPlayer[$currentPosition] = $ligne["icon"];
            $scorePlayer[$currentPosition] = $ligne["score"];
            $placePlayer[$currentPosition] = $currentPosition;
         
            $fin = false;
            $idTrouvee = false;
            $finboucle2 = false;
                
                
            
                while(!$idTrouvee){

                        if($pseudoPlayer[$currentPosition] == $_SESSION["pseudo"]){
                            $idTrouvee = true;
                        }else{



                            $ligne = $statement->fetch(PDO::FETCH_ASSOC);
                            $currentPosition += 1;

                            if($ligne != false){
                                
                                if($ligne["score"] == ""){
                                    $previousScore = 0;
                                } 
                                
                                if($ligne["score"] != $previousScore){
                                    $previousScore=$ligne["score"];
                                    $previousPlace=$currentPosition;

                                }

                            }
                            

                            $pseudoPlayer[$currentPosition] = $ligne["pseudo"];
                            $iconPlayer[$currentPosition] = $ligne["icon"];
                            $scorePlayer[$currentPosition] = $previousScore;
                            $placePlayer[$currentPosition] = $previousPlace;

                        }   
                    }
                    while($idTrouvee && !$finboucle2){

                        $ligne = $statement->fetch(PDO::FETCH_ASSOC);
                        $currentPosition += 1;

                        if($ligne != false){

                            if($ligne["score"] == ""){
                                $previousScore = 0;
                            } 
                            
                            if($ligne["score"] != $previousScore){
                                $previousScore=$ligne["score"];
                                $previousPlace=$currentPosition;

                            }
                            $pseudoPlayer[$currentPosition] = $ligne["pseudo"];
                            $iconPlayer[$currentPosition] = $ligne["icon"];
                            $scorePlayer[$currentPosition] = $previousScore;
                            $placePlayer[$currentPosition] = $previousPlace;

                            $compteur +=1;
                            if($compteur == 4){
                                $pret = true;
                                $compteur = 0;
                                $finboucle2 = true;
                                $currentPosition += -5;
                            }

                        }else{
                            
                            if($compteur == 3){
                                $pret = true;
                                $compteur = 0;
                                $finboucle2 = true;
                                $currentPosition += -5;
                            }
                            if($compteur == 2){
                                $pret = true;
                                $compteur = 0;
                                $finboucle2 = true;
                                $currentPosition += -5;
                            }                  
                        }

                        

                    }

                $avantDernier = false;
                $dernier = false;
                    while($pret && !$fin && !$avantDernier && !$dernier){
                        

    ?>
                        <tr class="<?php if($pseudoPlayer[$currentPosition] == $_SESSION["pseudo"]){echo("vous");} ?>">
                            <td>
                                <figure>
                                    <img src="<?php echo($iconPlayer[$currentPosition]); ?>" alt="Photo de profil de <?php echo($pseudoPlayer[$currentPosition]); ?>"/>
                                </figure>
                                <p><?php echo($pseudoPlayer[$currentPosition]); ?></p>
                            </td>
                            <td><?php echo($scorePlayer[$currentPosition]); ?></td>
                            <td><?php echo($placePlayer[$currentPosition]); ?></td>
                        </tr>                 
    <?php               
                        
                        
                        
                        $currentPosition += 1;
                        $compteur += 1;
                        if($compteur>=5){
                            $fin = true;
                        }


                    }
                
                
            
        }
        }
      
                    
?>
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                </table>
            </div>
            <div class="badgesGagnes">
                <h2>Amis</h2>
                <form method="post" action="./account.php">
                    <input id="pseudoFriend" type="text" required="required" name="pseudoFriend" placeholder="Pseudo amis..." class="btnAmis">
                    <button class="submitAmis" id="searchFriend" type="submit"><img src="../images/icon_addFriend.png" alt="Icone ajouter un ami"/></button>
                </form>
                <?php
                    if(isset($_POST["pseudoFriend"])){
                        $pdo = new PDO("mysql:host=".MYHOST.";dbname=".MYDB, MYUSER, MYPASS);
                        $pdo->query("SET NAMES utf8");
                        $pdo->query("SET CHARACTER SET 'utf8'");
                        
                        
                        $requeteSQL = "SELECT idMbr FROM MEMBRES WHERE pseudoMbr= :pseudoFriend";
                        $statement = $pdo->prepare($requeteSQL);
                        $statement->execute(array(":pseudoFriend" => $_POST["pseudoFriend"]));
                        $ligne = $statement->fetch(PDO::FETCH_ASSOC);
                        
                        $idami = $ligne["idMbr"];
                        
                        if($ligne != false){
                            
                            $requeteSQL = "SELECT idMbr_Ami1 FROM AMIS WHERE ( idMbr_Ami1=".$idami." AND idMbr_Ami2=".$_SESSION["id"]." ) OR ( idMbr_Ami1=".$_SESSION["id"]." AND idMbr_Ami2=".$idami." )";
                            $statement = $pdo->query($requeteSQL);
                            $ligne = $statement->fetch(PDO::FETCH_ASSOC);
                            
                            if($ligne == false){
                                $requeteSQL = "INSERT INTO AMIS (`idMbr_Ami1`, `idMbr_Ami2`) VALUES ('".$_SESSION["id"]."', '".$idami."')";
                                $statement = $pdo->query($requeteSQL);
                                echo("<p>Ami(e) ajouté(e)</p>");
                            }else{
                                if($idami == $_SESSION["id"]){
                                    echo("<p>Vous ne pouvez pas vous ajouté(e) en ami</p>");
                                }else{
                                    echo("<p>Ami déjà ajouté</p>");
                                }
                                
                            }
 
                        }else{
                            
                            echo("<p>Votre ami(e) n'a pas été(e) trouvé(e)</p>");
                        }
                        
                        $pdo = null;
                    }
                        
                        
                
                ?>
                <div>
                    <table>
                        <tr>

                            <th>Profil</th>
                          
                            <th></th>
                        </tr>
                    <?php
                        
                        $pdo = new PDO("mysql:host=".MYHOST.";dbname=".MYDB, MYUSER, MYPASS);
                        $pdo->query("SET NAMES utf8");
                        $pdo->query("SET CHARACTER SET 'utf8'");

                       
                        $requeteSQL = "SELECT DISTINCT AMI.isConnect, AMI.pseudoMbr, AMI.linkIconMbr 
FROM MEMBRES INNER JOIN AMIS ON MEMBRES.idMbr = AMIS.idMbr_Ami1 OR MEMBRES.idMbr = AMIS.idMbr_Ami2 INNER JOIN MEMBRES AS AMI ON (AMIS.idMbr_Ami1 = AMI.idMbr OR AMIS.idMbr_Ami2 = AMI.idMbr) AND MEMBRES.idMbr <> AMI.idMbr WHERE MEMBRES.idMbr = :idMbr";
                        $statement = $pdo->prepare($requeteSQL);
                        $statement->execute(array(":idMbr" => $_SESSION["id"]));
                    
                        $ligne = $statement->fetch(PDO::FETCH_ASSOC);
                        while($ligne != false) {
                    ?>
                    <tr>
                        <td>
                        <figure>
                            <img src="<?php echo($ligne["linkIconMbr"]); ?>" alt="Photo de profil de <?php echo($ligne["pseudoMbr"]); ?>"/>
                            
                        </figure>
                            <a href="./account.php?pseudoFriend=<?php echo($ligne["pseudoMbr"]); ?>"><?php echo($ligne["pseudoMbr"]); ?></a>
                        </td>
                 
                        <td>
                            <?php
                            if($ligne["isConnect"] == 1){
                            
                            ?>
                            <figure>
                                <img src="../images/list.png" alt="<?php echo($ligne["pseudoMbr"]); ?> est connecté"/>
                            </figure>
                            <?php
                            }
                            
                            ?>
                            <form action="account.php" method="post">
                                <input type="submit" value="Supprimer"/>
                                <input type="hidden" value="<?php echo($ligne["pseudoMbr"]);?>" name="amiSup" />
                            </form>
                        </td>
                    </tr>
                    </div>
                    
                    <?php
                            $ligne = $statement->fetch(PDO::FETCH_ASSOC);
                        }
                        $pdo = null;
                        
                        
                        
                    ?>
                    </table>
                </div>
            </div>
        </main>