<?php
    session_start();
	header("Content-type: text/html; charset: UTF-8");
?>
    <!DOCTYPE html>
    <html lang="fr">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="" content="">
        <title></title>
        <meta name="" content="">
        <link rel="stylesheet" href="../style.css">
    </head>

    <body>
        <?php include("./main_header.php")?>
        <main class="mainRank">
            <h1>Classement des joueurs</h1>
                <table>
                    <tr>
                        <th>Joueur</th>
                        <th>Classement</th>
                    </tr>
                    <tr>
                        <td>Michel</td>
                        <td>1</td>
                    </tr>
                    <tr>
                        <td>Samuel</td>
                        <td>2</td>
                    </tr>
                    <tr>
                        <td>Francis</td>
                        <td>3</td>
                    </tr>
                    <tr>
                        <td>Antonin54</td>
                        <td>4</td>
                    </tr>
                    <tr>
                        <td>ElRodriguo</td>
                        <td>5</td>
                    </tr>
                    <tr>
                        <td>MasutaSama</td>
                        <td>6</td>
                    </tr>
                    <tr>
                        <td>Philippe</td>
                        <td>7</td>
                    </tr>
                    <tr>
                        <td>Duschmol</td>
                        <td>8</td>
                    </tr>
                    <tr>
                        <td>Dudule</td>
                        <td>9</td>
                    </tr>
                    <tr>
                        <td>TontonJC</td>
                        <td>10</td>
                    </tr>
                </table>
        </main>
        <?php include("./main_footer.php")?>
    </body>

    </html>
