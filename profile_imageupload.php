<?php
// BEGIN GET USERID TEMP BECAUSE BASED ON NAME
session_start();
/*$_SESSION['SavedName']="";
try{$db = new PDO('mysql:host=localhost;dbname=heptachat;charset=utf8', 'root', '');}
catch(Exception $e){die('Erreur : '.$e->getMessage());}
$answer = $db->query('SELECT id, pseudo FROM formulaire ORDER BY ID');
while ($data = $answer->fetch())
{
  if ($data['pseudo']==$_SESSION['SavedName'])
  {
     $id=$data['id'];
  }
}
$answer->closeCursor();*/
// END GET USERID TEMP BECAUSE BASED ON NAME

// GET UPLOADED FILE INTO $file
$id=$_SESSION['id'];
$file=$_FILES['file'];
$size=$_FILES['size'];

$name=$file['name'];
$tmp_name = $_FILES['file']["tmp_name"];
$username=$_SESSION['SavedName'];
$path="ProfilePics/".basename($id).".jpg";
// CHECK FILE EXTENSION (=JPG)
$ext = pathinfo($name, PATHINFO_EXTENSION);
if($size<2097152)
{
  if($ext=='jpg')
  {
    $result = move_uploaded_file($tmp_name,$path);
    if ($result) {$_SESSION['uploaderrormsg']="Transfert réussi !";}
    else {$_SESSION['uploaderrormsg']="Transfert échoué";}
    try
    {
  	  $db = new PDO('mysql:host=localhost;dbname=heptachat;charset=utf8', 'root', '');
    }
    catch(Exception $e)
    {
      die('Erreur : '.$e->getMessage());
    }
    $req = $db->query("UPDATE formulaire SET image='".$path."' WHERE pseudo='$username'");
  }
  else
  {
    $_SESSION['uploaderrormsg']="Transfert échoué";
  }
}
else
{
  $_SESSION['uploaderrormsg']="Transfert échoué - trop volumineux";
}
header("location:chat_editprofile.php");
?>