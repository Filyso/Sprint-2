<?php 
    if(isset($_POST["amiSup"])){
                            
        $pdo = new PDO("mysql:host=".MYHOST.";dbname=".MYDB, MYUSER, MYPASS);
        $pdo->query("SET NAMES utf8");
        $pdo->query("SET CHARACTER SET 'utf8'");
                            
        $requeteSQL = "SELECT idMbr FROM MEMBRES WHERE pseudoMbr='".$_POST["amiSup"]."'";
        $statement = $pdo->query($requeteSQL);
        $ligne = $statement->fetch(PDO::FETCH_ASSOC);
                            
        $requeteSQL = "DELETE FROM AMIS WHERE (idMbr_Ami1 = '".$ligne["idMbr"]."' AND idMbr_Ami2 = '".$_SESSION["id"]."') OR (idMbr_Ami1 = ".$_SESSION["id"]." AND idMbr_Ami2 = '".$ligne["idMbr"]."') ";
        $statement = $pdo->query($requeteSQL);
                           
                            
    }
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
                <input id="btnEdit" type="button" value="Editer" onClick='document.location.href="./edit_account.php"'>
            </div>
            <div class="classementAccount">
                <table class="tableauAccount">
                    <tr>
                        <th>Joueur</th>
                        <th>Score</th>
                        <th>Classement</th>
                    </tr>
                    <tr>
                        <td>
                            <figure>
                                <img src="../images/chat.jpg" alt="Photo de profil joueur"/>
                            </figure>
                            <p>Michel</p>
                        </td>
                        <td>10.000</td>
                        <td>1</td>
                    </tr>
                    <tr>
                        <td>
                            <figure>
                                <img src="../images/chat.jpg" alt="Photo de profil joueur"/>
                            </figure>
                            <p>Samuel</p>
                        </td>
                        <td>9.000</td>
                        <td>2</td>
                    </tr>
                    <tr class="vous">
                        <td>
                            <figure>
                                <img src="<?php echo($_SESSION["icon"]); ?>" alt="Photo de profil joueur"/>
                            </figure>
                            <p>Vous</p>
                        </td>
                        <td>8.000</td>
                        <td>3</td>
                    </tr>
                    <tr>
                        <td>
                            <figure>
                                <img src="../images/chat.jpg" alt="Photo de profil joueur"/>
                            </figure>
                            <p>Antonin54</p>
                        </td>
                        <td>7.000</td>
                        <td>4</td>
                    </tr>
                    <tr>
                        <td>
                            <figure>
                                <img src="../images/chat.jpg" alt="Photo de profil joueur"/>
                            </figure>
                            <p>ElRodriguo</p>
                        </td>
                        <td>6.000</td>
                        <td>5</td>
                    </tr>
                </table>
            </div>
            <div class="badgesGagnes">
                <h2>Amis</h2>
                <form method="post" action="./account.php">
                    <input id="pseudoFriend" type="text" required="required" name="pseudoFriend" placeholder="Pseudo amis...">
                    <button id="searchFriend" type="submit">Ajouter</button>
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