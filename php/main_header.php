<?php
	header("Content-type: text/html; charset: UTF-8");
?>

    <head>
        <link rel="stylesheet" href="../css/style.css" type="text/css" media="screen" />
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

                    <li>
                        <p class="login">CONNEXION</p>
                    </li>

                </ul>
            </nav>
            <div class="popup">
                <div class="popup-content">
                    <span class="close">&times;</span>
                    <h2>CONNECTEZ-VOUS</h2>
                    <form>
                        <input id="email" type="email" required="required" name="email" placeholder="Adresse Email...">
                        <input id="passwd" type="password" required="required" name="passwd" placeholder="Mot de passe...">
                        <button type="submit">SE CONNECTER</button>
                    </form>
                </div>
            </div>
        </header>

    </body>
