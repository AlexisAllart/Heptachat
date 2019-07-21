<?php
session_start();
try{$db = new PDO('mysql:host=localhost;dbname=heptachat;charset=utf8', 'root', '');}
catch(Exception $e){die('Erreur : '.$e->getMessage());}
$answer = $db->query('SELECT MAX(id) FROM formulaire');
while ($data = $answer->fetch())
{
  $lastID=$data;
}

//Les conditions permettant de savoir si notre utilisateur entre de bonnes données quand il appuyera sur le bouton Inscription
  if(isset($_POST["formulaireinscription"])){
      
    //Maintenant regardons si tous les champs ont été complétés
    if(!empty($_POST["pseudo"]) AND !empty($_POST["mail"]) AND !empty($_POST["mail2"]) AND !empty($_POST["mdp"]) AND !empty($_POST["mdp2"])){

      //Ici on simplifie et on sécurise nos variables
      //htmlspecialchars évite les injection de code, et sha1 sécurise et crypte le mot de passe
      $pseudo = htmlspecialchars($_POST["pseudo"]); 
      $mail = htmlspecialchars($_POST["mail"]);
      $mail2 = htmlspecialchars($_POST["mail2"]);
      $mdp = sha1($_POST["mdp"]);
      $mdp2 = sha1($_POST["mdp2"]);
      
      //Si le pseudo est plus petit que 255 caractères
      $pseudolenght = strlen($pseudo);
      if ($pseudolenght <= 255){

        //Vérification de l'adreese mail (mail et mail2) du mot de passe (mdp et mdp2), en respectant l'indentation
        if($mail == $mail2){
          //On utilise la fonction pré-définie filter_var sur la variable mail, si les 2 correspondent, on en filtre une seule et FILTER_VALIDATE_EMAIL permet de voir s'il s'agit bien d'un email. Si c'est bon c'est Ok, sinon, on fait un else. C'est juste une question de sécurité car si un utilisateur connait le HTML, il peut aller dans le code source de la page, changer la valeur email en text dans la balise input et entrer ce qu'il souhaite
          if(filter_var($mail, FILTER_VALIDATE_EMAIL)){
            //Si le mail existe déjà
            //1. On prépare
            $bdd = new PDO("mysql:host=127.0.0.1;dbname=heptachat", "root", "");
            $reqmail = $bdd->prepare("SELECT * FROM formulaire WHERE email = ?");

            //2. On exécute
            $reqmail->execute(array($mail));
            $mailexist = $reqmail->rowCount(); // vérifie si le mail existe déjà dans la base de données
            $reqmail->closeCursor();
            if($mailexist == 0){ //Si le mail n'existe pas, c'est bon

              if($mdp == $mdp2){
                $bdd = new PDO("mysql:host=127.0.0.1;dbname=heptachat", "root", "");

                //Si tout est parfait, on fait un insert into et on met une fonction qui permet d'inscrire l'utilisateur et les valeurs
                $insertmbr = $bdd->prepare("INSERT INTO formulaire(pseudo, email, mdp, online, image) VALUES (?, ?, ?, ?, ?)");
                //Ici, on execute la fonction avec un tableau dans lequel on insère les différentes valeurs
                $insertmbr->execute(array($pseudo, $mail, $mdp, 1, "ProfilePics/".($lastID[0]+1).".jpg"));
                $srcfile='ProfilePics/0.jpg';
                $destfile='ProfilePics/'.($lastID[0]+1).'.jpg';
                copy($srcfile, $destfile);
                $erreur = "Votre compte a bien été créé";
               
                // On récupération de l'ID de l'utilisateur enregistré
                try{$db = new PDO('mysql:host=localhost;dbname=heptachat;charset=utf8', 'root', '');}
                catch(Exception $e){die('Erreur : '.$e->getMessage());}
                $answer = $db->query('SELECT id, pseudo FROM formulaire ORDER BY ID');
                while ($data = $answer->fetch())
                {
                  if ($data['pseudo']==$pseudo) {$_SESSION['id']=$data['id'];}
                }
                if(isset($_SESSION['id']))
                {
                  header('Location: chat.php');
                }
                else
                {
                  header('Location: index.php');
                }
                // Fin de la récupération
              }
              else{
                $erreur = "Vos mots de passe ne correspondent pas";
              }
            }
            else{
              $erreur = "Adresse email déjà utilisée";
            }
          }
          else{
            $erreur = "Votre adresse mail n'est pas valide";
          }
        }
        else{
          $erreur ="Vos adresses mail ne correspondent pas !";
        }
        
      }
      else{
        $erreur = "Votre pseudo ne doit pas dépasser 255 caractères";
      }
    }
    else{ //Si les champs ne sont pas tous complets. Suite de tests, de conditions
      $erreur = "Tous les champs doivent être complétés";
      
    }
  }
?>

<!DOCTYPE html>
<html>
	<head>
  		<title>HeptaChat</title>
  		<meta charset="utf-8">
  		<link rel="stylesheet" type="text/css" href="testAnimation.css">
  		<link rel="stylesheet" type="text/css" href="Heptachat.css">
	</head>
	<body>
<!-- The parent component -->
<div class="curtain">   
    <!-- The component wrapper -->
	<div class="curtain__wrapper">   
   		<!-- The checkbox hack! -->
    		<!-- The left curtain panel -->
    		<div class="curtain__panel1 curtain__panel--left">
   			</div> <!-- curtain__panel -->
    		<!-- The prize behind the curtain panels -->
    		<div class="curtain__prize">
            <div id="login-box">
    		      <img src="HeptaChatLogoPetit.png" alt="HeptaChatLogoPetit" id="logo">
    			    <h1>Inscription</h1>
              <form method="POST" action="">
  				        <input type="text" name="pseudo" id="pseudo" placeholder="Votre pseudo" value="<?php if(isset($pseudo)){ echo $pseudo;} ?>"> <!--Pour enregistrer le pseudo sur la page, pour le garder lisible s'il y a une erreur-->	
        					<input type="text" name="mail" id="mail" placeholder="Votre email" value="<?php if(isset($mail)){ echo $mail;} ?>"><!--Pour enregistrer l'email sur la page, pour le garder lisible s'il y a une erreur-->
        					<input type="text" name="mail2" id="mail2" placeholder="Confirmation de votre email" value="<?php if(isset($mail2)){ echo $mail2;} ?>"> <!--Pour enregistrer la confirmation de l'email sur la page, pour le garder lisible s'il y a une erreur-->
        					<input type="password" name="mdp" id="mdp" placeholder="Mot de passe">
        					<input type="password" name="mdp2" id="mdp2" placeholder="Confirmation de votre mot de passe">
                  <div class="image">
                      <input type="submit" name="formulaireinscription" value="Inscription">
                  </div>
              </form>
             <?php
                //On renvoie ici la variable erreur si tous les champs ne sont pas complétés
                if(isset($erreur)){
                  echo $erreur;
                }
                ?>
            </div> <!-- login-box --> 
    		</div> <!-- curtain__prize -->
   			<!-- The right curtain panel -->
    		<div class="curtain__panel2 curtain__panel--right">
    		</div> <!-- curtain__panel -->
  	</div> <!-- curtain__wrapper -->
  </div> <!-- curtain -->
	</body>
</html>