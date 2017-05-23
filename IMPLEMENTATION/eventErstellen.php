<?php session_start(); ?>
<?php
include("konfiguration.php");
	
if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    if($_SESSION['bEmail'] == '')//wird überprüft ob eine Session besteht
    header('Location: index.php');
    $temp=false;
    //Daten vom Formular
	$eName =$_POST['eName']; 
	$eOrt =$_POST['eOrt'];
	$eStartZeit =$_POST['eStartZeit'];
	$eEndeZeit =$_POST['eEndeZeit'];
	$eVeranstalter =$_POST['eVeranstalter'];
    
    //SQL-Abfragen
    $result=$pdo->prepare("INSERT INTO Event(eName, eOrt, eStartZeit, eEndeZeit, eVeranstalter) VALUES (?, ?, ?, ?, ?)");
    $temp=$result->execute([$eName,$eOrt, $eStartZeit, $eEndeZeit, $eVeranstalter]);
	
	 if($temp)
        {
            echo "<h3 style='color:green;'>Event erfolgreich erstellt - <a href='index.php'>Zum Login</a></h3>";
        }
        else
        {
            echo "<h3 style='color:red;'>Event konnte nicht erfolgreich erstellt werden - <a href='index.php'>Zum Login</a></h3>";
        }
}
 ?>

 <!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title>Event erstellen</title>

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
		<h5 class="header center orange-text">Event erstellen</h5>
	<br>
    </div>
  </div>
      
	 <div class="row">
	 
		<form class="col s12" action="eventErstellen.php" method="post"> 
		  <div class="row">
              
              <!--Name-->
			<div class="input-field col s6">
			  <input name="eName" id="name" type="text" class="validate" min="0" required >
			  <label for="name">Name</label>
			</div>
              
			<!--Ortschaft-->
			<div class="input-field col s6">
			  <input name="eOrt" id="ort" type="text" class="validate" min="0" required>
			  <label for="ort">Ortschaft</label>
			</div>
		  </div>
		  
		  
		  <div class="row">
              
              <!--Beginn-->
			<div class="input-field col s6">
			  <input name="eStartZeit" id="startdatum" type="datetime-local" class="datepicker" required>
			  <label for="startdatum" style="margin-left: 65%;" > Beginn </label>
			</div>
			
              <!--Ende-->
			<div class="input-field col s6">
			  <input name="eEndeZeit" id="enddatum" type="datetime-local" class="datepicker" required >
			  <label for="enddatum" style="margin-left: 65%;"> Ende </label>
			</div>
			
			</div>
			
		
		  
		    <div class="row">
                
                <!--Veranstalter-->
			<div class="input-field col s6">
			  <input name="eVeranstalter" id="veranstalter" type="text" class="validate" min="0" required>
			  <label for="veranstalter">Veranstalter</label>
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
