<?php
	header("Content-type: text/html; charset: UTF-8");
?>
    <section class="selectMulti">
        <form action="admin.php" method="get">
            <table>
                <thead>
                    <tr>
                        <th></th>
                        <th>Chanson</th>
                        <th>Artiste</th>
                        <th colspan="2">Action</th>
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

                            $requeteSQL = "SELECT CHANSONS.idSong, nameSong, nameArtist FROM CHANSONS INNER JOIN A_UN ON CHANSONS.idSong = A_UN.idSong INNER JOIN ARTISTES ON A_UN.idArtist = ARTISTES.idArtist ORDER BY nameSong ASC";
                            $statement = $pdo->query($requeteSQL);

                        // ETAPE 3 : Traiter les données retourner
                            $ligne = $statement->fetch(PDO::FETCH_ASSOC);
                            while($ligne != false) {
                    ?>
                    <tr>
                        <td>
                            <?php echo($ligne["nameSong"])?>
                        </td>
                        <td>
                            <?php echo($ligne["nameArtist"])?>
                        </td>
                        <td><input type="submit" value="Modifier" name="admin" class="editSongBtn" /></td>
                        <td><input type="submit" value="Supprimer" name="admin" class="editSongBtn" /></td>
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
            <input type="hidden" value="0" name="song"/>
        </form>
    </section>
