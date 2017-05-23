<?php  session_start(); ?>
<?php
include("konfiguration.php");


if($_SERVER["REQUEST_METHOD"] == "POST")
{
   
if($_SESSION['bEmail'] == '') //wird überprüft ob eine Session besteht
    header('Location: index.php');
    $temp=false;            //temp ist das resultat der SQL-Abfragen und wird auf false                             gesetzt um voreilige Ausgaben zu verhindern
    
// Daten vom Formular
$bEmail =$_POST['bEmail']; 
$password1 =$_POST['password1'];
$password2 =$_POST['password2'];
$vorname =$_POST['vorname']; 
$nachname =$_POST['nachname']; 
$typ =$_POST['typ']; 
    

    
if($password1 != $password2) //Passwörter werden überprüft
    {
            
           $message = "Passwörter stimmen nicht überein!";
            echo "<script type='text/javascript'>alert('$message');</script>";
    }
    else
    {
        
    
    $password1 =md5($password1); // Passwort mit MD5 gehasht

     //SQL-Abfrage zum einfügen des Benutzers  
    $result=$pdo->prepare("INSERT INTO Benutzer(bEmail,passwort,vorname,nachname, typ) VALUES (?, ?, ?, ?, ?)");
    $temp=$result->execute([$bEmail, $password1, $vorname, $nachname, $typ]);


        // Bestätigung der SQL-Abfrage
        if($temp)
        {
            $message = "Registrierung erfolgreich!";
            echo "<script type='text/javascript'>alert('$message');</script>";
        }
        else
        {
            $message = "Registrierung fehlgeschlagen";
            echo "<script type='text/javascript'>alert('$message');</script>";
        }
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title>Benutzer erstellen</title>

  <!-- CSS  -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
</head>
<body>


  <nav class="light-blue">
    <div class="nav-wrapper container">
	
		<a href="index.php">
          <span class="glyphicon glyphicon-log-out"></span>
    </a>
	
	<a id="logo-container" class="brand-logo center">easyScan</a>
    </div>
  </nav>
  
  <div class="section no-pad-bot" id="index-banner">
    <div class="container">
	<br>
		<h5 class="header center orange-text">Benutzer erstellen</h5>
	<br>
    </div>
  </div>
      
    
    <div class="row">
		<form class="col s12" action="benutzerErstellen.php" method="post"> 
            
            <!-- Vorname -->
		  <div class="row">
			<div class="input-field col s6">
			  <input name="vorname" id="vorname" type="text" class="validate" required>
			  <label for="vorname">Vorname</label>
			</div>
              
			<!-- Nachname -->
			<div class="input-field col s6">
			  <input name="nachname" id="nachname" type="text" class="validate" required>
			  <label for="nachname">Nachname</label>
			</div>
		  </div>
		  
            <!-- Email -->
		   <div class="row">
			<div class="input-field col s12">
			  <input name="bEmail" id="bEmail" type="email" class="validate" required>
			  <label for="bEmail">Email</label>
			</div>
		  </div>
            
		 <!-- Password -->
		  <div class="row">
			<div class="input-field col s6">
			  <input name="password1" id="password1" type="password" class="validate" required>
			  <label for="password1">Password</label>
			</div>

        <!-- Passwordbestätigung -->
			<div class="input-field col s6">
			  <input name="password2" id="password2" type="password" class="validate" required>
			  <label for="password2">Password bestätigen</label>
			</div>
		  </div>
            
        <!-- Radio -->
			<p>
			  <input name="typ" type="radio" id="admin" value=1 required />
			  <label for="admin">Admin</label>
			</p>
			<p>
			  <input name="typ" type="radio" id="angestellte" value=2 required />
			  <label for="angestellte">Angestellte</label>
			</p>
			
			<p>
			  <input name="typ" type="radio" id="anwender" value=3 checked required />
			  <label for="anwender">Anwender</label>
			</p>
			
			<input type="submit" class="waves-effect waves-light btn" value="Erstellen"/>
        </form>
  </div>
        	
	  
  <footer class="page-footer orange">
    
  </footer>

  

  <!--  Scripts-->
  <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
  <script src="js/materialize.js"></script>
  <script src="js/init.js"></script>
  <script src="js/script.js"></script>

  </body>
</html>
