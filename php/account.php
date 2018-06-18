<?php
    header("Content-type: text/html; charset: UTF-8");
    session_start();

    if(!isset($_SESSION["id"]) && !isset($_SESSION["pseudo"])){
        header("Location: index.php");
    }	
?>
    <!DOCTYPE html>
    <html lang="fr">

    <head>
       <meta charset="utf-8"/>
        <title>Espace mon compte</title>
        <meta name="description" content="Bienvenue dans votre espace personnel de compte. Ici vous pourrez consulter les données relatives à votre compte et votre activité sur le site Filyso.">
        <link rel="stylesheet" href="../css/new_style.css" />
    </head>

    <body>
        <?php include("./main_header.php") ?>
        <main class="mainAccount">
            <div class="infoJoueur">
                <figure class="figureImgJoueurAccount">
                    <img src="<?php echo($_SESSION[" icon "]); ?>" class="imgJoueurAccount" src="" />
                </figure>
                    <p class="pseudoJoueurAccount"><?php echo($_SESSION["pseudo"]); ?></p>
                    <p class="nomJoueurAccount">Nom : <?php echo($_SESSION["nom"]); ?></p>
                    <p class="prenomJoueurAccount">Prénom : <?php echo($_SESSION["prenom"]); ?></p>
                    <p class="mailJoueurAccount">Mail : <?php echo($_SESSION["mail"]); ?></p>
                <input type="button" value="Editer">
            </div>
            <div class="classementAccount">
                <table class="tableauAccount">
                    <tr>
                        <th>Joueur</th>
                        <th>Score</th>
                        <th>Classement</th>
                    </tr>
                    <tr>
                        <td>
                            <figure>
                                <img src="../images/chat.jpg" alt="Photo de profil joueur" src="" />
                            </figure>
                            <p>Michel</p>
                        </td>
                        <td>10.000</td>
                        <td>1</td>
                    </tr>
                    <tr>
                        <td>
                            <figure>
                                <img src="../images/chat.jpg" alt="Photo de profil joueur" src="" />
                            </figure>
                            <p>Samuel</p>
                        </td>
                        <td>9.000</td>
                        <td>2</td>
                    </tr>
                    <tr class="vous">
                        <td>
                            <figure>
                                <img src="<?php echo($_SESSION[" icon "]); ?>" alt="Photo de profil joueur" src="" />
                            </figure>
                            <p>Vous</p>
                        </td>
                        <td>8.000</td>
                        <td>3</td>
                    </tr>
                    <tr>
                        <td>
                            <figure>
                                <img src="../images/chat.jpg" alt="Photo de profil joueur" src="" />
                            </figure>
                            <p>Antonin54</p>
                        </td>
                        <td>7.000</td>
                        <td>4</td>
                    </tr>
                    <tr>
                        <td>
                            <figure>
                                <img src="../images/chat.jpg" alt="Photo de profil joueur" src="" />
                            </figure>
                            <p>ElRodriguo</p>
                        </td>
                        <td>6.000</td>
                        <td>5</td>
                    </tr>
                </table>
            </div>
            <div class="badgesGagnes">
                <h2>Badges Gagnés</h2>
                <p>Bientôt Disponible !</p>
                <div>
                    <img src="" />
                    <img src="" />
                    <img src="" />
                    <img src="" />
                    <img src="" />
                </div>
            </div>
        </main>
        <?php include("./main_footer.php"); ?>
    </body>
