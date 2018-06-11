<?php

session_start();

if(isset($_POST["pseudoSignUp"]) && isset($_POST["lastname"]) && isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["passSignUp"]) && isset($_POST["passverif"]) && ($_POST["passSignUp"] == $_POST["passverif"]) && isset($_FILES["icon"])){
    
    echo($_FILES["icon"]["name"]."<br/>");
    echo($_FILES["icon"]["size"]."<br/>");
    echo($_FILES["icon"]["type"]."<br/>");

    require("./param.inc.php");
    $pdo = new PDO("mysql:host=".MYHOST.";dbname=".MYDB, MYUSER, MYPASS);
    $pdo->query("SET NAMES utf8");
    $pdo->query("SET CHARACTER SET 'utf8'");

    $requeteSQL = "SELECT pseudoMbr, mailMbr FROM MEMBRES WHERE UPPER(pseudoMbr)= UPPER(:pseudo) OR mailMbr= :email";
    $statement = $pdo->prepare($requeteSQL);
    $statement->execute(array(":pseudo" => $_POST["pseudoSignUp"], ":email" => $_POST["email"]));
    
    $ligne = $statement->fetch(PDO::FETCH_ASSOC);
    
    echo($ligne["pseudoMbr"]."  ".$ligne["mailMbr"]."<br/>");
    echo($_POST["pseudoSignUp"]."  ".$_POST["email"]."<br/>");
    
    
    // le pseudo ou le mail ne doit pas être déjà utilisé, l'image doit être en jpeg ou png, la taille de l'image ne doit pas dépassé 3Mo, 
    $extensions_valides = array('jpg', 'jpeg','png');
    
    $extension_upload = strtolower(substr(strrchr($_FILES['icon']['name'],'.'),1));

    echo($extension_upload."<br/>");
    
    if(!empty($ligne["pseudoMbr"]) || !empty($ligne["mailMbr"]) || !(in_array($extension_upload,$extensions_valides)) || $_FILES["icon"]["name"] == ".htacces" || $_FILES["icon"]["size"] > 3000000){
        //inscription invalide
        echo("Pseudo ou mail invalide");
    }else{
        //inscription valide
        $requeteSQL = "INSERT INTO `membres` (`pseudoMbr`, `nameMbr`, `prenomMbr`, `mailMbr`, `mdpMbr`,  `isVerif`) VALUES (:pseudoSignUp, :lastname, :name, :email, :passSignUp,'0')";
        $statement = $pdo->prepare($requeteSQL);
        $statement->execute(array(":pseudoSignUp" => $_POST["pseudoSignUp"], 
                                  ":lastname" => $_POST["lastname"],
                                 ":name" => $_POST["name"],
                                 ":email" => $_POST["email"],
                                 ":passSignUp" => $_POST["passSignUp"]));
        
        
        $requeteSQL = "SELECT idMbr FROM membres WHERE mailMbr= ".$_POST["email"]." AND pseudoMbr= ".$_POST["pseudoSignUp"];
        $statement = $pdo->query($requeteSQL);
        $ligne = $statement->fetch(PDO::FETCH_ASSOC);
        
        copy($_FILES["icon"]["tmp_name"],"../images/icons/img_avatar_".$ligne["idMbr"].$extension_upload);
        
        $requeteSQL = "INSERT INTO `membres` (`linkIconMbr`) VALUES ('../icons/img_avatar_".$ligne["idMbr"].$extension_upload."') WHERE mail= ".$_POST["email"]." AND pseudoMbr= ".$_POST["pseudoSignUp"];
        $statement = $pdo->query($requeteSQL);
        
        echo("Inscription réussie");
    }


    $pdo = null;
    
    
    
}else{
    echo("bidule");
}

?>


<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="description" content="Inscrivez-vous."/>
    <title>Inscrivez-vous</title>
    <link rel="stylesheet" type="text/css" href="../style.css" />
    <script type="text/javascript" src="../javascript/selectAlea.js"></script>
</head>

<body>
    <?php include("./main_header.php"); ?>

    <main class="signUpPage">
        <h1>Sélectionnez la langue et la catégorie</h1>
        <form action="./sign_up.php" method="post"  style="margin-top:200px"  enctype="multipart/form-data">
            <fieldset>
                <div>
                    <label for="pseudoSignUp">Pseudo</label>
                    <input name="pseudoSignUp" type="text" id="pseudoSignUp" required="required"></input>
                
                    <label for="lastname">Nom</label>
                    <input name="lastname" type="text" id="lastname" required="required"></input>
            
                    <label for="name">Prénom</label>
                    <input name="name" type="text" id="name" required="required"></input>
        
                    <label for="email">Mail</label>
                    <input name="email" type="email" id="email" required="required"></input>
    
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
