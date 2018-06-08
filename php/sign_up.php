<?php

session_start();

if(isset($_POST["pseudoSignUp"]) && isset($_POST["lastname"]) && isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["passSignUp"]) && isset($_POST["passverif"]) && ($_POST["passSignUp"] == $_POST["passverif"])){
    
    
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
    
    // le pseudo ou le mail ne doit pas être déjà utilisé
    if(!empty($ligne["pseudoMbr"]) || !empty($ligne["mailMbr"])){
        //inscription invalide
        echo("Pseudo ou mail invalide");
    }else{
        //inscription valide
        $requeteSQL = "INSERT INTO `MEMBRES` (`pseudoMbr`, `nameMbr`, `prenomMbr`, `mailMbr`, `mdpMbr`,  `isVerif`) VALUES ('1', '-èu', '-èu', '-èu', '-èu', '-èu', '-èu', '0')
";
    }


    $pdo = null;
    
    
    
}else{
    echo("C PA BN"); 
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
        <form action="./sign_up.php" method="post"  style="margin-top:200px">
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


                    <!-- <label for="iconPath">Choississez une icône de joueur !</label>
                    <input name="iconPath" type="file" id="iconPath" required="required"></input> -->                 
                </div>
            </fieldset>
            <button type="submit">Terminer</button>
        </form>
    </main>
    <?php include("./main_footer.php"); ?>
</body>

</html>
