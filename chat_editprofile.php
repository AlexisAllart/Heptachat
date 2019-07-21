<?php
session_start();
date_default_timezone_set('Europe/Paris');

// REDIRECT TO INDEX IF NO ID
if(!isset($_SESSION['id']))
{
  header('index.php');
}


// GET USER NAME FROM ID
try{$db = new PDO('mysql:host=localhost;dbname=heptachat;charset=utf8', 'root', '');}
catch(Exception $e){die('Erreur : '.$e->getMessage());}
$answer = $db->query('SELECT id, pseudo FROM formulaire ORDER BY ID');
while ($data = $answer->fetch())
{
  if ($data['id']==$_SESSION['id']) {$_SESSION['SavedName']=$data['pseudo'];}
}
?>


<!-- Fonction qui permet de recalculer le temps écoulé depuis que chaque message a été posté -->
<?php
function timing ($time)
{
  $time = time() - $time;
  $time = ($time<1)? 1 : $time;
  $tokens = array (
    31536000 => 'an',
    2592000 => 'mois',
    604800 => 'semaine',
    86400 => 'jour',
    3600 => 'heure',
    60 => 'minute',
    1 => 'seconde'
  );
  
  foreach ($tokens as $unit => $text)
  {
    if ($time < $unit) continue;
    $numberOfUnits = floor($time / $unit);
    return $numberOfUnits.' '.$text.(($numberOfUnits>1 && $text!='mois') ? 's':'');
  }
}
?>

<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>HeptaChat</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://fonts.googleapis.com/css?family=Dosis%7CMerriweather&display=swap" rel="stylesheet">
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script src="script.js"></script>
</head>
<body>
  <div id="home" class="all">
    <div class="cols">
      <div class="leftbg">
        <div class="leftcol">
          <div class="leftbtn">
            <img class="profilbtn" src="boutProfil.png" alt="Profil"/>
          </div>
          <p class="username"><?php echo $_SESSION['SavedName'];?></p>
          <div class="profilpic2">
            <!-- Accès à la base de données pour afficher l'image du profil -->
            <?php
            try{$db = new PDO('mysql:host=localhost;dbname=heptachat;charset=utf8', 'root', '');}
            catch(Exception $e){die('Erreur : '.$e->getMessage());}
            $answer = $db->query('SELECT pseudo, image FROM formulaire ORDER BY ID');
            while ($data = $answer->fetch())
            {
              if ($data['pseudo']==$_SESSION['SavedName'])
              {
                /* Affichage de la photo de profil */
                ?>
                <a href="chat.php"><input class="profilimg" type="image" src="<?php echo $data['image'];?>" value="Profil"/></a>
                <?php
                $_SESSION['UserPicturePath']=$data['image'];
              }
            }
            $answer->closeCursor();
            ?>
          </div>
          <div class="linkprofil">
            <a class="txtprofil" href="chat.php">retour</a>
<!--            <a class="txtprofil" href="#profil">supprimer</a> -->
            <a class="txtprofil" href="logout.php">déconnexion</a>
          </div>
        </div>
      </div>
      <div class="middle">
        <div class="uploadblock">
          <form action="profile_imageupload.php" method="post" enctype="multipart/form-data">
              <input type="file" name="file" id="file">
            <div class="buttons">
              <input class="sendbtn" type="image" src="boutmodifB.png" onClick="history.go(0)" Value="Modifier"/>
              <a href="chat.php"><img class="refresh" src="boutAnnulB.png" Value="Annuler"/></a>
            </div>
          </form>
        </div>
      </div>
  <div class="rightbg">
    <div class="rightcol">
      <div class="rightbtn">
        <img class="contactbtn" src="boutContact.png" alt="Contact"/>
      </div>
      <div class="contactlist">
        <div class="contactline">
          <!-- Accès à la base de données pour afficher les images de profil des utilisateurs en ligne -->
          <?php
          try{$db = new PDO('mysql:host=localhost;dbname=heptachat;charset=utf8', 'root', '');}
          catch(Exception $e){die('Erreur : '.$e->getMessage());}
          $answer = $db->query('SELECT pseudo, online, image FROM formulaire ORDER BY ID LIMIT 0,8');
          while ($data = $answer->fetch())
          {
            if ($data['online']==true)
            {
              ?>
              <div class="userline">
                <img class="userpic" src="<?php echo $data['image'];?>"/>
                <div class="userlist"><?php echo htmlspecialchars($data['pseudo']); ?>
                </div>
              </div>
              <?php
            }
          }
          $answer->closeCursor();
          ?>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
</body>
</html>
