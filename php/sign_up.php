<?php
$erreur = "";
session_start();





if(isset($_POST["pseudoSignUp"]) && isset($_POST["lastname"]) && isset($_POST["name"]) && isset($_POST["emailSignUp"]) && isset($_POST["passSignUp"]) && isset($_POST["passverif"]) && isset($_POST["icon"]) && isset($_FILES["iconChoisie"])){

    
    
    require("./param.inc.php");
    $pdo = new PDO("mysql:host=".MYHOST.";dbname=".MYDB, MYUSER, MYPASS);
    $pdo->query("SET NAMES utf8");
    $pdo->query("SET CHARACTER SET 'utf8'");

    $requeteSQL = "SELECT pseudoMbr, mailMbr FROM MEMBRES WHERE UPPER(pseudoMbr)= UPPER(:pseudo) OR mailMbr= :emailSignUp";
    $statement = $pdo->prepare($requeteSQL);
    $statement->execute(array(":pseudo" => $_POST["pseudoSignUp"], ":emailSignUp" => $_POST["emailSignUp"]));
    
    $ligne = $statement->fetch(PDO::FETCH_ASSOC);
    
    if($_FILES["iconChoisie"]["name"] == ""){
        $extConforme = true;
    }else{
        $extConforme = false;
    }
    // le pseudo ou le mail ne doit pas être déjà utilisé, l'image doit être en jpeg ou png, la taille de l'image ne doit pas dépassé 3Mo, 
    if($_FILES["iconChoisie"]["name"] != ""){
        
        $extensions_valides = array('jpg', 'jpeg','png');

        $extension_upload = strtolower(substr(strrchr($_FILES['iconChoisie']['name'],'.'),1));
        
        
        if(in_array($extension_upload,$extensions_valides)){
            
            $extConforme = true;
        }else{
            $extConforme = false;
        }
        
        
        
        
    }

    $password = $_POST["passSignUp"];
    
    
    if(strlen($password)>=8 && strlen($password)<=42){
        
        if(preg_match('#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])#', $password)){
            $mdpConforme = true;
        }else{
            $mdpConforme = false;
        }
           
    }else{
        $mdpConforme = false;
    }
           
    $pseudo = $_POST["pseudoSignUp"];
           
    if(strlen($pseudo) >= 4 && strlen($pseudo) <= 16){
        $pseudoConforme = true;
    }else{
        $pseudoConforme = false;
    }  
    
    
    
    
    
    if(!empty($ligne["pseudoMbr"]) || !empty($ligne["mailMbr"]) || $_FILES["iconChoisie"]["name"] == ".htaccess.txt" || $_FILES["iconChoisie"]["size"] > 2000000 || !$mdpConforme || !$pseudoConforme || !($password == $_POST["passverif"]) || strlen($_POST["lastname"]) > 25 || strlen($_POST["name"]) > 25 || strlen($_POST["emailSignUp"]) > 50 || $_POST["icon"] == "" || !$extConforme){
        
        //inscription invalide
        if(strlen($_POST["lastname"]) > 25){
            
            $erreur = $erreur."Nom trop long (supérieur à 25 caractères)"."<br/>";
        }
        if(strlen($_POST["name"]) > 25){
            
            $erreur = $erreur."Prénom trop long (supérieur à 25 caractères)"."<br/>";
        }
        if(strlen($_POST["emailSignUp"]) > 50){
            
            $erreur = $erreur."Mail trop long (supérieur à 50 caractères)"."<br/>";
        }
        if(!$mdpConforme){
            $erreur = $erreur."Le mot de passe doit contenir une majuscule, une miniscule, un chiffre, 8 caractères au minimum et 42 au maximum"."<br/>";
        }
        if(!$pseudoConforme){
            $erreur = $erreur."Le pseudo doit contenir au moins 4 caractères, mais il ne doit pas en contenir plus de 16"."<br/>";
        }
        if(!empty($ligne["pseudoMbr"])){
            $erreur = $erreur."Pseudo ou Mail déjà utilisé"."<br/>";
        }
        if(!($_FILES["iconChoisie"]["name"] == "") && !$extConforme){
            $erreur = $erreur."Le fichier doit être un fichier PNG,JPG ou JPEG"."<br/>";
        }
        if(!($_FILES["iconChoisie"]["name"] == "") && $_FILES["iconChoisie"]["size"] > 2000000){
            $erreur = $erreur."Le fichier est trop volumineux"."<br/>";
        }
        if(!($_FILES["iconChoisie"]["name"] == "") && $_FILES["iconChoisie"]["name"] == ".htaccess.txt"){
            $erreur = $erreur."Pas de fichier .htaccess (on tient au bon fonctionnement du site)"."<br/>";
        }
        if($password != $_POST["passverif"]){
            $erreur = $erreur."La vérification mot de passe n'est pas valide"."<br/>";
        }
        if($_POST["icon"] == "" && $_FILES["iconChoisie"]["name"] == ""){
            $erreur = $erreur."Aucune icône n'a été selectionnée"."<br/>";
        }
        
        $pdo = null;
        
        
    }else{
        $erreur = "Inscription réussie, un mail de vérification vous a été envoyé(e)";
        
        $passSha1 = sha1("cle".$_POST["passSignUp"]."hya");
        //inscription valide
        $requeteSQL = "INSERT INTO `MEMBRES` (`pseudoMbr`, `nameMbr`, `prenomMbr`, `mailMbr`, `mdpMbr`,  `isVerif`) VALUES (:pseudoSignUp, :lastname, :name, :emailSignUp, :passSignUp,'0')";
        $statement = $pdo->prepare($requeteSQL);
        $statement->execute(array(":pseudoSignUp" => $_POST["pseudoSignUp"], 
                                  ":lastname" => $_POST["lastname"],
                                 ":name" => $_POST["name"],
                                 ":emailSignUp" => $_POST["emailSignUp"],
                                 ":passSignUp" => $passSha1));
        
        
        $requeteSQL = "SELECT LAST_INSERT_ID() AS idMbr";
        $statement = $pdo->query($requeteSQL);
        $ligne = $statement->fetch(PDO::FETCH_ASSOC);
        
       
        if(($_FILES["iconChoisie"]["name"] != "")){
            if($extension_upload == "jpg" || $extension_upload == "jpeg"){
                convertirImage256x256JPG($_FILES["iconChoisie"]["tmp_name"], "../images/icons/img_avatar_".md5("azerty".$ligne["idMbr"]).".".$extension_upload);
            }
            if($extension_upload == "png"){
                convertirImage256x256PNG($_FILES["iconChoisie"]["tmp_name"], "../images/icons/img_avatar_".md5("azerty".$ligne["idMbr"]).".".$extension_upload);
            } 
            
            $requeteSQL = "UPDATE `MEMBRES` SET `linkIconMbr` = '../images/icons/img_avatar_".md5("azerty".$ligne["idMbr"]).".".$extension_upload."' WHERE idMbr='".$ligne["idMbr"]."'";
            $statement = $pdo->query($requeteSQL);
            
            
        }else{
            
            $requeteSQL = "UPDATE `MEMBRES` SET `linkIconMbr` = '../images/icons/default/".$_POST["icon"]."' WHERE idMbr='".$ligne["idMbr"]."'";
            $statement = $pdo->query($requeteSQL);
           
        }
        
        
        $pdo = null;
        
        
        sendMail($_POST["emailSignUp"],"Mail de vérification Filyso","Valider votre inscription !\r\n https://projets.iut-laval.univ-lemans.fr/17mmi1pj02/php/scripts/script_verif.php?id=".$ligne["idMbr"]);
        
    } 
    
}

