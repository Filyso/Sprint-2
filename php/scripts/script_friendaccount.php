<?php 
    if(isset($_GET["pseudoFriend"])){
                            
        $pdo = new PDO("mysql:host=".MYHOST.";dbname=".MYDB, MYUSER, MYPASS);
        $pdo->query("SET NAMES utf8");
        $pdo->query("SET CHARACTER SET 'utf8'");
                            
        $requeteSQL = "SELECT idMbr, pseudoMbr, linkIconMbr FROM MEMBRES WHERE pseudoMbr='".$_GET["pseudoFriend"]."'";
        $statement = $pdo->query($requeteSQL);
        $ligne = $statement->fetch(PDO::FETCH_ASSOC);

                           
                            
    }else{
        header("Location : account.php");
    }
        ?>

        <main class="mainAccount">
            <div class="infoJoueur">
                <figure class="figureImgJoueurAccount">
                    <img src="<?php echo($ligne["linkIconMbr"]); ?>" class="imgJoueurAccount"/>
                </figure>
                    <p class="pseudoJoueurAccount"><?php echo($ligne["pseudoMbr"]); ?></p>
                <input id="btnEdit" type="button" value="Retour" onClick='document.location.href="./account.php"'>
            </div>
            <div class="classementAccount">
                <table class="tableauAccount">
                    <tr>
                        <th>Joueur</th>
                        <th>Score</th>
                        <th>Classement</th>
                    </tr>   
                    
<?php
        $pseudoAmi = $ligne["pseudoMbr"];


        $requeteSQL="SELECT MEMBRES.idMbr, MEMBRES.pseudoMbr AS 'pseudo', MEMBRES.linkIconMbr AS 'icon', SUM(JOUE.score) AS 'score' ".
                                    "FROM MEMBRES ".
                                    "LEFT OUTER JOIN JOUE ".
                                    "ON MEMBRES.idMbr = JOUE.idMbr ".
                                    "GROUP BY MEMBRES.idMbr ".
                                    "ORDER BY SUM(JOUE.score) DESC";

               

        $statement = $pdo->query($requeteSQL);
           
 
            //troisième
            $ligne = $statement->fetch(PDO::FETCH_ASSOC);
            $currentPosition = 1;
            $compteur = 1;
            $pret = false;
            $previousScore =  $ligne["score"]; 
            $previousPlace = 0;
            $pseudoPlayer[$currentPosition] = $ligne["pseudo"];
            $iconPlayer[$currentPosition] = $ligne["icon"];
            $scorePlayer[$currentPosition] = $ligne["score"];
            $placePlayer[$currentPosition] = $currentPosition;
         
            $fin = false;
            $idTrouvee = false;
            $finboucle2 = false;
                
                
            
                while(!$idTrouvee){

                        if($pseudoPlayer[$currentPosition] == $pseudoAmi){
                            $idTrouvee = true;
                        }else{



                            $ligne = $statement->fetch(PDO::FETCH_ASSOC);
                            $currentPosition += 1;

                            if($ligne != false){
                                
                                if($ligne["score"] != $previousScore){

                                    $previousScore=$ligne["score"];
                                    $previousPlace=$currentPosition;
                                }
                                if($ligne["score"] == "" || $ligne["score"] == "0"){
                                    $previousScore = 0;
                                    
                                }

                            }
                            

                            $pseudoPlayer[$currentPosition] = $ligne["pseudo"];
                            $iconPlayer[$currentPosition] = $ligne["icon"];
                            $scorePlayer[$currentPosition] = $previousScore;
                            $placePlayer[$currentPosition] = $previousPlace;

                        }   
                    }
                    
                    if($placePlayer[$currentPosition] == 1){
                        //1er 
                        $nbTour = 6;
                    }else if($placePlayer[$currentPosition] == 2){
                        //2eme 
                        $nbTour = 5;
                    }else{
                        //reste 
                        $nbTour = 4;
                    }
                    
                    
                    while($idTrouvee && !$finboucle2){

                        $ligne = $statement->fetch(PDO::FETCH_ASSOC);
                        $currentPosition += 1;

                        if($ligne != false){

                                if($ligne["score"] != $previousScore){

                                    $previousScore=$ligne["score"];
                                    $previousPlace=$currentPosition;
                                }
                                if($ligne["score"] == "" || $ligne["score"] == "0"){
                                    $previousScore = 0;
                                    
                                }
                            $pseudoPlayer[$currentPosition] = $ligne["pseudo"];
                            $iconPlayer[$currentPosition] = $ligne["icon"];
                            $scorePlayer[$currentPosition] = $previousScore;
                            $placePlayer[$currentPosition] = $previousPlace;

                            $compteur +=1;
                            if($compteur == $nbTour){
                                $pret = true;
                                $compteur = 0;
                                $finboucle2 = true;
                                $currentPosition += -5;
                            }

                        }else{
                            
                            
                                $pret = true;
                                $compteur = 0;
                                $finboucle2 = true;
                                $currentPosition += -5;
                                 
                        }

                        

                    }

                $avantDernier = false;
                $dernier = false;
                    while($pret && !$fin && !$avantDernier && !$dernier){
                        

    ?>
                        <tr class="<?php if($pseudoPlayer[$currentPosition] == $pseudoAmi){echo("vous");} ?>">
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
                

      
                    
?>
<?php
      
        $pdo = new PDO("mysql:host=".MYHOST.";dbname=".MYDB, MYUSER, MYPASS);
        $pdo->query("SET NAMES utf8");
        $pdo->query("SET CHARACTER SET 'utf8'");
                            
        $requeteSQL = "SELECT idMbr, pseudoMbr, linkIconMbr FROM MEMBRES WHERE pseudoMbr='".$_GET["pseudoFriend"]."'";
        $statement = $pdo->query($requeteSQL);
        $ligne = $statement->fetch(PDO::FETCH_ASSOC);              
?>
                    
        
                
                </table>
            </div>
            <div class="badgesGagnes">
                <h2>Amis</h2>
                <div>
                    <table>
                        <tr>

                            <th>Amis de <?php echo($ligne["pseudoMbr"]); ?></th>
                          
                            <th></th>
                        </tr>
                    <?php
                        
                        $pdo = new PDO("mysql:host=".MYHOST.";dbname=".MYDB, MYUSER, MYPASS);
                        $pdo->query("SET NAMES utf8");
                        $pdo->query("SET CHARACTER SET 'utf8'");

                       
                        $requeteSQL = "SELECT DISTINCT AMI.isConnect, AMI.pseudoMbr, AMI.linkIconMbr 
FROM MEMBRES INNER JOIN AMIS ON MEMBRES.idMbr = AMIS.idMbr_Ami1 OR MEMBRES.idMbr = AMIS.idMbr_Ami2 INNER JOIN MEMBRES AS AMI ON (AMIS.idMbr_Ami1 = AMI.idMbr OR AMIS.idMbr_Ami2 = AMI.idMbr) AND MEMBRES.idMbr <> AMI.idMbr WHERE MEMBRES.idMbr = :idMbr";
                        $statement = $pdo->prepare($requeteSQL);
                        $statement->execute(array(":idMbr" => $ligne["idMbr"]));
                    
                        $ligne = $statement->fetch(PDO::FETCH_ASSOC);
                        while($ligne != false) {
                    ?>
                    <tr>
                        <td>
                        <figure>
                            <img src="<?php echo($ligne["linkIconMbr"]); ?>" alt="Photo de profil de <?php echo($ligne["pseudoMbr"]); ?>"/>
                            
                        </figure>
                            <p><?php echo($ligne["pseudoMbr"]); ?></p>
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