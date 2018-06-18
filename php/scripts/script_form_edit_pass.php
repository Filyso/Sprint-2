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
                
                $msg .= "Le mot de passe a bien été modfié \r\n ";

            }else{
                if($ancienPassCrypt != sha1("cle".$_POST["oldpass"]."hya")){
                    //mot de passe actuel incorrect
                    $msg .= "Le mot de passe actuel n'est pas le bon \r\n ";
                }else{
                    
                    if(!(strlen($_POST["pass"])>=8 && strlen($_POST["pass"])<=42 && preg_match('#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])#', $_POST["pass"]))){
                        $msg .= "Le mot de passe doit contenir entre 8 et 42 caractères, au moins une majuscule et une minuscule. \r\n ";
                       // nouveau mot de passe incorect il doit comporté...
                    }
                    
                    if($_POST["pass"] != $_POST["passVerif"]){
                    // vérification mdp incorrect
                        $msg .= "La vérifiacation du mot de passe est erronée \r\n ";
                    }
                    

                }
            }
        }



    }else{
        $msg .= "Une erreur est survenue, il se peut que se service soit momentanément indisponible, merci de votre compréhension. \r\n ";
    }
    
    
    
}else{
    $msg .= "Une erreur est survenue, il se peut que se service soit momentanément indisponible, merci de votre compréhension. \r\n ";
}
$pdo = null; 
echo ($msg);
 

?>
