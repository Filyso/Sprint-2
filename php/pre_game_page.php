<?php
    session_start();
?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Choix des options de jeu</title>
    <meta name="description" content="Choisissez vos options de jeu et lancez votre partie ! Sur cette page vous pouvez choisir la catégorie de chanson sur laquelle vous voulez être testé.">
    <link rel="stylesheet" type="text/css" href="../css/new_style.css" />
    <link rel="shortcut icon" href="../images/favicon.png" />
</head>
<body>
    <?php include("./main_header.php"); ?>

    <main class="preGamePage">
        <h1>Sélectionnez la langue et la catégorie</h1>
        <form action="<?php echo(isset($_GET['mod']) && $_GET['mod'] == "multi" ? "./matchmaking.php" : "./solo_game.php")?>" method="<?php echo(isset($_GET['mod']) && $_GET['mod'] == "multi" ? "post" : "get")?>">
            <input type="hidden" name="autorisation" value="true"/>
            <fieldset class="section">
                <div>
                    <input type="radio" name="langue" id="français" value="fr" class="inputRadio" required />
                    <label for="français"><img src="../images/fr.png" alt="drapeau français"></label>
                </div>

                <div>

                    <input type="radio" name="langue" id="anglais" value="en" class="inputRadio" />
                    <label for="anglais"><img src="../images/uk.png" alt="drapeau anglais"></label>
                </div>

                <div>

                    <input type="radio" name="langue" id="bilingue" value="bilingue" class="inputRadio" checked/>
                    <label for="bilingue"><img src="../images/fr_uk.png" alt="drapeau bilingue"></label>
                </div>
            </fieldset>

            <fieldset>
                <div>
                    <label for="categorie">Catégorie</label>
                    <select id="categorie" name="categorie">
                        <option value="0">Toutes les catégories</option>
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
                                    $newRequeteSQL = "SELECT COUNT(idSong) AS 'nbSong' FROM APPARTIENT_A_UNE WHERE idCat =" . $ligne["idCat"];
                                    $newStatement = $pdo->query($newRequeteSQL);
                                    $newLigne = $newStatement->fetch(PDO::FETCH_ASSOC);
                                    
                                    if ($newLigne["nbSong"] >= 7) {
                        ?>
                        <option value="<?php echo($ligne["idCat"]);?>"><?php echo(ucfirst($ligne["nameCat"]));?></option>
                        <?php
                                    }
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

                <div>
                    <button id="btnAlea" type="button">Aléatoire</button>
                </div>
            </fieldset>
            <button type="submit">JOUER</button>
        </form>
    </main>
    <script  src="../javascript/selectAlea.js"></script>
    <?php include("./main_footer.php"); ?>
    
</body>

</html>
