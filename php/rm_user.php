<?php 
    if(isset($_POST["arrayData"])) {
        
        require("./param.inc.php");
        $pdo = new PDO("mysql:host=".MYHOST.";dbname=".MYDB, MYUSER, MYPASS);
        $pdo->query("SET NAMES utf8");
        $pdo->query("SET CHARACTER SET 'utf8'");
        
        //Récupération du tableau
        $arrayData = json_decode($_POST["arrayData"], true);
        
        //On récupère les clés associatives du tableau (les PSEUDOS sur lesquels les changements sont appliqués)
        if(!empty($arrayData)){
            $keyArrayData = array_keys($arrayData);
        }
        //On calcule la longueur du tableau (le NOMBRE de pseu;dos sur lesquels les changements sont appliqués)
        $sizeArrayData = sizeof($arrayData);
        
        $i=0;
        //Pour chaque membre, on ajoute les CHANGEMENTS à la BDD
        for($i; $i < $sizeArrayData; $i++){
            
            //CAS DU STATUT
            if($arrayData[$keyArrayData[$i]][1]=="enregistre"){
                //update
                
                $requeteSQL = "UPDATE MEMBRES ".
                            "SET MEMBRES.isVerif = '1' ".
                            "WHERE MEMBRES.pseudoMbr = :paramPseudoMbr;";
                $statement = $pdo->prepare($requeteSQL);
                $statement->execute(array(":paramPseudoMbr" => $keyArrayData[$i]));
                
            }else if($arrayData[$keyArrayData[$i]][1]=="attente"){
                //update
                
                $requeteSQL = "UPDATE MEMBRES ".
                            "SET MEMBRES.isVerif = '0' ".
                            "WHERE MEMBRES.pseudoMbr = :paramPseudoMbr;";
                $statement = $pdo->prepare($requeteSQL);
                $statement->execute(array(":paramPseudoMbr" => $keyArrayData[$i]));
                
            }else if($arrayData[$keyArrayData[$i]][1]=="banni"){
                //update
                
                $requeteSQL = "UPDATE MEMBRES ".
                            "SET MEMBRES.isVerif = '2' ".
                            "WHERE MEMBRES.pseudoMbr = :paramPseudoMbr;";
                $statement = $pdo->prepare($requeteSQL);
                $statement->execute(array(":paramPseudoMbr" => $keyArrayData[$i]));
                
            }
            
            //CAS DU ROLE
            if($arrayData[$keyArrayData[$i]][0]=="normal"){
                
                $requeteSQL ="SELECT MEMBRES.idMbr AS 'id' ".
                    "FROM MEMBRES ".
                    "INNER JOIN ROLE ". 
                    "ON ROLE.idMbr = MEMBRES.idMbr ".
                    "WHERE MEMBRES.pseudoMbr = '".$keyArrayData[$i]."';";
                
                $statement = $pdo->query($requeteSQL);
                $ligne = $statement->fetch(PDO::FETCH_ASSOC);
                
                //Si le membre existe dans la table ROLE (et donc qu'il est admin ou modo)
                //delete
                if($ligne["id"] != false){    
                    $requeteSQLbis ="DELETE FROM ROLE ".
                        "WHERE ROLE.idMbr =:paramIDMbr;";
                    $statement = $pdo->prepare($requeteSQLbis);
                    $statement->execute(array(":paramIDMbr" => $ligne["id"]));
                }
                 
            }else if($arrayData[$keyArrayData[$i]][0]=="moderateur"){
                //update ou insert
                
                $requeteSQL="SELECT MEMBRES.idMbr AS 'id', ROLE.roleMbr AS 'oldRole' ".
                    "FROM MEMBRES ".
                    "INNER JOIN ROLE ".
                    "ON ROLE.idMbr = MEMBRES.idMbr ".
                    "WHERE MEMBRES.pseudoMbr = '".$keyArrayData[$i]."';";
                
                $statement = $pdo->query($requeteSQL);

                $ligne = $statement->fetch(PDO::FETCH_ASSOC);
                
                if($ligne["oldRole"]=="admin"){
                    $requeteSQLbis="UPDATE ROLE ".
                        "SET ROLE.roleMbr = 'modo' ".
                        "WHERE ROLE.idMbr = :paramIDMbr;"; 
                    $statement = $pdo->prepare($requeteSQLbis);
                    $statement->execute(array(":paramIDMbr" => $ligne["id"]));
                    
                }else if($ligne == false){
                    
                    $requeteSQL="SELECT MEMBRES.idMbr AS 'id' ".
                        "FROM MEMBRES ".
                        "WHERE MEMBRES.pseudoMbr = '".$keyArrayData[$i]."';";

                    $statement = $pdo->query($requeteSQL);

                    $ligne = $statement->fetch(PDO::FETCH_ASSOC);
                    
                    $requeteSQLbis="INSERT INTO ROLE (roleMbr, idMbr) ".
                        "VALUES ('modo', :paramIDMbr )";

                    $statement = $pdo->prepare($requeteSQLbis);
                    $statement->execute(array(":paramIDMbr" => $ligne["id"]));
                }
                
            }else if($arrayData[$keyArrayData[$i]][0]=="administrateur"){
                //update ou insert
                
                $requeteSQL="SELECT MEMBRES.idMbr AS 'id', ROLE.roleMbr AS 'oldRole' ".
                    "FROM MEMBRES ".
                    "INNER JOIN ROLE ".
                    "ON ROLE.idMbr = MEMBRES.idMbr ".
                    "WHERE MEMBRES.pseudoMbr = '".$keyArrayData[$i]."';";
                
                $statement = $pdo->query($requeteSQL);

                $ligne = $statement->fetch(PDO::FETCH_ASSOC);
                
                
                if($ligne["oldRole"]=="modo"){
                    $requeteSQLbis="UPDATE ROLE ".
                        "SET ROLE.roleMbr = 'admin' ".
                        "WHERE ROLE.idMbr = :paramIDMbr;";
                    $statement = $pdo->prepare($requeteSQLbis);
                    $statement->execute(array(":paramIDMbr" => $ligne["id"]));
                    
                }else if($ligne == false){
                    
                    $requeteSQL="SELECT MEMBRES.idMbr AS 'id' ".
                        "FROM MEMBRES ".
                        "WHERE MEMBRES.pseudoMbr = '".$keyArrayData[$i]."';";

                    $statement = $pdo->query($requeteSQL);

                    $ligne = $statement->fetch(PDO::FETCH_ASSOC);
                    
                    $requeteSQLbis="INSERT INTO ROLE ".
                        "VALUES ('admin', :paramIDMbr );";

                    $statement = $pdo->prepare($requeteSQLbis);
                    $statement->execute(array(":paramIDMbr" => $ligne["id"]));
                }
            }
        }
    }
