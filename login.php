<?php
session_start();
$bdd = new PDO("mysql:host=127.0.0.1;dbname=heptachat", "root", "");


//Les conditions permettant de savoir si notre utilisateur entre de bonnes données quand il appuyera sur le bouton Inscription
if(isset($_POST["connectform"]))
{     
    //Maintenant regardons si tous les champs ont été complétés
    if(!empty($_POST["pseudo"]) && !empty($_POST["mdp"]))
    {
        //Ici on simplifie et on sécurise nos variables
        //htmlspecialchars évite les injection de code, et sha1 sécurise et crypte le mot de passe
        $pseudo = htmlspecialchars($_POST["pseudo"]); 
        $mdp = sha1($_POST["mdp"]);
      
        //Si le pseudo est plus petit que 255 caractères
        $pseudolenght = strlen($pseudo);
        if ($pseudolenght <= 255)
        {
            try{$db = new PDO('mysql:host=localhost;dbname=heptachat;charset=utf8', 'root', '');}
            catch(Exception $e){die('Erreur : '.$e->getMessage());}
            $answer = $db->query('SELECT * FROM formulaire ORDER BY ID');
            while ($data = $answer->fetch())
            {
                if ($pseudo==$data['pseudo'] && $mdp==$data['mdp'])
                {
                    $_SESSION['id']=$data['id'];
                }
            }
            if(isset($_SESSION['id']))
            {
                header('Location: chat.php');
            }
            else
            {
                $erreur = "Identifiant ou mot de passe invalide(s)";
            }
        }
        else 
        {
            $erreur = "Votre pseudo ne doit pas dépasser 255 caractères";
        }
    }
    else
    {
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
    			    <h1>Connexion</h1>
              <form method="POST" action="">
  				        <input type="text" name="pseudo" id="pseudo" placeholder="Votre pseudo" value="<?php if(isset($pseudo)){ echo $pseudo;} ?>"> <!--Pour enregistrer le pseudo sur la page, pour le garder lisible s'il y a une erreur-->	
       					<input type="password" name="mdp" id="mdp" placeholder="Mot de passe">
                  <div class="image">
                      <input type="submit" name="connectform" value="Connexion">
                  </div>
              </form>
                <p class="errormsg">
             <?php
                //On renvoie ici la variable erreur si tous les champs ne sont pas complétés
                if(isset($erreur)){
                  echo $erreur;
                }
                ?> 
                </p><!-- message d'erreur -->
            </div> <!-- login-box --> 
    		</div> <!-- curtain__prize -->
   			<!-- The right curtain panel -->
    		<div class="curtain__panel2 curtain__panel--right">
    		</div> <!-- curtain__panel -->
  	</div> <!-- curtain__wrapper -->
  </div> <!-- curtain -->
	</body>
</html>