<?php
    session_start();
	header("Content-type: text/html; charset: UTF-8");
?>
    <!DOCTYPE html>
    <html lang="fr">

    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <link href="https://fonts.googleapis.com/css?family=Montserrat:600,900" rel="stylesheet">
        <meta charset="utf-8">
        <meta http-equiv="" content="">
        <title></title>
        <meta name="" content="">
        <link rel="stylesheet" href="style.css">
    </head>

    <body>
       <?php include("./main_header.php");?>
<?php 


        
if(Membre::isLogged()){
    $destination = "./multi_game.php";
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