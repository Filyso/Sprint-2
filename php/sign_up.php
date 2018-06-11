<?php
$erreur = "";
session_start();

if(isset($_POST["pseudoSignUp"]) && isset($_POST["lastname"]) && isset($_POST["name"]) && isset($_POST["emailSignUp"]) && isset($_POST["passSignUp"]) && isset($_POST["passverif"]) && isset($_FILES["icon"])){

    require("./param.inc.php");
    $pdo = new PDO("mysql:host=".MYHOST.";dbname=".MYDB, MYUSER, MYPASS);
    $pdo->query("SET NAMES utf8");
    $pdo->query("SET CHARACTER SET 'utf8'");

    $requeteSQL = "SELECT pseudoMbr, mailMbr FROM MEMBRES WHERE UPPER(pseudoMbr)= UPPER(:pseudo) OR mailMbr= :emailSignUp";
    $statement = $pdo->prepare($requeteSQL);
    $statement->execute(array(":pseudo" => $_POST["pseudoSignUp"], ":emailSignUp" => $_POST["emailSignUp"]));
    
    $ligne = $statement->fetch(PDO::FETCH_ASSOC);
    
    
    
    
    // le pseudo ou le mail ne doit pas être déjà utilisé, l'image doit être en jpeg ou png, la taille de l'image ne doit pas dépassé 3Mo, 
    $extensions_valides = array('jpg', 'jpeg','png');
    
    $extension_upload = strtolower(substr(strrchr($_FILES['icon']['name'],'.'),1));


    
    

    $password = $_POST["passSignUp"];
    
    if(strlen($password)>=8){
        
        if(preg_match('#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])#', $password)){
            $mdpConforme = true;
        }else{
            $mdpConforme = false;
        }
           
    }else{
        $mdpConforme = false;
    }
           
    $pseudo = $_POST["pseudoSignUp"];
           
    if(strlen($pseudo) >= 4){
        $pseudoConforme = true;
    }else{
        $pseudoConforme = false;
    }
    
    
    
    
    
    if(!empty($ligne["pseudoMbr"]) || !empty($ligne["mailMbr"]) || !(in_array($extension_upload,$extensions_valides)) || $_FILES["icon"]["name"] == ".htacces" || $_FILES["icon"]["size"] > 3000000 || !$mdpConforme || !$pseudoConforme || !($password == $_POST["passverif"])){
        
        //inscription invalide
        
        if(!$mdpConforme){
            $erreur = $erreur."Le mot de passe doit contenir une majuscule, une miniscule, un chiffre et au moins 8 caractères"."<br/>";
        }
        if(!$pseudoConforme){
            $erreur = $erreur."Le pseudo doit contenir au moins 4 caractères"."<br/>";
        }
        if(!empty($ligne["pseudoMbr"])){
            $erreur = $erreur."Pseudo déjà utilisé"."<br/>";
        }
        if(!empty($ligne["mailMbr"])){
            $erreur = $erreur."Mail déjà utilisé"."<br/>";
        }
        if(!(in_array($extension_upload,$extensions_valides))){
            $erreur = $erreur."Le fichier doit être un fichier PNG,JPG ou JPEG"."<br/>";
        }
        if($_FILES["icon"]["size"] > 3000000){
            $erreur = $erreur."Le fichier est trop volumineux"."<br/>";
        }
        if($_FILES["icon"]["name"] == ".htacces"){
            $erreur = $erreur."Pas de fichier .htaccess (on tiens au bon fonctionnement du site)"."<br/>";
        }
        if($password != $_POST["passverif"]){
            $erreur = $erreur."La vérification mot de passe n'est pas valide"."<br/>";
        }
        echo($erreur);
        
        $pdo = null;
        
        
    }else{
        $erreur = "Inscription réussie";
        
        $passSha1 = sha1("cle".$_POST["passSignUp"]."hya");
        //inscription valide
        $requeteSQL = "INSERT INTO `membres` (`pseudoMbr`, `nameMbr`, `prenomMbr`, `mailMbr`, `mdpMbr`,  `isVerif`) VALUES (:pseudoSignUp, :lastname, :name, :emailSignUp, :passSignUp,'0')";
        $statement = $pdo->prepare($requeteSQL);
        $statement->execute(array(":pseudoSignUp" => $_POST["pseudoSignUp"], 
                                  ":lastname" => $_POST["lastname"],
                                 ":name" => $_POST["name"],
                                 ":emailSignUp" => $_POST["emailSignUp"],
                                 ":passSignUp" => $passSha1));
        
        
        $requeteSQL = "SELECT LAST_INSERT_ID() AS idMbr";
        $statement = $pdo->query($requeteSQL);
        $ligne = $statement->fetch(PDO::FETCH_ASSOC);
        
        
        move_uploaded_file($_FILES["icon"]["tmp_name"],"../images/icons/"."img_avatar_".$ligne["idMbr"].".".$extension_upload);
        
        $requeteSQL = "UPDATE `membres` SET `linkIconMbr` = '../images/icons/img_avatar_".$ligne["idMbr"].$extension_upload."' WHERE idMbr='".$ligne["idMbr"]."'";
        $statement = $pdo->query($requeteSQL);
        
        $pdo = null;
        
        //header("Location : PAGESPECIALE");
    }


    
    
    
    
}

?>


<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="description" content="Inscrivez-vous."/>
    <title>Inscrivez-vous</title>
    <link rel="stylesheet" type="text/css" href="../style.css" />
</head>

<body>
    <?php include("./main_header.php"); ?>

    <main class="signUpPage">
        <h1>Sélectionnez la langue et la catégorie</h1>
        <form action="./sign_up.php" method="post"  style="margin-top:200px"  enctype="multipart/form-data">
            <?php 
            if($erreur != ""){ 
                echo($erreur);
            } 
            ?>
            <fieldset>
                <div>
                    <label for="pseudoSignUp">Pseudo</label>
                    <input name="pseudoSignUp" type="text" id="pseudoSignUp" required="required"></input>
                
                    <label for="lastname">Nom</label>
                    <input name="lastname" type="text" id="lastname" required="required"></input>
            
                    <label for="name">Prénom</label>
                    <input name="name" type="text" id="name" required="required"></input>
        
                    <label for="emailSignUp">Mail</label>
                    <input name="emailSignUp" type="emailSignUp" id="emailSignUp" required="required"></input>
    
                    <label for="passSignUp">Mot de passe</label>
                    <input name="passSignUp" type="password" id="passSignUp" required="required"></input>
    
                    <label for="passverif">Vérification du mot de passe</label>
                    <input name="passverif" type="password" id="passverif" required="required"></input>

                    <input type="hidden" name="MAX_FILE_SIZE" value="3000000" />

                    <label for="icon">Icône de joueur (JPG ou PNG | max. 3Mo)</label>
                    <input name="icon" type="file" id="icon" required="required" />   
                </div>
            </fieldset>
            <button type="submit">Terminer</button>
        </form>
    </main>
    <?php include("./main_footer.php"); ?>
</body>

</html>
