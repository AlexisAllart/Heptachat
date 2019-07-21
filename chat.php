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
          <div class="profilpic">
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
                <a href="chat_editprofile.php"><img class="profilimg" type="image" src="<?php echo $data['image'];?>" value="Profil"/></a>
                <?php
                $_SESSION['UserPicturePath']=$data['image'];
              }
            }
            $answer->closeCursor();
            ?>
          </div>
          <div class="linkprofil">
            <a class="txtprofil" href="chat_editprofile.php">modifier</a>
<!--            <a class="txtprofil" href="#profil">supprimer</a> -->
            <a class="txtprofil" href="logout.php">déconnexion</a>
          </div>
        </div>
      </div>
      <div class="middle">
        <div id="textscroll" class="chat">
          <!-- On refait appel à la base de données pour afficher la partie interactive du chat -->
          <?php
          try{$db = new PDO('mysql:host=localhost;dbname=heptachat;charset=utf8', 'root', '');}
          catch(Exception $e){die('Erreur : '.$e->getMessage());}
          $answer = $db->query('SELECT name, msg, date, image FROM chat ORDER BY ID');
          while ($data = $answer->fetch())
          {
            /* On vérifie si le nom de l'utilisateur correspond à celui du(des) messages affiché(s) afin de choisir de quel côté on l'(les) affiche - l'utilisateur voit ses messages à gauche, et ceux des autres à droite*/
            if ($data['name']!=$_SESSION['SavedName'])
            {
              ?>
              <div class="rightall"><div class="userpicnameright"><img class="chatpic" src="<?php echo $data['image'];?>"/>
              <strong class="diffname"><?php echo htmlspecialchars($data['name']); ?></strong></div>
              <?php echo htmlspecialchars($data['msg']);?><br/>
              <em class="timechat"><?php echo htmlspecialchars('(il y a '.timing(strtotime($data['date'])).')');?></em>
            </div>
            <br/>
            <?php
          }
          else
          {
            ?>
            <div class="leftall"><div class="userpicnameleft"><img class="chatpic" src="<?php echo $data['image'];?>"/>
            <strong class="samename"><?php echo htmlspecialchars($data['name']); ?></strong></div>
            <?php echo htmlspecialchars($data['msg']);?><br/>
            <em class="timechat"><?php echo htmlspecialchars('(il y a '.timing(strtotime($data['date'])).')');?></em>
          </div>
          <br/>
          <?php
        }
      }
      $answer->closeCursor();
      ?>
    </div>
    <form id="form" action="chat_post.php" method="post">
      <!-- Le message ne peut être envoyé en appuyant sur ENTER avec un textarea, et l'utilisation d'un <input> de type texte était impossible; on utilise donc un script jquery qui validera l'envoi au moment où l'utilisateur appuiera sur ENTER -->
      <textarea class="textinput" id="text" style="resize:none;" rows="4" cols="5" name="Msg" placeholder="Entrez votre message ici..." autofocus required></textarea><br/>
      <div class="buttons">
        <input class="sendbtn" type="image" src="boutEnvoiB.png" value="Envoyer"/>
        <input class="refresh" type="image" src="boutActualB.png" onClick="history.go(0)" Value="Actualiser"/>
      </div>
    </form>
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
