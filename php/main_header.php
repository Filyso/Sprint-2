<?php
	header("Content-type: text/html; charset: UTF-8");
    require("src/Membre.php");
   
    if(isset($_POST) && !empty($_POST['pseudo']) && !empty($_POST['pass'])){

        require("./param.inc.php");
        $pdo = new PDO("mysql:host=".MYHOST.";dbname=".MYDB, MYUSER, MYPASS);
        $pdo->query("SET NAMES utf8");
        $pdo->query("SET CHARACTER SET 'utf8'");
        
        $passSha1Verif = sha1("cle".$_POST["pass"]."hya");
        $requeteSQL = "SELECT idMbr, pseudoMbr, nameMbr, prenomMbr, mailMbr, mdpMbr, linkIconMbr, isVerif FROM MEMBRES WHERE pseudoMbr= :pseudo AND mdpMbr= :pass";
        $statement = $pdo->prepare($requeteSQL);
        $statement->execute(array(":pseudo" => $_POST["pseudo"], ":pass" => $passSha1Verif));

        $ligne = $statement->fetch(PDO::FETCH_ASSOC);

        if($_POST["pseudo"] == $ligne["pseudoMbr"] && $passSha1Verif == $ligne["mdpMbr"] && $ligne["isVerif"] == 1){

            $_SESSION["id"] = $ligne["idMbr"];
            $_SESSION["pseudo"] = $ligne["pseudoMbr"];
            $_SESSION["icon"] = $ligne["linkIconMbr"];
            $_SESSION["nom"] = $ligne["nameMbr"];
            $_SESSION["prenom"] = $ligne["prenomMbr"];
            $_SESSION["mail"] = $ligne["mailMbr"];

            //echo("Connecté");
        }else{
            if($_POST["pseudo"] == $ligne["pseudoMbr"] && $passSha1Verif == $ligne["mdpMbr"] && $ligne["isVerif"] == 0){
                //echo("L'email de vérification qui vous a été envoyé n'est pas vérifié");
            }else{
                //echo("Mauvais Identifiants");
            }
            

        }
        
        $requeteSQL = "SELECT roleMbr FROM ROLE WHERE idMbr ='".$ligne["idMbr"]."'";
        $statement = $pdo->query($requeteSQL);
        $ligne = $statement->fetch(PDO::FETCH_ASSOC);
        
        if($ligne["roleMbr"] == "admin" || $ligne["roleMbr"] == "modo"){
            $_SESSION["role"] = $ligne["roleMbr"];
        }
        
        
        $pdo = null;
    }


?>
        <header class="mainHeader">

            <!-- Icône Menu Burger -->
            <div class="container">
                <svg>
                    <path id="first" d="M 30 40 L 70 40 C 90 40 90 75 60 85 A 40 40 0 0 1 20 20 L 80 80"></path>
                    <path id="middle" d="M 30 50 L 70 50"></path>
                    <path id="second" d="M 70 60 L 30 60 C 10 60 10 20 40 15 A 40 38 0 1 1 20 80 L 80 20"></path>
                </svg>
            </div>

            <nav class="menuHidden">

                <ul>

                    <li>
                        <a href="index.php" class="loginMenu">ACCUEIL</a>
                    </li>

                    <li>
                        <a href="./select_game.php" class="loginMenu">JOUER</a>
                    </li>

                    <li>
                        <a href="rank.php" class="loginMenu">CLASSEMENT</a>
                    </li>
<?php
    
    if(Membre::isLogged()){               
?>
                    <li>
                        <a href="account.php" class="loginMenu">MON COMPTE</a>
                    </li>

<?php
    }else{
?>
                    <li>
                        <p id="btnPopup1" class="loginMenu">CONNEXION</p>
                    </li>                  
<?php
    }
    if(Membre::isAdmin() || Membre::isModo()){
?>
                    <li>
                        <a href="admin.php" class="loginMenu">ADMINISTRATION</a>
                    </li>
<?php
    }
