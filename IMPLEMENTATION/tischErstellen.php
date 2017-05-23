<?php session_start();?>
<?php

$dsn="mysql:host=ubuntuserver16;dbname=DB_barcode;";
$user="stferfab";
$pass="mypass";

$pdo= new PDO($dsn, $user, $pass);
	
if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    
    
    $tischNr =$_POST['tischNr']; 
	$kapazitaet =$_POST['kapazitaet'];
    
    $result=$pdo->prepare("INSERT INTO Tisch(tischNr, kapazitaet) VALUES (?, ?)");
    $temp=$result->execute([$tischNr,$kapazitaet]);
	
	
	
	  if($temp)
        {
            $message = "Tisch erfolgreich erstellt";
            echo "<script type='text/javascript'>alert('$message');</script>";
        }
        else
        {
                       $message = "Tisch nicht erfolgreich erstellt";
            echo "<script type='text/javascript'>alert('$message');</script>";
        }

	
}
 ?>

 <!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title>Tischinventar</title>

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
		<h5 class="header center orange-text">Tischinventar</h5>
	<br>
    </div>
  </div>
      
	 <div class="row">
	 
		<form class="col s12" action="tischErstellen.php" method="post"> 
		  <div class="row">
			<div class="input-field col s6">
			  <input name="tischNr" id="tischnr" type="number" class="validate" min="0" required >
			  <label for="vorname">Tischnr.</label>
			</div>
			
			<div class="input-field col s6">
			  <input name="kapazitaet" id="kapazitaet" type="number" class="validate" min="0" required>
			  <label for="nachname">Kapazität</label>
			</div>
		  </div>
		  
		   
			
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
