<?php
$erreur = "";
session_start();

if(isset($_SESSION["id"]) && isset($_SESSION["pseudo"])){
    
    require("./param.inc.php");
    $pdo = new PDO("mysql:host=".MYHOST.";dbname=".MYDB, MYUSER, MYPASS);
    $pdo->query("SET NAMES utf8");
    $pdo->query("SET CHARACTER SET 'utf8'");
    
    $requeteSQL = "SELECT idMbr, pseudoMbr, nameMbr, prenomMbr, mailMbr FROM MEMBRES WHERE idMbr='".$_SESSION["id"]."'";
    $statement = $pdo->query($requeteSQL);
    $ligne = $statement->fetch(PDO::FETCH_ASSOC);
    
}else{
    header("Location: index.php");
}


if(isset($_SESSION["id"]) && isset($_SESSION["pseudo"]) && isset($_FILES["iconChoisieEdit"]) && isset($_POST["hiddenEdit"])){
    
    
    if($_FILES["iconChoisieEdit"]["name"] == ""){
        $extConforme = true;
    }else{
        $extConforme = false;
    }
    
    

    if(isset($_FILES["iconChoisieEdit"]) && $_FILES["iconChoisieEdit"]["name"] != ""){
        
        $extensions_valides = array('jpg', 'jpeg','png');

        $extension_upload = strtolower(substr(strrchr($_FILES['iconChoisieEdit']['name'],'.'),1));
        
        if(in_array($extension_upload,$extensions_valides)){
            
            $extConforme = true;
        }else{
            $extConforme = false;
        }
    }

    
    
    
    if(($_FILES["iconChoisieEdit"]["name"] == ".htaccess.txt" || $_FILES["iconChoisieEdit"]["size"] > 2000000 || $_POST["hiddenEdit"] == "") || !$extConforme){
        
        //inscription invalide
        
        
        
        if(!($_FILES["iconChoisieEdit"]["name"] == "") && !$extConforme){
            $erreur = $erreur."Le fichier doit être un fichier PNG,JPG ou JPEG"."<br/>";
        }
        if(!($_FILES["iconChoisieEdit"]["name"] == "") && $_FILES["iconChoisieEdit"]["size"] > 2000000){
            $erreur = $erreur."Le fichier est trop volumineux"."<br/>";
        }
        if(!($_FILES["iconChoisieEdit"]["name"] == "") && $_FILES["iconChoisieEdit"]["name"] == ".htaccess.txt"){
            $erreur = $erreur."Pas de fichier .htaccess (on tient au bon fonctionnement du site)"."<br/>";
        }
        if($_POST["hiddenEdit"] == "" && $_FILES["iconChoisieEdit"]["name"] == ""){
            $erreur = $erreur."Aucune icône n'a été selectionnée"."<br/>";
        }
        
        $pdo = null;
        
        
    }else{
        $erreur .= "Votre image de profil a bien été modifiée";
        
        //inscription valide
       
        if(($_FILES["iconChoisieEdit"]["name"] != "")){
            if($extension_upload == "jpg" || $extension_upload == "jpeg"){
                convertirImage256x256JPG($_FILES["iconChoisieEdit"]["tmp_name"], "../images/icons/img_avatar_".md5("azerty".$ligne["idMbr"]).".".$extension_upload);
            }
            if($extension_upload == "png"){
                convertirImage256x256PNG($_FILES["iconChoisieEdit"]["tmp_name"], "../images/icons/img_avatar_".md5("azerty".$ligne["idMbr"]).".".$extension_upload);
            } 
            if(stristr($_SESSION["icon"],"../images/icons/img_avatar_") !== false ){
                unlink($_SESSION["icon"]);
            }
            $requeteSQL = "UPDATE `MEMBRES` SET `linkIconMbr` = '../images/icons/img_avatar_".md5("azerty".$ligne["idMbr"]).".".$extension_upload."' WHERE idMbr='".$ligne["idMbr"]."'";
            $statement = $pdo->query($requeteSQL);
            
            $_SESSION["icon"] = "../images/icons/img_avatar_".md5("azerty".$ligne["idMbr"]).".".$extension_upload;
        }else{
            if(stristr($_SESSION["icon"],"../images/icons/img_avatar_") !== false ){
                unlink($_SESSION["icon"]);
            }
            
            $requeteSQL = "UPDATE `MEMBRES` SET `linkIconMbr` = '".$_POST["hiddenEdit"]."' WHERE idMbr='".$_SESSION["id"]."'";
            $statement = $pdo->query($requeteSQL);
           
            $_SESSION["icon"] = $_POST["hiddenEdit"];
        }
        
        
        $pdo = null;
        
        
    } 
    
    
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


<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="description" content="Editez votre compte."/>
    <title>Editez votre compte</title>
    <link rel="stylesheet" type="text/css" href="../css/new_style.css" />
    <script type="text/javascript" src="../javascript/verification_inscription.js"></script>
    
</head>

<body style="background-color:black">
    <?php include("./main_header.php"); ?>
    <main class="signUpPage">
        <form id="editFormPerso" method="post">
            <h1>Edition compte</h1>
            <h2>Informations personnelles</h2>
            <fieldset>
                <div>
                    <label for="pseudoEdit" ></label>
                    <input placeholder="Pseudo" name="pseudoEdit" type="text" id="pseudoEdit" required="required" size="16" minlength="4" maxlength="16" title="Le pseudo doit être compris entre 4 et 16 caractères" pattern="^([0-9a-zA-Z]{4,16})$" value="<?php echo($ligne["pseudoMbr"]); ?>"/>
                
                    <label for="lastnameEdit"></label>
                    <input placeholder="Nom" name="lastnameEdit" type="text" id="lastnameEdit" required="required" size="25" minlength="1" maxlength="25" title="Le nom ne doit pas dépasser 25 caractères" pattern="^([a-zA-Z'àâéèêôùûçÀÂÉÈÔÙÛÇ-]{1,25})$" value="<?php echo($ligne["nameMbr"]); ?>"/>
            
                    <label for="nameEdit"></label>
                    <input placeholder="Prénom" name="nameEdit" type="text" id="nameEdit" required="required" size="25" minlength="1" maxlength="25" title="Le prénom ne doit pas dépasser 25 caractères" pattern="^([a-zA-Z'àâéèêôùûçÀÂÉÈÔÙÛÇ-]{1,25})$" value="<?php echo($ligne["prenomMbr"]); ?>"/>
        
                    <label for="emailEdit"></label>
                    <input placeholder="Adresse mail" name="emailEdit" type="email" id="emailEdit" required="required" pattern="^[a-zA-Z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$" disabled value="<?php echo($ligne["mailMbr"]); ?>"/>
                </div>
            </fieldset>
            <button id="editSubmitPerso" type="submit">Editer</button>
        </form>
                
        <form id="editFormPass" method="post">
            <h2>Mot de passe</h2>
            <fieldset>
                <div>          
                    <label for="oldPass"></label>
                    <input placeholder="Ancien mot de passe" name="oldPass" type="password" id="oldPass" required="required" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).{8,42}$"/>
                    
                    <label for="passEdit"></label>
                    <input placeholder="Nouveau mot de passe" name="passEdit" type="password" id="passEdit" required="required" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).{8,42}$"/>
    
                    <label for="passverifEdit"></label>
                    <input placeholder="Confirmer le mot de passe" name="passverifEdit" type="password" id="passverifEdit" required="required" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).{8,42}$"/>
                </div>
            </fieldset>
            <button id="editSubmitPass" type="submit">Editer</button>
        </form>
          
        <form id="editFormIcone" method="post" enctype="multipart/form-data" action="edit_account.php">
            <h2>Icône de joueur</h2>
            <fieldset>
                <div>
