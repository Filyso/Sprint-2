<?php
	header("Content-type: text/html; charset: UTF-8");
?>

    <head>
        <link rel="stylesheet" href="../css/style.css" type="text/css" media="screen" />
        <link href="https://fonts.googleapis.com/css?family=Raleway:300,500,700" rel="stylesheet">

    </head>

    <body>
        <header class="mainHeader">

            <!-- Icône Menu Burger -->
            <div class="container">
                <svg>
                    <path id="first" d="M 30 40 L 70 40 C 90 40 90 75 60 85 A 40 40 0 0 1 20 20 L 80 80"></path>
                    <path id="middle" d="M 30 50 L 70 50"></path>
                    <path id="second" d="M 70 60 L 30 60 C 10 60 10 20 40 15 A 40 38 0 1 1 20 80 L 80 20"></path>
                </svg>
                <div class="trigger"></div>
            </div>

            <nav class="menuHidden">

                <ul>

                    <li>
                        <a href="index.php">ACCUEIL</a>
                    </li>

                    <li>
                        <a href="./select_game.php">JOUER</a>
                    </li>

                    <li>
                        <a href="rank.php">CLASSEMENT</a>
                    </li>

                    <li>
                        <p class="login">CONNEXION</p>
                    </li>

                </ul>
            </nav>
            
            <button>Connexion</button>

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

        <script src="https://kodhus.com/moveit.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
        <script type="text/javascript" src="../javascript/popup_login.js"></script>
        <script type="text/javascript" src="../javascript/burger.js"></script>

    </body>