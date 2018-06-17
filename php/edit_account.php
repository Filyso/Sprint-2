<?php
$erreur = "";
session_start();



if(isset($_SESSION["id"]) && isset($_SESSION["pseudo"])){
    
    
    
    
    require("./param.inc.php");
    $pdo = new PDO("mysql:host=".MYHOST.";dbname=".MYDB, MYUSER, MYPASS);
    $pdo->query("SET NAMES utf8");
    $pdo->query("SET CHARACTER SET 'utf8'");

    $requeteSQL = "SELECT pseudoMbr, nameMbr, prenomMbr, mailMbr, mdpMbr, linkIconMbr FROM MEMBRES WHERE idMbr='".$_SESSION["id"]."'";
    $statement = $pdo->query($requeteSQL);
    
    $ligne = $statement->fetch(PDO::FETCH_ASSOC);
    
    
    
    
}else{
    header("Location: index.php");
}






?>


<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="description" content="Editez votre compte."/>
    <title>Editez votre compte</title>
    <link rel="stylesheet" type="text/css" href="../css/new_style.css" />
    
</head>

<body>
    <?php include("./main_header.php"); ?>
    <main class="signUpPage">
        <form id="editFormPerso" method="post">
            <h1>Edition compte</h1>
            <h2>Informations personnelles</h2>
            <fieldset>
                <div>
                    <label for="pseudoEdit" ></label>
                    <input placeholder="Pseudo" name="pseudoEdit" type="text" id="pseudoEdit" required="required" size="16" minlength="4" maxlength="16" title="Le pseudo doit être compris entre 4 et 16 caractères" pattern="^([0-9a-zA-Z]{4,16})$" value="<?php echo($ligne["pseudoMbr"]); ?>"/>
                
                    <label for="lastnameEdit"></label>
                    <input placeholder="Nom" name="lastnameEdit" type="text" id="lastnameEdit" required="required" size="25" minlength="1" maxlength="25" title="Le nom ne doit pas dépasser 25 caractères" pattern="^([a-zA-Z'àâéèêôùûçÀÂÉÈÔÙÛÇ-]{1,25})$" value="<?php echo($ligne["nameMbr"]); ?>"/>
            
                    <label for="nameEdit"></label>
                    <input placeholder="Prénom" name="nameEdit" type="text" id="nameEdit" required="required" size="25" minlength="1" maxlength="25" title="Le prénom ne doit pas dépasser 25 caractères" pattern="^([a-zA-Z'àâéèêôùûçÀÂÉÈÔÙÛÇ-]{1,25})$" value="<?php echo($ligne["prenomMbr"]); ?>"/>
        
                    <label for="emailEdit"></label>
                    <input placeholder="Adresse mail" name="emailEdit" type="email" id="emailEdit" required="required" pattern="^[a-zA-Z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$" disabled value="<?php echo($ligne["mailMbr"]); ?>"/>
                </div>
            </fieldset>
            <button id="editSubmitPerso" type="submit">Editer</button>
        </form>
                
        <form id="editFormPass" method="post">
            <h2>Mot de passe</h2>
            <fieldset>
                <div>          
                    <label for="oldPass"></label>
                    <input placeholder="Ancien mot de passe" name="oldPass" type="password" id="oldPass" required="required" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).{8,42}$"/>
                    
                    <label for="passEdit"></label>
                    <input placeholder="Nouveau mot de passe" name="passEdit" type="password" id="passEdit" required="required" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).{8,42}$"/>
    
                    <label for="passverifEdit"></label>
                    <input placeholder="Confirmer le mot de passe" name="passverifEdit" type="password" id="passverifEdit" required="required" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).{6,}$"/>
                </div>
            </fieldset>
            <button id="editSubmitPass" type="submit">Editer</button>
        </form>
          
        <form id="editFormIcone" method="post" enctype="multipart/form-data">
            <h2>Icône de joueur</h2>
            <fieldset>
                <div>
                    <input type="hidden" name="MAX_FILE_SIZE" value="2000000"/>

                    <label for="iconChoisieEdit" class="labelIcone">Remplacer votre icône par l'image que vous souhaitez (JPG ou PNG | max. 2Mo)</label>
                    <input name="iconChoisieEdit" type="file" id="iconChoisieEdit" />
                    <p class="choisirImageDefinis"> ou choisissez-en une parmi celles-ci :</p>
                <div class="imagesProfil">
<?php
            $dossier = glob("../images/icons/default/*");
            foreach($dossier as $fichier){ 
                $nomfichier = substr($fichier,24);
?>          
            <figure  data-icon="<?php echo($nomfichier); ?>">
                    <img src="<?php echo($fichier); ?>" alt="Icône par défault"/>      
            </figure>  
<?php
            }        
                    
?>
                        </div>
                    <input id="hiddenEdit" type="hidden" name="icon" value=""/>
                </div>
            </fieldset>
            <button id="editSubmitIcone" type="submit">Editer</button>
        </form>
    </main>
    <?php //include("./main_footer.php"); ?>
    
<!--
    <script type="text/javascript" src="../javascript/verification_inscription.js"></script>
    <script type="text/javascript" src="../javascript/verifier_icone_choisie_signup.js"></script>
-->
    <script type="text/javascript" src="../javascript/edit_account.js"></script>
</body>

</html>
