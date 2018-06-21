<?php
    session_start();
	header("Content-type: text/html; charset: UTF-8");
?>
    <!DOCTYPE html>
    <html lang="fr">

    <head>
        <meta charset="utf-8">
        <title>Filyso - Sélectionnez le mode de jeu</title>
        <meta name="description" content="Sélectionnez votre mode de jeu ! Jouez seul avec le mode SOLO ou affrontez d'autres joueurs en duel avec le mode MULTI.">
        <link rel="stylesheet" href="../css/new_style.css">
        <link rel="shortcut icon" href="../images/favicon.png" />
    </head>

    <body>
        <?php include("./main_header.php");?>
        <?php 


        
if(Membre::isLogged()){
    $destination = "./pre_game_page.php?mod=multi";
}else{
    $destination = "./select_game.php?msg=1";
}
                      
?>
        <main class="mainSelect">
            <h1>Choisir le mode de jeu</h1>
            <div class="buttonMulti">
                <?php       
if(isset($_GET["msg"])){
    if($_GET["msg"] == 1){
        echo("<p> Vous devez être connecté pour jouer au jeu </p>");
    }
}                  
?>
                <a href="<?php echo($destination); ?>">MULTI</a>
                <p>Jouez en ligne contre d'autres personnes.</p>
            </div>
            <div class="buttonSolo">
                <a href="./pre_game_page.php">SOLO</a>
                <p>Jouez seul pour vous entraîner.</p>
            </div>

        </main>

        <?php include("./main_footer.php");?>
    </body>

    </html>
