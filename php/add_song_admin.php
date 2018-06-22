<?php

    if(isset($_POST["song"])) {
        try {
        // ETAPE 1 : Se connecter au serveur de base de données
            require("./param.inc.php");
            $pdo = new PDO("mysql:host=".MYHOST.";dbname=".MYDB, MYUSER, MYPASS);
            $pdo->query("SET NAMES utf8");
            $pdo->query("SET CHARACTER SET 'utf8'");

        // ETAPE 2 : Envoyer une requête SQL
            // AJOUT CHANSON
            $requeteSQL = "INSERT INTO CHANSONS(nameSong, linkVideo, lang, idMbr) VALUES (:paramNameSong, :paramLinkVideo, :paramLangSong, NULL)";
            $statement = $pdo->prepare($requeteSQL);
            $statement->execute(array(":paramNameSong" => $_POST["song"],
                                      ":paramLinkVideo" => $_POST["linkVideo"],
                                      ":paramLangSong" => $_POST["langSong"]));
        
            // Récupération idSong
            $requeteSQL = "SELECT LAST_INSERT_ID() AS idSong";
            $statement = $pdo->query($requeteSQL);
            $ligne = $statement->fetch(PDO::FETCH_ASSOC);
            $idSong = $ligne["idSong"];
            
            // AJOUT CATEGORIE
            for ($i=1; $i <= $_POST["nbCat"]; $i++) {
                if (isset($_POST["catSong_".$i])) {
                    $requeteSQL = "INSERT INTO APPARTIENT_A_UNE(idSong, idCat) VALUES (" . $idSong . ", :paramCatSong)";
                    $statement = $pdo->prepare($requeteSQL);
                    $statement->execute(array(":paramCatSong" => $_POST["catSong_".$i]));
                }
            }
        
            // AJOUT TIMECODE
            for ($i=1; $i <= $_POST["nbTimecode"]; $i++) {
                if(isset($_POST["prevLyrics_".$i])) {
                    $startTimeCode = "00:" . ($_POST["minStart_".$i]>9 ? ($_POST["minStart_".$i]):("0" . $_POST["minStart_".$i])) . ":" . ($_POST["secStart_".$i]>9 ? ($_POST["secStart_".$i]):("0" . $_POST["secStart_".$i]));

                    $timeCode = "00:" . ($_POST["minEnd_".$i]>9 ? ($_POST["minEnd_".$i]):("0" . $_POST["minEnd_".$i])) . ":" . ($_POST["secEnd_".$i]>9 ? ($_POST["secEnd_".$i]):("0" . $_POST["secEnd_".$i]));

                    $requeteSQL = "INSERT INTO TIMECODES(startTimeCode,timeCode,previousLyrics,trueRep,falseRep1,falseRep2,falseRep3,idSong) VALUES ('" . $startTimeCode . "','" . $timeCode . "', :paramPrevLyrics, :paramGoodRep, :paramBadRep1, :paramBadRep2, :paramBadRep3," . $idSong . ")";
                    $statement = $pdo->prepare($requeteSQL);
                    $statement->execute(array(":paramPrevLyrics" => addslashes($_POST["prevLyrics_".$i]),
                                              ":paramGoodRep" => addslashes($_POST["goodRep_".$i]),
                                              ":paramBadRep1" => addslashes($_POST["badRep1_".$i]),
                                              ":paramBadRep2" => addslashes($_POST["badRep2_".$i]),
                                              ":paramBadRep3" => addslashes($_POST["badRep3_".$i])));
                }
            }
        
            // GESTION AUTEUR
            $requeteSQL = "SELECT idArtist, nameArtist FROM ARTISTES WHERE nameArtist='" . $_POST["artistSong"] . "'";
            $statement = $pdo->query($requeteSQL);
            $ligne = $statement->fetch(PDO::FETCH_ASSOC);
            if($ligne != false) {
                $requeteSQL = "INSERT INTO A_UN(idSong, idArtist) VALUES (" . $idSong . ", " . $ligne["idArtist"] . ")";
                $statement = $pdo->query($requeteSQL);
            } else {
                $requeteSQL = "INSERT INTO ARTISTES(nameArtist) VALUES (:paramArtistSong)";
                $statement = $pdo->prepare($requeteSQL);
                $statement->execute(array(":paramArtistSong" => $_POST["artistSong"]));
                
                $requeteSQL = "INSERT INTO A_UN(idSong, idArtist) VALUES (" . $idSong . ", LAST_INSERT_ID())";
                $statement = $pdo->query($requeteSQL);
            }
                        
        // ETAPE 3 : Déconnecter du serveur
            $pdo = null;
            
        // SETUP message retourner à l'utilisateur
            $msg = "La chanson " . $_POST["song"] . " a bien été ajoutée à la base de donnée.";
            
        } catch (Exception $e) {
            $msg = "Erreur de connexion à la base de donnée";
        }
        
        echo '<script >alert("' . $msg . '")</script>';
        header("Location: admin.php");
    }