?>

<section class="rmUser">
    <fieldset class="tableauUsers">
        <table>
            <thead>
                <tr>
                    <th>Pseudos</th>
                    <th>Rôle</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                <?php
                        try {
                        // ETAPE 1 : Se connecter au serveur de base de données
                            if(!isset($_POST["arrayData"])) {
                                require("./param.inc.php");
                            }
                            $pdo = new PDO("mysql:host=".MYHOST.";dbname=".MYDB, MYUSER, MYPASS);
                            $pdo->query("SET NAMES utf8");
                            $pdo->query("SET CHARACTER SET 'utf8'");

                        // ETAPE 2 : Envoyer une requête SQL (demander la liste des données)
                            $requeteSQL = "SELECT MEMBRES.pseudoMbr AS 'pseudo', MEMBRES.isVerif AS 'statut', ROLE.roleMbr AS 'role' ".
                            "FROM MEMBRES ".
                            "LEFT OUTER JOIN ROLE ". 
                            "ON MEMBRES.idMbr = ROLE.idMbr ".    
                            "ORDER BY MEMBRES.pseudoMbr ASC";
                            $statement = $pdo->query($requeteSQL);

                        // ETAPE 3 : Traiter les données retourner
                            $ligne = $statement->fetch(PDO::FETCH_ASSOC);
                            while($ligne != false) {
                    ?>
                    <tr class="mbr">
                        <td>
                            <?php echo($ligne["pseudo"])?>
                        </td>
                        <td>
                            <select class="roleMbr">
                                            <option name="role" value="normal" <?php echo($ligne["role"]=='' ? "selected": "") ?>>normal</option>
                                            <option name="role" value="moderateur" <?php echo($ligne["role"]=='modo' ? "selected": "") ?>> modérateur</option>
                                            <option name="role" value="administrateur" <?php echo($ligne["role"]=='admin' ? "selected": "") ?>>administrateur</option>
                                        </select>
                        </td>
                        <td>
                            <select class="statutMbr">
                                            <option name="statut" value="attente" <?php echo($ligne["statut"]=='0' ? "selected": "") ?>>En attente</option>
                                            <option name="statut" value="enregistre" <?php echo($ligne["statut"]=='1' ? "selected": "") ?>> Enregistré</option>
                                            <option name="statut" value="banni" <?php echo($ligne["statut"]=='2' ? "selected": "") ?>>Banni</option>
                                        </select>
                        </td>
                    </tr>
                    <?php
                                $ligne = $statement->fetch(PDO::FETCH_ASSOC);
                            }
                            // Fin de la boucle
                        // ETAPE 4 : Déconnecter du serveur
                            $pdo = null;
                            } catch (Exception $e) {
                                echo($e);
                            }
                    ?>
            </tbody>
        </table>
    </fieldset>
    <form action="admin.php?admin=Gérer les utilisateurs" method="post" id="rm_user" class="addSongForm">
        <div>
            <input id="arrayData" type="hidden" value="" name="arrayData" />
            <input type="submit" value="APPLIQUER" />
        </div>
    </form>
</section>
<script type="text/javascript" src="../javascript/rm_user.js"></script>
