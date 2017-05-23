<?php session_start(); ?>
<?php

include("konfiguration.php");

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    
    if($_SESSION['bEmail'] == '') //wird überprüft ob eine Session besteht
    header('Location: index.php');
    $temp=false;                  //temp ist das resultat der SQL-Abfragen und wird auf false gesetzt um voreilige Ausgaben zu verhindern

    // Daten vom Formular
    $gIN = 0;       
    $adminEmail= $_SESSION['bEmail']; 
    $barcode = $_POST["barcode"];
    $vorname= $_POST["vorname"];
    $nachname= $_POST["nachname"]; 
    $geburtsDatum= $_POST["geburtsDatum"];
    $phpdate = strtotime($geburtsDatum);
    $geburtsDatum = date( 'Y-m-d', $phpdate );     
    $tischNr = $_POST["tisch"];    
    $gast_eID= $_POST["event"];
    
    //SQL-Insert der Daten   
    $result= $pdo->prepare("INSERT INTO Gast(barcode, vorname, nachname, geburtsDatum, gIN, tischNr, bEmail, eID) VALUES(?, ?, ?, ?, ?, ?, ?, ?)");
	
    $temp = $result->execute([$barcode, $vorname, $nachname, $geburtsDatum, $gIN, $tischNr, $adminEmail, $gast_eID]);
	
    //Ausgabe des Ergebnis der SQL-Abfrage
    if($temp){
        
		echo "<h3 style='color:green;'>Gast wurde erfolgreich hinzugefügt.</h3>";
	}else{
		echo "<h3 style='color:red;'>Gast konnte nicht hinzugefügt werden</h3>";
	} 
                           
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title>Gast erstellen</title>

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
		<h5 class="header center orange-text">Gast erstellen</h5>
	<br>
    </div>
  </div>
      
	 <div class="row">
	 <!--Formular-->
		<form class="col s12" action="gastErstellen.php" method="post"> 
		  <div class="row">
              
              <!--Vorname-->
			<div class="input-field col s6">
			  <input name="vorname" id="vorname" type="text" class="validate" required>
			  <label for="vorname">Vorname</label>
			</div>
              
			<!--Nachname-->
			<div class="input-field col s6">
			  <input name="nachname" id="nachname" type="text" class="validate" required>
			  <label for="nachname">Nachname</label>
			</div>
		  </div>
		  
            <!--Geburtsdatum-->
		   <div class="row">
				<div class="input-field col s6">
				  <input name="geburtsDatum" id="geburtsDatum" type="date" class="datepicker" required>
				</div>
				
               <!--Barcode-->
				<div class="input-field col s6">
				  <input  name="barcode" id="barcode" type="number" class="validate" min="0" required>
				  <label for="barcode">Barcode</label>
				</div>
		  </div>
		 
            <!--Tisch-->
		  <div class="row">
			<div class="row col s6">
               <select name="tisch">
                  <?php 	
                        
                        foreach ($pdo->query("SELECT * FROM getTische") as $row) 
                        {
                            if($row['besetzt'] >=$row['kapazitaet'])
                                    {
                                        echo '<option value="' . $row['tischNr'] . '" disabled selected>Tisch NR: ' . $row['tischNr'] . ' ist Vollbesetzt</option>';

                                    }else
                                    {
                                        echo '<option value="' . $row['tischNr'] . '">Tisch NR: ' . $row['tischNr'] . '</option>';
                                    }  
                                
                            }                              
			         ?>
                <option value="" disabled selected>Tischnummer</option>
               </select>  
		  </div>

              <!--Event-->
			<div class="row col s6">
               <select name= "event" required>
                  <option value="" disabled selected>Event</option>
                   <?php 	
                        foreach ($pdo->query("SELECT eName, eID FROM Event WHERE DATEDIFF(eStartZeit, NOW()) >=0") as $row) 
                        {
                               echo '<option value="' . $row['eID'] . '">' . $row['eName'] . '</option>';
                        }         

			     ?>
               </select>  
		  </div>
              
        </div>
			
            
			<input type="submit" class="waves-effect waves-light btn" onClick="fktCheckPass()" value="Erstellen"/>
			</form>
			
  </div>
        
		
  <footer class="page-footer orange">
    
  </footer>

  

  <!--  Scripts-->
  <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
  <script src="js/materialize.js"></script>
  <script src="js/init.js"></script>
  <script src="js/script.js"></script>
  <script>
				   $(document).ready(function() {
					$('select').material_select();
				  });
			</script>

  </body>
</html>
