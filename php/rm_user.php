<?php
    session_start();
	header("Content-type: text/html; charset: UTF-8");
    
    if(isset($_POST["arrayData"])) {
        
    }
?>
    <head>
        <meta charset="utf-8">
        <title>Jeu en Solo</title>
        <meta name="description" content="Le jeu SOLO ! Jouez seul contre l'ordinateur. Amusement garanti !">
        <script type="text/javascript" src="../javascript/rm_user.js"></script>
    </head>

    <section class="selectMulti">
        <h1>Gestion utilisateur</h1>
        <section class="selectMulti">
            
                <fieldset id="chansonForm">
                    <legend>Utilisateurs</legend>
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
                            require("./param.inc.php");
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
                                            <option name="role" value="normal" <?php echo($ligne[ "role"]=='' ? "selected": "") ?>>normal</option>
                                            <option name="role" value="moderateur" <?php echo($ligne[ "role"]=='modo' ? "selected": "") ?>> modérateur</option>
                                            <option name="role" value="administrateur" <?php echo($ligne[ "role"]=='admin' ? "selected": "") ?>>administrateur</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select class="statutMbr">
                                            <option name="statut" value="attente" <?php echo($ligne[ "statut"]=='0' ? "selected": "") ?>>En attente</option>
                                            <option name="statut" value="enregistre" <?php echo($ligne[ "statut"]=='1' ? "selected": "") ?>> Enregistré</option>
                                            <option name="statut" value="banni" <?php echo($ligne[ "statut"]=='2' ? "selected": "") ?>>Banni</option>
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
            <form action="rm_user.php" method="post" id="addSongForm" class="addSongForm">
                <div>
                    <input id="arrayData" type="hidden" value="" name="arrayData"/>
                    <input type="submit" value="APPLIQUER" />
                </div>
            </form>
        </section>
        <script type="text/javascript" src="../javascript/modify_song.js"></script>
    </section>