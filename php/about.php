<?php
	header("Content-type: text/html; charset: UTF-8");
?>
<head>
    <link rel="stylesheet" href="../style.css" type="text/css" media="screen" />
    <link href="https://fonts.googleapis.com/css?family=Montserrat:600,900" rel="stylesheet">
</head>

<body>
    <?php include("./main_header.php"); ?>
    <main>
        <div class="equipe" id="equipe">
            <h2>Notre équipe</h2>
            <div class="lesPhotos">
                <figure class="unePhoto">
                    <img src="../images/avatar.png" alt="Photo de Yoan">
                    <figcaption>
                        <h3>Yoan</h3> blablabla
                    </figcaption>
                </figure>
                <figure class="unePhoto">
                    <img src="../images/avatar.png" alt="Photo de Vincent">
                    <figcaption>
                        <h3>Vincent</h3> blablabla
                    </figcaption>
                </figure>
                <figure class="unePhoto">
                    <img src="../images/avatar.png" alt="Photo de Tristan">
                    <figcaption>
                        <h3>Tristan</h3> blablabla
                    </figcaption>
                </figure>
                <figure class="unePhoto">
                    <img src="../images/avatar.png" alt="Photo de Clément">
                    <figcaption>
                        <h3>Clément</h3> blablabla
                    </figcaption>
                </figure>
                <figure class="unePhoto">
                    <img src="../images/avatar.png" alt="Photo de Justine">
                    <figcaption>
                        <h3>Justine</h3> blablabla
                    </figcaption>
                </figure>
                <figure class="unePhoto">
                    <img src="../images/avatar.png" alt="Photo de Maxime">
                    <figcaption>
                        <h3>Maxime</h3> blablabla
                    </figcaption>
                </figure>
            </div>
        </div>
        <div class="enDessous">
        <div class="BoiteAIdee" id="idee">
            <h2>Boîte à idées</h2>
            <p>Une idée ? Un bug ? Une amélioration ? Dites le nous !</p>
            <form action="#" method="post">
                <input type="email" name="email" placeholder="Email" required/>
                <textarea rows=5 name="message" placeholder="Votre idée de génie" required></textarea>
                <button>Envoyer</button>
            </form>

        </div>
        <div class="AVenir" id="avenir">
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