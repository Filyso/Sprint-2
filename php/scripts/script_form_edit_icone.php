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
