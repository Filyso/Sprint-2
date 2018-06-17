<?php
session_start();



if(isset($_SESSION["id"]) && isset($_SESSION["pseudo"])){
    
    if(isset($_POST["pass"]) && isset($_POST["passVerif"]) && isset($_POST["oldpass"])){

        require("../param.inc.php");
        $pdo = new PDO("mysql:host=".MYHOST.";dbname=".MYDB, MYUSER, MYPASS);
        $pdo->query("SET NAMES utf8");
        $pdo->query("SET CHARACTER SET 'utf8'");

        $requeteSQL = "SELECT pseudoMbr, nameMbr, prenomMbr, mdpMbr, linkIconMbr FROM MEMBRES WHERE idMbr='".$_SESSION["id"]."'";
        $statement = $pdo->query($requeteSQL);

        $ligne = $statement->fetch(PDO::FETCH_ASSOC);


        $ancienPassCrypt = $ligne["mdpMbr"];

        $msg = "";

        
        

        
        if(!empty($_POST["pass"]) && !empty($_POST["passVerif"])){
            if($_POST["pass"] == $_POST["passVerif"] && strlen($_POST["pass"])>=8 && strlen($_POST["pass"])<=42 && preg_match('#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])#', $_POST["pass"])){

                $requeteSQL = "UPDATE `MEMBRES` SET `mdpMbr` = :newpass WHERE idMbr='".$_SESSION["id"]."'";
                $statement = $pdo->prepare($requeteSQL);
                $statement->execute(array(":newpass" => sha1("cle".$_POST["pass"]."hya")));


            }
            if($_POST["pass"] != $_POST["passVerif"]){
                // vérification mdp incorrect
                
            }
            if(!(strlen($_POST["pass"])>=8 && strlen($_POST["pass"])<=42 && preg_match('#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])#', $_POST["pass"]))){
               
               // nouveau mot de passe incorect il doit comporté...
           }

            if($ancienPassCrypt == sha1("cle".$_POST["oldpass"]."hya") && $_POST["pass"]!= ""){
                //mot de passe actuel incorrect
                
            }

        }



    }else{
        $msg .= "Une erreur est survenue, il se peut que se service soit momentanément indisponible, merci de votre compréhension. \r\n ";
    }
    
    
    echo ($msg);
}

    
?>
