<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="fr">

    <head>
       <meta charset="utf-8"/>
        <title>Page d'administration</title>
        <meta name="description" content="Bienvenuee sur la page d'administration de Filyso. Ici vous pourrez consulter la liste des membres et des chansons. Vous pourrez ajouter ou modifier de chansons, et supprimer des utilisateurs si nécessaire.">
        <link rel="stylesheet" type="text/css" href="../css/new_style.css" />
        <link rel="shortcut icon" href="../images/favicon.png" />
    </head>

    <body>

        <?php 
            include("./main_header.php");
            if (!(Membre::isAdmin()) && !(Membre::isModo())) {
                header("Location: ./index.php");
            }
        ?>
        <main class="mainAdmin">
            <header class="headerAdmin">

                <div>
                    <h2>GESTION DE CONTENU</h2>
                    <form action="./admin.php" method="get">
                        <input type="submit" value="Ajout de chansons" name="admin" />
                        <?php
                            if (Membre::isAdmin()) {
                            ?>
                            <input type="submit" value="Modification/Suppression de chansons" name="admin" />
                            <?php
                            }
                            ?>
                    </form>
                </div>

                <?php
                    if (Membre::isAdmin()) {
                    ?>
                    <div>
                        <h2>GESTION D'UTILISATEURS</h2>
                        <form action="./admin.php" method="get">
                            <input type="submit" value="Gérer les utilisateurs" name="admin" />
                        </form>
                    </div>
                    <?php
                    }
                    ?>
            </header>
            <?php 
                if (isset($_GET["admin"])) {
                    if ($_GET["admin"] == "Gérer les utilisateurs") {
                        include("./rm_user.php");
                    } else if ($_GET["admin"] == "Modification/Suppression de chansons" || $_GET["admin"] == "Modifier" || $_GET["admin"] == "Supprimer") {
                        include("./modify_song_admin.php");
                    } else if($_GET["admin"] == "edit"){
                        include("./edit_song.php");
                    } else {
                        include("./add_song_admin.php");
                    }
                } else {
                    include("./add_song_admin.php");
                }
            ?>
        </main>

        <?php include("./main_footer.php"); ?>

    </body>

    </html>
