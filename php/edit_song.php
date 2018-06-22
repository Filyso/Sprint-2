<?php
    if(isset($_POST["song"])) {
        try {
            require("./param.inc.php");
            $pdo = new PDO("mysql:host=".MYHOST.";dbname=".MYDB, MYUSER, MYPASS);
            $pdo->query("SET NAMES utf8");
            $pdo->query("SET CHARACTER SET 'utf8'");
            
            //SUPPRIMER L'ANCIENNE VERSION DE LA CHANSON
            $requeteSQL = "DELETE FROM CHANSONS WHERE CHANSONS.idSong = :paramIdSong";
            $statement = $pdo->prepare($requeteSQL);
            $statement->execute(array(":paramIdSong" => $_POST["songId"]));

            // AJOUT DE LA CHANSON (AVEC MODIFICATIONS)
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
                        
            $pdo = null;
        
            $msg = "La chanson " . $_POST["song"] . " a bien été ajoutée à la base de donnée.";
            
        } catch (Exception $e) {
            $msg = "Erreur de connexion à la base de donnée";
        }
        
        echo '<script type="text/javascript">alert("' . $msg . '")</script>';
        header("Location: admin.php?admin=Modification%2FSuppression+de+chansons");
    }

    if(isset($_POST["songId"])){
        try {
        
                require("./param.inc.php");
                $pdo = new PDO("mysql:host=".MYHOST.";dbname=".MYDB, MYUSER, MYPASS);
                $pdo->query("SET NAMES utf8");
                $pdo->query("SET CHARACTER SET 'utf8'");
            
                $requeteSQL2="SELECT CHANSONS.nameSong AS 'titre', ARTISTES.nameArtist AS 'interprete', CHANSONS.linkVideo AS 'lien', CATEGORIES.nameCat AS 'categorie', CHANSONS.lang AS 'langue' ".
                        "FROM CHANSONS ".
                        "INNER JOIN A_UN ".
                        "ON A_UN.idSong = CHANSONS.idSong ".
                        "INNER JOIN ARTISTES ".
                        "ON ARTISTES.idArtist = A_UN.idArtist ".
                        "INNER JOIN APPARTIENT_A_UNE ".
                        "ON APPARTIENT_A_UNE.idSong = CHANSONS.idSong ".
                        "INNER JOIN CATEGORIES ".
                        "ON CATEGORIES.idCat = APPARTIENT_A_UNE.idCat ".
                        "WHERE CHANSONS.idSong = ". $_POST["songId"];

                $statement2 = $pdo->query($requeteSQL2);

                $ligne2 = $statement2->fetch(PDO::FETCH_ASSOC);

      
?>
    <script type="text/javascript" src="../javascript/add_Song.js"></script>
    <section class="addSongSection">

        <h3>MODIFIER UNE CHANSON</h3>

        <form action="edit_song.php" method="post" id="addSongForm" class="addSongForm">
            <fieldset class="chansonForm">
                <legend>Chanson</legend>
                <div>
                    <label for="song">Nom de la chanson</label>
                    <input type="text" name="song" id="song" required="required" maxlength="75" value="<?php echo($ligne2["titre"]) ?>"/>
                </div>

                <div>
                    <label for="artistSong">Nom de l'interprète</label>
                    <input type="text" name="artistSong" id="artistSong" required="required" maxlength="50" value="<?php echo($ligne2["interprete"]) ?>" />
                </div>

                <div class="catSong">
                    <?php
                        while($ligne2 != false){
                    ?>
                    <label for="catSong">Catégorie</label>
                    <select id="catSong_1" size="1" name="catSong_1" required>

                        <option value="" disabled>Choisissez une catégorie</option>
                        <?php
                        try {

                            require("./param.inc.php");
                            $pdo = new PDO("mysql:host=".MYHOST.";dbname=".MYDB, MYUSER, MYPASS);
                            $pdo->query("SET NAMES utf8");
                            $pdo->query("SET CHARACTER SET 'utf8'");

                            $requeteSQL = "SELECT idCat, nameCat FROM CATEGORIES";
                            $statement = $pdo->query($requeteSQL);

                            $ligne = $statement->fetch(PDO::FETCH_ASSOC);
                            while($ligne != false) {
                    ?>
                            <option value="<?php echo($ligne["idCat"]);?>" <?php echo($ligne2["categorie"]==$ligne["nameCat"]?"selected":"") ?>>
                                <?php echo(ucfirst($ligne["nameCat"]));?>
                            </option>
                            <?php
                                $ligne = $statement->fetch(PDO::FETCH_ASSOC);
                            }
                            $pdo = null;
                        } catch (Exception $e) {
                            echo($e);
                        }
                    ?>

                    </select>
                </div>
                <input id="nbCat" type="hidden" name="nbCat" value="1" class="inputMasque" />
                <input type="button" id="addCatBtn" value="AJOUTER UNE CATEGORIE" />

                <div class="adminLangues">
                    <span>Langue</span>
                    <div class="choixLangue">
                        <input type="radio" id="langSongFR" name="langSong" value="fr" required <?php echo($ligne2["langue"]=='fr'?"checked":"") ?>>
                        <label for="langSongFR"><img src="../images/fr.png" alt="drapeau FR" /></label>

                        <input type="radio" id="langSongEN" name="langSong" value="en" <?php echo($ligne2["langue"]=='en'?"checked":"") ?>>
                        <label for="langSongEN"><img src="../images/uk.png" alt="drapeau UK" /></label>
                    </div>
                </div>

                <div>
                    <label for="linkVideo">URL</label>
                    <input type="url" name="linkVideo" id="linkVideo" required="required" pattern="^https://www.youtube.com/watch?.+" placeholder="https://www.youtube.com/watch?..." value="<?php echo($ligne2["lien"]) ?>"/>
                </div>
                <?php
                            $ligne2 = $statement2->fetch(PDO::FETCH_ASSOC);
                        }
                    } catch (Exception $e) {
                            $msg = "Erreur de connexion à la base de donnée";
                        }
                    }else{
                        header('Location: ./admin.php?admin=Modification%2FSuppression+de+chansons');
                    }        

                if(isset($_POST["songId"])){
                        try {
                        require("./param.inc.php");
                        $pdo = new PDO("mysql:host=".MYHOST.";dbname=".MYDB, MYUSER, MYPASS);
                        $pdo->query("SET NAMES utf8");
                        $pdo->query("SET CHARACTER SET 'utf8'");
                            
                        $requeteSQL3 = "SELECT TIMECODES.timeCode AS 'fin', TIMECODES.startTimeCode AS 'debut', TIMECODES.trueRep, TIMECODES.falseRep1, TIMECODES.falseRep2, TIMECODES.falseRep3, TIMECODES.previousLyrics ".  
                                    "FROM TIMECODES ".
                                    "INNER JOIN CHANSONS ".
                                    "ON CHANSONS.idSong = TIMECODES.idSong ".
                                    "WHERE CHANSONS.idSong = '".$_POST["songId"]."'";
                            
                        $statement3 = $pdo->query($requeteSQL3);
                        $ligne3 = $statement3->fetch(PDO::FETCH_ASSOC);

                        $nbLigne3=0;
                            
                        while($ligne3 != false){
                            $nbLigne3 += 1; 
                            $ligne3 = $statement3->fetch(PDO::FETCH_ASSOC);
                            }
                ?>
                
                <input id="nbTimecode" type="hidden" name="nbTimecode" value="<?php echo($nbLigne3) ?>" class="inputMasque" />

            </fieldset>
                
                <?php
                        $statement3 = $pdo->query($requeteSQL3);
                        $ligne3 = $statement3->fetch(PDO::FETCH_ASSOC);
                            
                        $iterationCount = 0;
                            
                        while($ligne3 != false){
                            
                            $debut = explode(":", $ligne3["debut"]);
                            $fin = explode(":", $ligne3["fin"]);
                            
                            $iterationCount += 1;

                ?>
                
            <fieldset class="timeCode">
                
                <legend>Timecode</legend>

                <div>
                    <span>De</span>
                    <input id="minStart_<?php echo($iterationCount) ?>" type="number" name="minStart_<?php echo($iterationCount) ?>" required="required" min="0" max="10" value="<?php echo($debut[1]) ?>">
                    <label for="minStart_<?php echo($iterationCount) ?>">min</label>

                    <input id="secStart_<?php echo($iterationCount) ?>" type="number" name="secStart_<?php echo($iterationCount) ?>" required="required" min="00" max="59" value="<?php echo($debut[2]) ?>">
                    <label for="secStart_<?php echo($iterationCount) ?>">s</label>
                </div>

                <div>
                    <span>À</span>
                    <input id="minEnd_<?php echo($iterationCount) ?>" type="number" name="minEnd_<?php echo($iterationCount) ?>" required="required" min="0" max="10" value="<?php echo($fin[1]) ?>">
                    <label for="minEnd_<?php echo($iterationCount) ?>">min</label>

                    <input id="secEnd_<?php echo($iterationCount) ?>" type="number" name="secEnd_<?php echo($iterationCount) ?>" required="required" min="00" max="59" value="<?php echo($fin[2]) ?>">
                    <label for="secEnd_<?php echo($iterationCount) ?>">s</label>
                    <div>
                        <label for="prevLyrics_<?php echo($iterationCount) ?>">Paroles précédentes</label>
                        <input id="prevLyrics_<?php echo($iterationCount) ?>" type="text" name="prevLyrics_<?php echo($iterationCount) ?>" required="required" maxlength="200" value="<?php echo(stripslashes($ligne3["previousLyrics"])) ?>">
                    </div>

                    <div>
                        <label for="goodRep_<?php echo($iterationCount) ?>">Bonne réponse</label>
                        <input id="goodRep_<?php echo($iterationCount) ?>" type="text" name="goodRep_<?php echo($iterationCount) ?>" required="required" maxlength="200" value="<?php echo(stripslashes($ligne3["trueRep"])) ?>">
                    </div>
                </div>



                <fieldset class="reponsesForm">
                    <legend>Réponses</legend>

                    <div>
                        <label for="badRep1_<?php echo($iterationCount) ?>">Mauvaise réponse 1</label>
                        <input id="badRep1_<?php echo($iterationCount) ?>" type="text" name="badRep1_<?php echo($iterationCount) ?>" required="required" maxlength="200" value="<?php echo(stripslashes($ligne3["falseRep1"])) ?>">
                    </div>

                    <div>
                        <label for="badRep2_<?php echo($iterationCount) ?>">Mauvaise réponse 2</label>
                        <input id="badRep2_<?php echo($iterationCount) ?>" type="text" name="badRep2_<?php echo($iterationCount) ?>" required="required" maxlength="200" value="<?php echo(stripslashes($ligne3["falseRep2"])) ?>">
                    </div>

                    <div>
                        <label for="badRep3_<?php echo($iterationCount) ?>">Mauvaise réponse 3</label>
                        <input id="badRep3_<?php echo($iterationCount) ?>" type="text" name="badRep3_<?php echo($iterationCount) ?>" required="required" maxlength="200" value="<?php echo(stripslashes($ligne3["falseRep3"])) ?>">
                    </div>
                    
                </fieldset>
            </fieldset>    
                    
                <?php 
                     $ligne3 = $statement3->fetch(PDO::FETCH_ASSOC);
                     }
                    
                     $pdo = null;
                        } catch (Exception $e) {
                            $msg = "Erreur de connexion à la base de donnée";
                        }
                }else{
                    header('Location: ./admin.php?admin=Modification%2FSuppression+de+chansons');
                }

                ?>
            <div>
                <input id="songId" type="hidden" name="songId" value="<?php echo($_POST["songId"]) ?>"/>
                <input type="button" id="addTCBtn" value="AJOUTER UN TIMECODE" />
                <input type="submit" value="APPLIQUER LES MODIFICATIONS" />
            </div>

        </form>

    </section>