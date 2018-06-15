<?php
    session_start();
	header("Content-type: text/html; charset: UTF-8");

    if(isset($_POST["admin"]) && $_POST["admin"] == "supprimer") {
        try {
            // ETAPE 1 : Se connecter au serveur de base de données
            require("./param.inc.php");
            $pdo = new PDO("mysql:host=".MYHOST.";dbname=".MYDB, MYUSER, MYPASS);
            $pdo->query("SET NAMES utf8");
            $pdo->query("SET CHARACTER SET 'utf8'");
            
            // ETAPE 2 : Envoyer une requête SQL (demander la liste des données)
            $requeteSQL = "DELETE FROM CHANSONS WHERE CHANSONS.idSong = :paramIdSong";
            $statement = $pdo->prepare($requeteSQL);
            $statement->execute(array(":paramIdSong" => $_POST["songId"]));
            
            // ETAPE 4 : Déconnecter du serveur
            $pdo = null;
        } catch (Exception $e) {
            echo($e);
        }
    }
?>
    <section class="selectMulti">
        <table>
            <thead>
                <tr>
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
                        <td>
                            <form action="./edit_song.php" method="post">
                                <input type="submit" value="Modifier" name="admin" class="editSongBtn" />
                            </form>
                        </td>
                        <td>
                            <form action="admin.php?admin=Modification%2FSuppression+de+chansons" method="post">
                                <input type="button" value="Supprimer" class="suppSongBtn" />
                                <input type="hidden" value="supprimer" name="admin" />
                                <input type="hidden" value="<?php echo($ligne["idSong"])?>" name="songId" />
                            </form>
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
        <input type="hidden" value="0" name="song" />
    </section>
    <script type="text/javascript" src="../javascript/modify_song.js"></script>