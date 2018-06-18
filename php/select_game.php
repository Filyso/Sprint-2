<?php
    session_start();
	header("Content-type: text/html; charset: UTF-8");
?>
    <!DOCTYPE html>
    <html lang="fr">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="" content="">
        <title>Filyso - Sélectionnez le mode de jeu</title>
        <meta name="" content="">
        <!--<link rel="stylesheet" href="../css/style.css">-->
        <link rel="stylesheet" href="../css/new_style.css">
    </head>

    <body>
       <?php include("./main_header.php");?>
<?php 


        
if(Membre::isLogged()){
    $destination = "./pre_game_page.php?mod=multi";
}else{
    $destination = "./select_game.php";
}
                      
?>
        <main class="mainSelect">
            <h1>Choisir le mode de jeu</h1>
            <div class="buttonMulti">
                <a href=<?php echo($destination); ?>>MULTI</a>
                <p>Jouez en ligne contre d'autres personnes.</p>
            </div>
            <div class="buttonSolo">
                <a href="./pre_game_page.php">SOLO</a>
                <p>Jouez seul pour vous entraîner.</p>
            </div>

        </main>
        
        <?php include("./main_footer.php")?>
    </body>

    </html>