<!--                    <input type="hidden" name="MAX_FILE_SIZE" value="2000000"/>-->

                    <label for="iconChoisieEdit" class="labelIcone">Remplacer votre icône par l'image que vous souhaitez (JPG ou PNG | max. 2Mo)</label>
                    <input name="iconChoisieEdit" type="file" id="iconChoisieEdit" />
                    <p class="choisirImageDefinis"> ou choisissez-en une parmi celles-ci :</p>
                <div class="imagesProfil">
<?php
            $dossier = glob("../images/icons/default/*");
            foreach($dossier as $fichier){ 
                $nomfichier = substr($fichier,24);
?>          
            <figure  data-icon="<?php echo($nomfichier); ?>">
                    <img src="<?php echo($fichier); ?>" alt="Icône par défault"/>      
            </figure>  
<?php
            }        
                    
?>
                        </div>
                    <input id="hiddenEdit" type="hidden" name="hiddenEdit" value=""/>
                </div>
            </fieldset>
            <button id="editSubmitIcone" type="submit">Editer</button>
            <p><?php echo($erreur); ?></p>
        </form>
    </main>
    <?php include("./main_footer.php"); ?>
    
<!--
    <script type="text/javascript" src="../javascript/verification_inscription.js"></script>
-->
    <script type="text/javascript" src="../javascript/verifier_icone_choisie_signup.js"></script>

    <script type="text/javascript" src="../javascript/edit_account.js"></script>
</body>

</html>