?>
                </ul>
            </nav>

            <div class="rightHeader">

<?php
    
    if(Membre::isLogged()){               
?>          
             
                <div class="connect">
                    <a href="logout.php"  class="login">DÉCONNEXION</a>
                </div>  
                <figure>
                    <img alt="icon joueur" src=<?php echo("\"".$_SESSION["icon"]."\""); ?>/>
                </figure>
                              
<?php
    }else{
?>
                <div  id="btnPopup2"  class="connect">
                    <p class="login">CONNEXION</p>
                </div>
                <div class="connect">
                    <a href="sign_up.php" class="signup"><p class="login">INSCRIPTION</p></a>
                </div>
<?php
    }
?>     
                
                <div id="fullScreenButton">
                    <svg viewBox="0 0 24 24">

                        <path id="play" d="m 3.4285714,15.428571 -3.42857145,0 0,8.571429 8.57142905,0 0,-3.428571 -5.1428577,0 0,-5.142858 z M -5e-8,8.5714287 l 3.42857145,0 0,-5.1428573 5.1428577,0 L 8.5714291,0 -4.9999999e-8,0 l 0,8.5714287 z M 20.571428,20.571429 l -5.142857,0 0,3.428571 L 24,24 l 0,-8.571429 -3.428572,0 0,5.142858 z M 15.428571,2e-7 l 0,3.4285714 5.142857,0 0,5.1428571 3.428572,0 L 24,2e-7 l -8.571429,0 z">

                            <animate id="animation-to" begin="indefinite" fill="freeze" attributeName="d" dur="0.15s" to="m 5.0000001e-8,18.857143 5.14285695,0 0,5.142857 3.428572,0 0,-8.571429 -8.571428950000001,0 0,3.428572 z M 5.142857,5.1428572 l -5.14285695,0 0,3.4285714 8.571428949999999,0 0,-8.571428500000001 -3.428572,0 0,5.142857100000001 z M 15.428571,24 l 3.428572,0 0,-5.142857 5.142857,0 0,-3.428572 -8.571429,0 0,8.571429 z m 3.428572,-18.8571428 0,-5.1428571 -3.428572,0 0,8.5714285 8.571429,0 0,-3.4285714 -5.142857,0 z" />


                            <animate id="animation-from" begin="indefinite" fill="freeze" attributeName="d" dur="0.15s" to="m 3.4285714,15.428571 -3.42857145,0 0,8.571429 8.57142905,0 0,-3.428571 -5.1428577,0 0,-5.142858 z M -5e-8,8.5714287 l 3.42857145,0 0,-5.1428573 5.1428577,0 L 8.5714291,0 -4.9999999e-8,0 l 0,8.5714287 z M 20.571428,20.571429 l -5.142857,0 0,3.428571 L 24,24 l 0,-8.571429 -3.428572,0 0,5.142858 z M 15.428571,2e-7 l 0,3.4285714 5.142857,0 0,5.1428571 3.428572,0 L 24,2e-7 l -8.571429,0 z" />

                        </path>
                    </svg>
                </div>

            </div>
            <div class="popup">
                <div class="popup-content">
                    <span class="close">&times;</span>
                    <h2>CONNECTEZ-VOUS</h2>
                    <form action="<?php echo($_SERVER["SCRIPT_NAME"]);?>" method="post">
                        <input id="pseudo" type="text" required="required" name="pseudo" placeholder="Pseudo...">
                        <input id="passwd" type="password" required="required" name="pass" placeholder="Mot de passe...">
                        <button type="submit" id="connexionBtn">SE CONNECTER</button>
                    </form>
                </div>
            </div>
        </header>

        <script src="https://kodhus.com/moveit.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

        <script type="text/javascript" src="../javascript/main_header.js"></script>

        <script type="text/javascript" src="../javascript/verification_conexion.js"></script>

        <script type="text/javascript" src="../javascript/popup_login.js"></script>
