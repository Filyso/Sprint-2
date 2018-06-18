<?php
    session_start();
	header("Content-type: text/html; charset: UTF-8");
?>

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
                                <tr>
                                    <td>
                                        <?php echo($ligne["pseudo"])?>
                                    </td>
                                    <td>
                                        <select>
                                            <option value="normal" <?php echo($ligne[ "role"]=='' ? "selected": "") ?>>normal</option>
                                            <option value="moderateur" <?php echo($ligne[ "role"]=='modo' ? "selected": "") ?>> modérateur</option>
                                            <option value="administrateur" <?php echo($ligne[ "role"]=='admin' ? "selected": "") ?>>administrateur</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select>
                                            <option name="statut" value="attente" <?php echo($ligne[ "statut"]=='0' ? "selected": "") ?>>En attente</option>
                                            <option name="statut" value="actif" <?php echo($ligne[ "statut"]=='1' ? "selected": "") ?>> Enregistré</option>
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
            <form action="edit_song.php" method="post" id="addSongForm" class="addSongForm">
                <div>
                   <input type="hidden"/>
                    <input type="submit" value="APPLIQUER" />
                </div>
            </form>
        </section>
        <script type="text/javascript" src="../javascript/modify_song.js"></script>
    </section>