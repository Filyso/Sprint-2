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
                <h2>Notre équipe</h2>
                <div class="lesPhotos">
                    <figure class="unePhoto">
                        <img src="../images/avatar.png" alt="Photo de Yoan">
                        <figcaption>
                            <h3>Yoan</h3> Le maître du développement
                        </figcaption>
                    </figure>
                    <figure class="unePhoto">
                        <img src="../images/avatar.png" alt="Photo de Vincent">
                        <figcaption>
                            <h3>Vincent</h3> The Jack of All Trades
                        </figcaption>
                    </figure>
                    <figure class="unePhoto">
                        <img src="../images/avatar.png" alt="Photo de Tristan">
                        <figcaption>
                            <h3>Tristan</h3> Le Graphiste Fou
                        </figcaption>
                    </figure>
                    <figure class="unePhoto">
                        <img src="../images/avatar.png" alt="Photo de Clément">
                        <figcaption>
                            <h3>Clément</h3> Le maître CSS... qui marche moyen
                        </figcaption>
                    </figure>
                    <figure class="unePhoto">
                        <img src="../images/avatar.png" alt="Photo de Justine">
                        <figcaption>
                            <h3>Justine</h3> Elle aime les chats
                        </figcaption>
                    </figure>
                    <figure class="unePhoto">
                        <img src="../images/avatar.png" alt="Photo de Maxime">
                        <figcaption>
                            <h3>Maxime</h3> Le Bodybuilder du PHP
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
                        <button id="formContactSub2">Envoyer</button>
                    </form>

                </div>
                <div class="aVenir" id="avenir">
                    <h2>Prochainement sur Filyso</h2>
                    <p>Quelques événements à venir sur Filyso :</p>
                    <ul>
                        <li>2 avocats (pelés et avec les noyaux retirés)</li>
                        <li>le jus d'un citron</li>
                        <li>¼ de concombre, coupé grossièrement</li>
                        <li>1 petite tomate, coupée</li>
                        <li>le jus d'un autre citron</li>
                    </ul>
                </div>
            </div>
        </main>
        <?php include("./main_footer.php"); ?>
    </body>

    </html>
