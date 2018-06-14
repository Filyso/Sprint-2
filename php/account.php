<?php
    session_start();
	header("Content-type: text/html; charset: UTF-8");
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8"/>
        <meta http-equiv="" content=""/>
        <title>Bienvenue sur Filyso</title>
        <meta name="" content="">
        <link rel="stylesheet" href="../css/new_style.css"/>
    </head>
    <body>
        <?php //include("./main_header.php") ?>
        <main class="mainAccount">
            <div class="infoJoueur">
                <img class="imgJoueurAccount" src""/>
                <div class="textInfoJoueur">
                    <p class="pseudoJoueurAccount">Pseudo du joueur</p>
                    <p class="nomJoueurAccount">Nom : nom du joueur</p>
                    <p class="prenomJoueurAccount">Prenom : prenom du joueur</p>
                    <p class="mailJoueurAccount">Mail : oui@gmail.com</p>
                </div>
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
                                <img  alt="Photo de profil joueur" src=""/>
                            </figure>
                            <p>Michel</p>
                        </td>
                        <td>10.000</td>
                        <td>1</td>
                    </tr>
                    <tr>
                        <td>
                            <figure>
                                <img  alt="Photo de profil joueur" src=""/>
                            </figure>
                            <p>Samuel</p>
                        </td>
                        <td>9.000</td>
                        <td>2</td>
                    </tr>
                    <tr>
                        <td>
                            <figure>
                                <img  alt="Photo de profil joueur" src=""/>
                            </figure>
                            <p>Francis</p>
                        </td>
                        <td>8.000</td>
                        <td>3</td>
                    </tr>
                    <tr>
                        <td>
                            <figure>
                                <img  alt="Photo de profil joueur" src=""/>
                            </figure>
                            <p>Antonin54</p>
                        </td>
                        <td>7.000</td>
                        <td>4</td>
                    </tr>
                    <tr>
                        <td>
                            <figure>
                                <img  alt="Photo de profil joueur" src=""/>
                            </figure>
                            <p>ElRodriguo</p>
                        </td>
                        <td>6.000</td>
                        <td>5</td>
                    </tr>
                </table>
            </div>
            <div class="badgesGagnesAccount">
                <h2>Badges Gagnés</h2>
                <div>
                    <img src=""/>
                    <img src=""/>
                    <img src=""/>
                    <img src=""/>
                    <img src=""/>
                </div>
            </div>
        </main>
        <?php include("./main_footer.php"); ?>
    </body>