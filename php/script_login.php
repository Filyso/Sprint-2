<?php

require("./param.inc.php");
$pdo = new PDO("mysql:host=".MYHOST.";dbname=".MYDB, MYUSER, MYPASS);
$pdo->query("SET NAMES utf8");
$pdo->query("SET CHARACTER SET 'utf8'");
        
$passSha1Verif = sha1("cle".$_POST["pass"]."hya");
$requeteSQL = "SELECT idMbr, pseudoMbr, mdpMbr, linkIconMbr, isVerif FROM MEMBRES WHERE pseudoMbr= :pseudo AND mdpMbr= :pass";
$statement = $pdo->prepare($requeteSQL);
$statement->execute(array(":pseudo" => $_POST["pseudo"], ":pass" => $passSha1Verif));

$ligne = $statement->fetch(PDO::FETCH_ASSOC);

$pseudo= $ligne["pseudoMbr"];
$passwd= $ligne["mdpMbr"];



if(isset($_POST["pseudo"]) && isset($_POST["pass"])){
    
    if($_POST["pseudo"] == $pseudo && $passSha1Verif == $passwd && $ligne["isVerif"] == 1){
        echo("Connexion");
        
    }else if($_POST["pseudo"] == $pseudo && $passSha1Verif == $passwd && $ligne["isVerif"] == 0){
        echo("nonVerif");
    }else{
        echo("Echec");
    }
    
}



?>