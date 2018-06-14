<?php

session_start();

require("../src/Membre.php");

if(isset($_POST["sujet"]) && isset($_POST["message"])){
    
    
        if(isset($_SESSION["pseudo"]) && isset($_SESSION["mail"]) && Membre::isLogged()){
            if($_POST["sujet"] != "" && $_POST["message"] != ""){
                sendMail("filysogame@gmail.com",$_POST["sujet"],$_POST["message"]);

                echo("Reussie");
            }else{
                echo("vide");
            }
        }else{
            echo("Echec");
        }
    
}



function sendMail($destinataire, $sujet, $msg) {


	$passage_ligne = "\r\n";
	$boundary = "-----=".md5(rand());
	$header = "From: \"FILYSO\"<filysogame@gmail.com>".$passage_ligne;
	$header.= "Reply-to: \"".$_SESSION["pseudo"]."\" <".$_SESSION["mail"].">".$passage_ligne;
	$header.= "MIME-Version: 1.0".$passage_ligne;
	$header.= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;

	$message = $passage_ligne."--".$boundary.$passage_ligne;
	$message.= "Content-Type: text/html; charset=\"UTF-8\"".$passage_ligne;
	$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
	$message.= $passage_ligne.$msg.$passage_ligne;
	$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
	$message.= $passage_ligne."--".$boundary."--".$passage_ligne;


	mail($destinataire, $sujet, $message, $header);


}


?>