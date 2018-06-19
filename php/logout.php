
<?php

session_start();



require("./param.inc.php");
$pdo = new PDO("mysql:host=".MYHOST.";dbname=".MYDB, MYUSER, MYPASS);
$pdo->query("SET NAMES utf8");
$pdo->query("SET CHARACTER SET 'utf8'");

$requeteSQL = "UPDATE MEMBRES SET isConnect = '0' WHERE MEMBRES.idMbr = '".$_SESSION["id"]."'";
$statement = $pdo->query($requeteSQL);

$_SESSION = array();
session_destroy();

header("Location: index.php");

?>
