<?php
    session_start();
	header("Content-type: text/html; charset: UTF-8");
?>
    <!DOCTYPE html>
    <html lang="fr">

    <head>
       <meta charset="utf-8"/>
        <title>À propos de Filyso</title <meta>
        <meta name="description" content="Bienvenue dans la section À propos, dans laquelle vous pourrez en apprendre plus sur l'équipe de développement et l'avenir de l'application. Vous pouvez aussi nous proposer vos idées." />
        <link rel="stylesheet" href="../css/new_style.css" type="text/css" media="screen" />
        <link rel="shortcut icon" href="../images/favicon.png" />
    </head>
    <body>
        <?php include("./main_header.php"); ?>
        <main class="mainAbout">
            <div class="equipe" id="equipe">
                <h1>Notre équipe</h1>
                <div class="lesPhotos">
                    <figure class="unePhoto">
                        <img src="../images/equipe/clement.jpg" alt="Photo de Clément">
                        <figcaption>
                            <h3>Clément</h3> Le génie du CSS
                        </figcaption>
                    </figure>
                    <figure class="unePhoto">
                        <img src="../images/equipe/justine.jpg" alt="Photo de Justine">
                        <figcaption>
                            <h3>Justine</h3> La graphiste folle des chats
                        </figcaption>
                    </figure>
                    <figure class="unePhoto">
                        <img src="../images/equipe/maxime.jpg" alt="Photo de Maxime">
                        <figcaption>
                            <h3>Maxime</h3> Le Bodybuilder du PHP
                        </figcaption>
                    </figure>
                    <figure class="unePhoto">
                        <img src="../images/equipe/tristan.jpg" alt="Photo de Tristan">
                        <figcaption>
                            <h3>Tristan</h3> Le graphiste fou
                        </figcaption>
                    </figure>
                    <figure class="unePhoto">
                        <img src="../images/equipe/vincent.jpg" alt="Photo de Vincent">
                        <figcaption>
                            <h3>Vincent</h3> The Jack of All Trades
                        </figcaption>
                    </figure>
                    <figure class="unePhoto">
                        <img src="../images/equipe/yoan.jpg" alt="Photo de Yoan">
                        <figcaption>
                            <h3>Yoan</h3> Le maître du développement
                        </figcaption>
                    </figure>
                </div>
            </div>
            <div class="enDessous">
                <div class="boiteAIdee" id="idee">
                    <h2>Boîte à idées</h2>
                    <p>Une idée ? Un bug ? Une amélioration ? Dites le nous !</p>
                    <form id="formContact2" method="post">
                        <input id="formContactSujet2" type="text" name="sujet" placeholder="Sujet" required/>
                        <textarea id="formContactMsg2" rows=5 name="message" placeholder="Votre idée de génie" required></textarea>
                        <button id="formContactSub2">ENVOYER</button>
                    </form>

                </div>
                <div class="aVenir" id="avenir">
                    <h2>Prochainement sur Filyso</h2>
                    <p>Quelques événements à venir sur Filyso :</p>
                    <ul>
                        <li>Intégration du système de badges</li>
                        <li>Site responsive pour pouvoir jouer partout !</li>
                        <li>Un nouveau mode de jeu : le "Limite Lyrics"</li>
                        <li>Mise en ligne officielle</li>
                        <li>En continu : ajout de plein de chansons !</li>
                    </ul>
                </div>
            </div>
        </main>
        <?php include("./main_footer.php"); ?>
    </body>

    </html>
