<?php
    header("Content-type: text/html; charset: UTF-8");
    session_start();
    require("./param.inc.php");

    if(!isset($_SESSION["id"]) && !isset($_SESSION["pseudo"])){
        header("Location: index.php");
    }	

    
?>
    <!DOCTYPE html>
    <html lang="fr">

    <head>
       <meta charset="utf-8"/>
        <title>Espace mon compte</title>
        <meta name="description" content="Bienvenue dans votre espace personnel de compte. Ici vous pourrez consulter les données relatives à votre compte et votre activité sur le site Filyso.">
        <link rel="stylesheet" href="../css/new_style.css" />
        <link rel="shortcut icon" href="../images/favicon.png" />
    </head>

    <body>
        <?php include("./main_header.php");?>
        <?php
        
if(isset($_GET["pseudoFriend"])){
    
    $pdo = new PDO("mysql:host=".MYHOST.";dbname=".MYDB, MYUSER, MYPASS);
    $pdo->query("SET NAMES utf8");
    $pdo->query("SET CHARACTER SET 'utf8'");
    
    $requeteSQL = "SELECT idMbr FROM MEMBRES WHERE pseudoMbr= :pseudoFriend";
    $statement = $pdo->prepare($requeteSQL);
    $statement->execute(array(":pseudoFriend" => $_GET["pseudoFriend"]));
    $ligne = $statement->fetch(PDO::FETCH_ASSOC);
    
    if($ligne != false){
        $requeteSQL = "SELECT idMbr_Ami1, idMbr_Ami2 FROM AMIS WHERE (idMbr_Ami1='".$ligne["idMbr"]."' AND idMbr_Ami2='".$_SESSION["id"]."') OR (idMbr_Ami1='".$_SESSION["id"]."' AND idMbr_Ami2='".$ligne["idMbr"]."')";
        $statement = $pdo->query($requeteSQL);
        $ligne = $statement->fetch(PDO::FETCH_ASSOC);
        
        
        if($ligne != false){
            include("./scripts/script_friendaccount.php");
        }else{
            include("./scripts/script_myaccount.php");
        }
    }else{
        include("./scripts/script_myaccount.php");
    }
       
    $pdo = null;
    
}else{
    include("./scripts/script_myaccount.php");
    
}
    
        
        
        ?>
        <?php include("./main_footer.php"); ?>
    </body>
</html>