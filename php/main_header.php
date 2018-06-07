<?php
	header("Content-type: text/html; charset: UTF-8");
    require("src/Membre.php");

    if(isset($_POST) && !empty($_POST['pseudo']) && !empty($_POST['pass'])){

        require("./param.inc.php");
        $pdo = new PDO("mysql:host=".MYHOST.";dbname=".MYDB, MYUSER, MYPASS);
        $pdo->query("SET NAMES utf8");
        $pdo->query("SET CHARACTER SET 'utf8'");

        $requeteSQL = "SELECT idMbr, pseudoMbr, mdpMbr, linkIconMbr FROM MEMBRES WHERE pseudoMbr= :pseudo AND mdpMbr= :pass";
        $statement = $pdo->prepare($requeteSQL);
        $statement->execute(array(":pseudo" => $_POST["pseudo"], ":pass" => $_POST["pass"]));

        $ligne = $statement->fetch(PDO::FETCH_ASSOC);


        if($_POST["pseudo"] == $ligne["pseudoMbr"] && $_POST["pass"] == $ligne["mdpMbr"]){

            $_SESSION["id"] = $ligne["idMbr"];
            $_SESSION["pseudo"] = $ligne["pseudoMbr"];
            $_SESSION["icon"] = $ligne["linkIconMbr"];

            echo("Connecté");
        }else{

            echo("Mauvais Identifiants");

        }

        $pdo = null;
    }


?>

    <head>
        <link rel="stylesheet" href="../style.css" type="text/css" media="screen" />
        <link href="https://fonts.googleapis.com/css?family=Raleway:300,500,700" rel="stylesheet">
        <script type="text/javascript" src="../javascript/popup_login.js"></script>
    </head>

    <body>
        <header class="mainHeader">
            <nav>

                <ul>

                    <li>
                        <a href="index.php">ACCUEIL</a>
                    </li>

                    <li>
                        <a href="./select_game.php">JOUER</a>
                    </li>

                    <li class="mainLogo">
                        <a href="./index.php">
                            <img src="../images/logo.png"/>
                        </a>
                    </li>

                    <li>
                        <a href="rank.php">CLASSEMENT</a>
                    </li>
<?php
    
    if(Membre::isLogged()){               
?>
                    <li>
                        <a href="logout.php">DÉCONNEXION</a>
                    </li>

<?php
    }else{
?>
                    <li>
                        <p class="login">CONNEXION</p>
                    </li>                  
<?php
    }
?>
                </ul>
            </nav>
            <div class="popup">
                <div class="popup-content">
                    <span class="close">&times;</span>
                    <h2>CONNECTEZ-VOUS</h2>
                    <form action="<?php echo($_SERVER["SCRIPT_NAME"]);?>" method="post">
                        <input id="pseudo" type="text" required="required" name="pseudo" placeholder="Pseudo...">
                        <input id="passwd" type="password" required="required" name="pass" placeholder="Mot de passe...">
                        <button type="submit">SE CONNECTER</button>
                    </form>
                </div>
            </div>
        </header>

    </body>
