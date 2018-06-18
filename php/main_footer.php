<?php
?>
    <script  src="../javascript/ajax_form_contact.js"></script>
    <link rel="stylesheet" href="../css/new_style.css" type="text/css" />
    <footer class="footer">
        <a href="./index.php">
                <img class="logo" src="../images/logo_texte_sans_fond.png" alt="logo">
        </a>
        <div class="footerGauche">

            <p class="footer-links">
                <a href="./about.php#equipe">L'ÉQUIPE</a> ·
                <a href="./about.php#idee">BOÎTE À IDÉE</a> ·
                <a href="./about.php#avenir">À VENIR</a>

            </p>

            <div class="footerReseaux">
                <a href="https://twitter.com/Filyso1" target="_blank"><img src="../images/Twitter.png" alt="twitter" ></a>
                <a href="https://www.instagram.com/filysogame" target="_blank"><img src="../images/Instagram.png" alt="instagram"></a>

            </div>

        </div>

        <div class="footerDroite">

            <h3>CONTACTEZ-NOUS</h3>

            <form id="formContact1" method="post">

                <input id="formContactSujet1" type="text" name="text" placeholder="Sujet" required />
                <textarea id="formContactMsg1" name="message" placeholder="Message" required></textarea>
                <button id="formContactSub1">Envoyer</button>

            </form>

        </div>

    </footer>
