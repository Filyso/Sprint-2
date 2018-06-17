<?php
session_start();



if(isset($_SESSION["id"]) && isset($_SESSION["pseudo"])){
    
    if(isset($_POST["pseudo"]) && isset($_POST["nom"]) && isset($_POST["prenom"])){

        require("../param.inc.php");
        $pdo = new PDO("mysql:host=".MYHOST.";dbname=".MYDB, MYUSER, MYPASS);
        $pdo->query("SET NAMES utf8");
        $pdo->query("SET CHARACTER SET 'utf8'");

        $requeteSQL = "SELECT pseudoMbr, nameMbr, prenomMbr, mdpMbr, linkIconMbr FROM MEMBRES WHERE idMbr='".$_SESSION["id"]."'";
        $statement = $pdo->query($requeteSQL);

        $ligne = $statement->fetch(PDO::FETCH_ASSOC);

        $pseudo = $ligne["pseudoMbr"];
        $nom = $ligne["nameMbr"];
        $prenom = $ligne["prenomMbr"];
        $msg = "";

        
        if($_POST["pseudo"] != $pseudo){

                $requeteSQL = "SELECT pseudoMbr, mailMbr FROM MEMBRES WHERE UPPER(pseudoMbr)= UPPER(:pseudo)";
                $statement = $pdo->prepare($requeteSQL);
                $statement->execute(array(":pseudo" => $_POST["pseudo"]));
                $ligne = $statement->fetch(PDO::FETCH_ASSOC);

                if(empty($ligne["pseudoMbr"]) && strlen($_POST["pseudo"]) >= 4 && strlen($_POST["pseudo"]) <= 16){

                    $_SESSION["pseudo"] = $_POST["pseudo"];
                    
                    $requeteSQL = "UPDATE `MEMBRES` SET `pseudoMbr` = :pseudo WHERE idMbr='".$_SESSION["id"]."'";
                    $statement = $pdo->prepare($requeteSQL);
                    $statement->execute(array(":pseudo" => $_POST["pseudo"]));
                    
                    
                    $msg .= "Le pseudo a bien été modifié \r\n ";
                }else{
                    if(!empty($ligne["pseudoMbr"])){
                        $msg .= "Le pseudo est déjà utilisé \r\n ";
                    }else{
                        $msg .= "Le pseudo n'est pas conforme (entre 4 et 16 caractères) \r\n ";
                    }
                    
                }


        }
        
        if($_POST["nom"] != $nom){
            
            if(strlen($_POST["nom"]) <= 25){
                    $requeteSQL = "UPDATE `MEMBRES` SET `nameMbr` = :nom WHERE idMbr='".$_SESSION["id"]."'";
                    $statement = $pdo->prepare($requeteSQL);
                    $statement->execute(array(":nom" => $_POST["nom"]));
                    
                    
                    $_SESSION["nom"] = $_POST["nom"];
                    $msg .= "Le nom a bien été modifié \r\n ";
            }else{
                    $msg .= "Le nom ne doit pas dépasser 25 caractères \r\n ";
            }
            
        }
        
        if($_POST["prenom"] != $prenom){
            
            if(strlen($_POST["prenom"]) <= 25){
                    $requeteSQL = "UPDATE `MEMBRES` SET `prenomMbr` = :prenom WHERE idMbr='".$_SESSION["id"]."'";
                    $statement = $pdo->prepare($requeteSQL);
                    $statement->execute(array(":prenom" => $_POST["prenom"]));
                    $_SESSION["prenom"] = $_POST["prenom"];
                    $msg .= "Le prénom a bien été modifié \r\n ";
            }else{
                    $msg .= "Le prénom ne doit pas dépasser 25 caractères \r\n ";
            }
            
        }
        

    
    
    echo ($msg);
}
}

                                    

?>
