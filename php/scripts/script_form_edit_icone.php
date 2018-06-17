<?php
session_start();



if(isset($_SESSION["id"]) && isset($_SESSION["pseudo"])){
    
    if(isset($_POST["pseudo"]) && isset($_POST["nom"]) && isset($_POST["prenom"]) && isset($_POST["pass"]) && isset($_POST["passVerif"]) && isset($_POST["oldpass"])){

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
        $ancienPassCrypt = $ligne["mdpMbr"];
        $cheminIcone = $ligne["linkIconMbr"];
        $msg = "";

        
        if($_POST["pseudo"] != $pseudo){

                $requeteSQL = "SELECT pseudoMbr, mailMbr FROM MEMBRES WHERE UPPER(pseudoMbr)= UPPER(:pseudo)";
                $statement = $pdo->prepare($requeteSQL);
                $statement->execute(array(":pseudo" => $_POST["pseudo"]));
                $ligne = $statement->fetch(PDO::FETCH_ASSOC);

                if(empty($ligne["pseudoMbr"]) && strlen($_POST["pseudo"]) >= 4 && strlen($_POST["pseudo"]) <= 16){


                    
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
                    
                    $msg .= "Le prénom a bien été modifié \r\n ";
            }else{
                    $msg .= "Le prénom ne doit pas dépasser 25 caractères \r\n ";
            }
            
        }
        

        
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

                                    


function convertirImage256x256JPG($nomFichierAConvertir, $nomFichierConverti) {
		$imageSource = imageCreateFromJpeg($nomFichierAConvertir);
		$tailleImage = getImageSize($nomFichierAConvertir);
		$largeurImageSource = $tailleImage[0];
		$hauteurImageSource = $tailleImage[1];
		if ($hauteurImageSource > $largeurImageSource) {
			$largeurImageReechantillonne = 256;
			// Contraint le rééchantillonage à une largeur fixe et aintient le ratio de l'image
			$hauteurImageReechantillonne = round(($largeurImageReechantillonne / $largeurImageSource) * $hauteurImageSource);
			$positionX = 0 ;
			$positionY = round(($hauteurImageReechantillonne-$largeurImageReechantillonne)/2) ;
		} 
		else {
			$hauteurImageReechantillonne = 256;
			// Contraint le rééchantillonage à une largeur fixe et maintient le ratio de l'image
			$largeurImageReechantillonne = round(($hauteurImageReechantillonne / $hauteurImageSource) * $largeurImageSource);
			$positionX = round(($largeurImageReechantillonne-$hauteurImageReechantillonne)/2) ;
			$positionY = 0 ;
		}
		$imageReechantillonne = imageCreateTrueColor($largeurImageReechantillonne, $hauteurImageReechantillonne );
		/* ImageCopyResampled copie et rééchantillonne l'image originale*/
		imageCopyResampled($imageReechantillonne,$imageSource,0,0,0,0,
                       $largeurImageReechantillonne, $hauteurImageReechantillonne,
                       $largeurImageSource, $hauteurImageSource);
		$largeurImageDestination = 256 ;
		$hauteurImageDestination = 256 ;
		$imageDestination = imageCreateTrueColor($largeurImageDestination,$hauteurImageDestination);
		imageCopy ( $imageDestination, $imageReechantillonne, 0, 0,
                $positionX, $positionY, $largeurImageDestination,
                $hauteurImageDestination );
		imageDestroy($imageReechantillonne);
		imageJpeg($imageDestination, $nomFichierConverti) ;
		imageDestroy($imageDestination);
	}

function convertirImage256x256PNG($nomFichierAConvertir, $nomFichierConverti) {
		$imageSource = imageCreateFromPng($nomFichierAConvertir);
		$tailleImage = getImageSize($nomFichierAConvertir);
		$largeurImageSource = $tailleImage[0];
		$hauteurImageSource = $tailleImage[1];
		if ($hauteurImageSource > $largeurImageSource) {
			$largeurImageReechantillonne = 256;
			// Contraint le rééchantillonage à une largeur fixe et aintient le ratio de l'image
			$hauteurImageReechantillonne = round(($largeurImageReechantillonne / $largeurImageSource) * $hauteurImageSource);
			$positionX = 0 ;
			$positionY = round(($hauteurImageReechantillonne-$largeurImageReechantillonne)/2) ;
		} 
		else {
			$hauteurImageReechantillonne = 256;
			// Contraint le rééchantillonage à une largeur fixe et maintient le ratio de l'image
			$largeurImageReechantillonne = round(($hauteurImageReechantillonne / $hauteurImageSource) * $largeurImageSource);
			$positionX = round(($largeurImageReechantillonne-$hauteurImageReechantillonne)/2) ;
			$positionY = 0 ;
		}
		$imageReechantillonne = imageCreateTrueColor($largeurImageReechantillonne, $hauteurImageReechantillonne );
		/* ImageCopyResampled copie et rééchantillonne l'image originale*/
		imageCopyResampled($imageReechantillonne,$imageSource,0,0,0,0,
                       $largeurImageReechantillonne, $hauteurImageReechantillonne,
                       $largeurImageSource, $hauteurImageSource);
		$largeurImageDestination = 256 ;
		$hauteurImageDestination = 256 ;
		$imageDestination = imageCreateTrueColor($largeurImageDestination,$hauteurImageDestination);
		imageCopy ( $imageDestination, $imageReechantillonne, 0, 0,
                $positionX, $positionY, $largeurImageDestination,
                $hauteurImageDestination );
		imageDestroy($imageReechantillonne);
		imagePng($imageDestination, $nomFichierConverti) ;
		imageDestroy($imageDestination);
	}

?>