function sendMail($destinataire, $sujet, $msg) {


	$passage_ligne = "\r\n";
	$boundary = "-----=".md5(rand());
	$header = "From: \"FILYSO\"<filyso@univ-lemans.fr>".$passage_ligne;
	$header.= "Reply-to: \"".$_POST['pseudoSignUp']."\" <".$_POST['emailSignUp'].">".$passage_ligne;
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
    <meta name="description" content="Inscrivez-vous."/>
    <title>Inscrivez-vous</title>
    <link rel="stylesheet" type="text/css" href="../css/new_style.css" />
    
</head>

<body>
    <?php include("./main_header.php"); ?>
    <main class="signUpPage">
        <form id="signUpForm" action="./sign_up.php" method="post" enctype="multipart/form-data">
            <?php 
            if($erreur != ""){ 
                echo($erreur);
            } 
            ?>
            <h1>Inscription</h1>
            <fieldset>
                <div>
                    <label for="pseudoSignUp" ></label>
                    <input placeholder="Pseudo" name="pseudoSignUp" type="text" id="pseudoSignUp" required="required" size="16" minlength="4" maxlength="16" title="Le pseudo doit être compris entre 4 et 16 caractères" pattern="^([0-9a-zA-Z]{4,16})$" />
                
                    <label for="lastname"></label>
                    <input placeholder="Nom" name="lastname" type="text" id="lastname" required="required" size="25" minlength="1" maxlength="25" title="Le nom ne doit pas dépasser 25 caractères" pattern="^([a-zA-Z'àâéèêôùûçÀÂÉÈÔÙÛÇ-]{1,25})$"/>
            
                    <label for="name"></label>
                    <input placeholder="Prénom" name="name" type="text" id="name" required="required" size="25" minlength="1" maxlength="25" title="Le prénom ne doit pas dépasser 25 caractères" pattern="^([a-zA-Z'àâéèêôùûçÀÂÉÈÔÙÛÇ-]{1,25})$"/>
        
                    <label for="emailSignUp"></label>
                    <input placeholder="Adresse mail" name="emailSignUp" type="email" id="emailSignUp" required="required" pattern="^[a-zA-Z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$"/>
    
                    <label for="passSignUp"></label>
                    <input placeholder="Mot de passe" name="passSignUp" type="password" id="passSignUp" required="required" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).{8,42}$"/>
    
                    <label for="passverif"></label>
                    <input placeholder="Confirmer le mot de passe" name="passverif" type="password" id="passverif" required="required" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).{6,}$"/>

<!--                    <input type="hidden" name="MAX_FILE_SIZE" value="2000000" />-->

                    <label for="iconChoisie" class="labelIcone">Importez votre icône (JPG ou PNG | max. 2Mo)</label>
                    <input name="iconChoisie" type="file" id="iconChoisie" />
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
                    <input id="hiddenSignUp" type="hidden" name="icon" value=""/>
                </div>
            </fieldset>
            <button id="btnSignUp" type="submit">Terminer</button>
        </form>
    </main>
    <?php include("./main_footer.php"); ?>
    
    <script type="text/javascript" src="../javascript/verification_inscription.js"></script>
    <script type="text/javascript" src="../javascript/verifier_icone_choisie_signup.js"></script>
</body>

</html>
