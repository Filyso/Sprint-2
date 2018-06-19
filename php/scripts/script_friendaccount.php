<?php 
    if(isset($_GET["pseudoFriend"])){
                            
        $pdo = new PDO("mysql:host=".MYHOST.";dbname=".MYDB, MYUSER, MYPASS);
        $pdo->query("SET NAMES utf8");
        $pdo->query("SET CHARACTER SET 'utf8'");
                            
        $requeteSQL = "SELECT idMbr, pseudoMbr, linkIconMbr FROM MEMBRES WHERE pseudoMbr='".$_GET["pseudoFriend"]."'";
        $statement = $pdo->query($requeteSQL);
        $ligne = $statement->fetch(PDO::FETCH_ASSOC);

                           
                            
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
                                <img src="<?php echo($ligne["linkIconMbr"]); ?>" alt="Photo de profil de <?php echo($ligne["pseudoMbr"]); ?>"/>
                            </figure>
                            <p><?php echo($ligne["pseudoMbr"]); ?></p>
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