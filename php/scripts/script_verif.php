<?php

session_start();

if(isset($_GET["id"])){
    
    require("../param.inc.php");
    $pdo = new PDO("mysql:host=".MYHOST.";dbname=".MYDB, MYUSER, MYPASS);
    $pdo->query("SET NAMES utf8");
    $pdo->query("SET CHARACTER SET 'utf8'");
    
    $requeteSQL = "UPDATE `MEMBRES` SET `isVerif` = '1'  WHERE idMbr= :id";
    $statement = $pdo->prepare($requeteSQL);
    $statement->execute(array(":id" => $_GET["id"]));

    
    $requeteSQL = "SELECT idMbr, pseudoMbr, nameMbr, prenomMbr, mailMbr, mdpMbr, linkIconMbr, isVerif FROM MEMBRES WHERE idMbr= :id";
    $statement = $pdo->prepare($requeteSQL);
    $statement->execute(array(":id" => $_GET["id"]));

    $ligne = $statement->fetch(PDO::FETCH_ASSOC);
    


    $_SESSION["id"] = $ligne["idMbr"];
    $_SESSION["pseudo"] = $ligne["pseudoMbr"];
    $_SESSION["icon"] = $ligne["linkIconMbr"];
    $_SESSION["nom"] = $ligne["nameMbr"];
    $_SESSION["prenom"] = $ligne["prenomMbr"];
    $_SESSION["mail"] = $ligne["mailMbr"];

    

    
    header("Location: ../index.php");
    
    
    
}else{
    header("Location: ../index.php");
}







?>