?>
    <script  src="../javascript/add_Song.js"></script>
    <section class="addSongSection">

        <h3>AJOUTER UNE CHANSON</h3>

        <form action="add_song_admin.php" method="post" id="addSongForm" class="addSongForm">
            <fieldset class="chansonForm">
                <legend>Chanson</legend>
                <div>
                    <label for="song">Nom de la chanson</label>
                    <input type="text" name="song" id="song" required="required" maxlength="75" />
                </div>

                <div>
                    <label for="artistSong">Nom de l'interprète</label>
                    <input type="text" name="artistSong" id="artistSong" required="required" maxlength="50" />
                </div>

                <div class="catSong">

                    <label for="catSong_1">Catégorie</label>
                    <select id="catSong_1" size="1" name="catSong_1" required>
                        
                    <option value="" disabled selected>Choisissez une catégorie</option>
                    <?php
                        try {
                        // ETAPE 1 : Se connecter au serveur de base de données
                            require("./param.inc.php");
                            $pdo = new PDO("mysql:host=".MYHOST.";dbname=".MYDB, MYUSER, MYPASS);
                            $pdo->query("SET NAMES utf8");
                            $pdo->query("SET CHARACTER SET 'utf8'");

                        // ETAPE 2 : Envoyer une requête SQL (demander la liste des données)
                            $requeteSQL = "SELECT idCat, nameCat FROM CATEGORIES";
                            $statement = $pdo->query($requeteSQL);

                        // ETAPE 3 : Traiter les données retourner
                            $ligne = $statement->fetch(PDO::FETCH_ASSOC);
                            while($ligne != false) {
                    ?>
                    <option value="<?php echo($ligne["idCat"]);?>"><?php echo(ucfirst($ligne["nameCat"]));?></option>
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
                    </select>

                </div>
                <input id="nbCat" type="hidden" name="nbCat" value="1" class="inputMasque" />
                <input type="button" id="addCatBtn" value="AJOUTER UNE CATEGORIE"/>

                <div class="adminLangues">
                    <span>Langue</span>
                    <div class="choixLangue">
                    <input type="radio" id="langSongFR" name="langSong" value="fr" required>
                    <label for="langSongFR"><img src="../images/fr.png" alt="drapeau FR"/></label>

                    <input type="radio" id="langSongEN" name="langSong" value="en">
                    <label for="langSongEN"><img src="../images/uk.png" alt="drapeau UK"/></label>
                        </div>
                </div>

                <div>
                    <label for="linkVideo">URL</label>
                    <input type="url" name="linkVideo" id="linkVideo" required="required" pattern="^https://www.youtube.com/watch?.+" placeholder="https://www.youtube.com/watch?..." />
                </div>

                <input id="nbTimecode" type="hidden" name="nbTimecode" value="1" class="inputMasque" />

            </fieldset>
            <fieldset class="timeCode">
                <legend>Timecode</legend>

                <div>
                    <span>De</span>
                    <input id="minStart_1" type="number" name="minStart_1" required="required" min="0" max="10">
                    <label for="minStart_1">min</label>

                    <input id="secStart_1" type="number" name="secStart_1" required="required" min="00" max="59">
                    <label for="secStart_1">s</label>
                </div>

                <div>
                    <span>À</span>
                    <input id="minEnd_1" type="number" name="minEnd_1" required="required" min="0" max="10">
                    <label for="minEnd_1">min</label>

                    <input id="secEnd_1" type="number" name="secEnd_1" required="required" min="00" max="59">
                    <label for="secEnd_1">s</label>
                    <div>
                        <label for="prevLyrics_1">Paroles précédentes</label>
                        <input id="prevLyrics_1" type="text" name="prevLyrics_1" required="required" maxlength="200">
                    </div>

                    <div>
                        <label for="goodRep_1">Bonne réponse</label>
                        <input id="goodRep_1" type="text" name="goodRep_1" required="required" maxlength="200">
                    </div>
                </div>



                <fieldset class="reponsesForm">
                    <legend>Réponses</legend>

                    <div>
                        <label for="badRep1_1">Mauvaise réponse 1</label>
                        <input id="badRep1_1" type="text" name="badRep1_1" required="required" maxlength="200">
                    </div>

                    <div>
                        <label for="badRep2_1">Mauvaise réponse 2</label>
                        <input id="badRep2_1" type="text" name="badRep2_1" required="required" maxlength="200">
                    </div>

                    <div>
                        <label for="badRep3_1">Mauvaise réponse 3</label>
                        <input id="badRep3_1" type="text" name="badRep3_1" required="required" maxlength="200">
                    </div>

                </fieldset>
            </fieldset>


            <div>
                <input type="button" id="addTCBtn" value="AJOUTER UN TIMECODE" />
                <input type="submit" value="AJOUTER LA CHANSON" />
            </div>

        </form>

    </section>