<?php
session_start();
//$_SESSION['SavedName']=$_POST['Name'];
// Appel à la base de données pour écrire le message envoyé
try
{
	$db = new PDO('mysql:host=localhost;dbname=heptachat;charset=utf8', 'root', '');
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}
// On y place le nom, message, l'image du profil et la date d'envoi
$req = $db->prepare('INSERT INTO chat(name, msg, image, date) VALUES(?, ?, ?, NOW())');
$req->execute(array($_SESSION['SavedName'],$_POST['Msg'],$_SESSION['UserPicturePath']));

// Redirection
header('Location: chat.php');
?>