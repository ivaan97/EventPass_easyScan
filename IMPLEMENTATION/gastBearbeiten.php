<?php session_start(); ?>
<?php

include("konfiguration.php");


 $temp=false;
if($_SERVER["REQUEST_METHOD"] == "POST")
{
    
    //if($_SESSION['bEmail'] == '') //wird überprüft ob eine Session besteht
    //header('Location: login.php');
                     //temp ist das resultat der SQL-Abfragen und wird auf false gesetzt um voreilige Ausgaben zu verhindern

    // Daten vom Formular
    $gIN = 0;       
    $adminEmail= "admin@info.com" ;
    //$adminEmail= $_SESSION['bEmail']; 
    $barcode = $_POST["barcode"];
    $vorname= $_POST["vorname"];
    $nachname= $_POST["nachname"]; 
    $geburtsDatum= $_POST["geburtsDatum"];
        $phpdate = strtotime($geburtsDatum);
        $geburtsDatum = date( 'Y-m-d', $phpdate );     
    $tischNr = $_POST["tisch"];    
    $gast_eID= $_POST["event"];
    
   //SQL-Abfragen der Daten 
    
    //Suche
    $search = $_POST["suche"];
    
    
    //Delete
    
    $delete = $_POST['del'];
   if(isset($_POST['del']))
   {
       $deleteTemp=false;
        $result= $pdo->prepare("DELETE FROM Gast WHERE barcode = ?");
                    $deleteTemp = $result->execute([$delete]);
        
        if($deleteTemp)
        {
             $message = "Gast wurde erfolgreich gelöscht";
                echo "<script type='text/javascript'>alert('$message');</script>";
        }
        else
        {
             $message = "Gast wurde nicht erfolgreich gelöscht";
                echo "<script type='text/javascript'>alert('$message');</script>";
        }
   }
    
    $info = $_POST['info'];
    if(isset($_POST['info']))
   {
       $selectTemp=false;
        $result= $pdo->prepare("SELECT gast.barcode as gBarcode, gast.vorname as gVorname, gast.nachname as gNachname, gast.geburtsDatum as gGeburtsDatum ,gast.tischNr as gTischNr, benutzer.vorname as bVorname, benutzer.nachname as bNachname, event.* FROM Gast as gast NATURAL JOIN Event as event JOIN  Benutzer as benutzer ON (gast.bEmail = benutzer.bEmail)  WHERE barcode = ?");
        $selectTemp = $result->execute([$info]);
        $infoGast = $result->fetch();
        
        if(!$selectTemp)
        {
             $message = "Es ist ein Fehler beim ausgeben des Gastes aufgetreten";
                echo "<script type='text/javascript'>alert('$message');</script>";
        }
   }
    
    if(isset($barcode))
    {
        
        
                 //Update
                    $result= $pdo->prepare("UPDATE Gast SET  vorname = ?, nachname = ?, geburtsDatum = ?, gIN = ?, tischNr= ?, bEmail = ?, eID = ? WHERE barcode = ?");
                    $updateTemp = $result->execute([$vorname, $nachname, $geburtsDatum, $gIN, $tischNr, $adminEmail, $gast_eID, $barcode]);

        //Ausgabe des Ergebnis der SQL-Abfrage
        if($updateTemp){

           $message = "Gast wurde erfolgreich bearbeitet";
            echo "<script type='text/javascript'>alert('$message');</script>";

        }else{
            $message = "Gast konnte nicht bearbeitet werden!";
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
  <title>Gast Verwalten</title>

  <!-- CSS  -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
</head>
<body>

  <nav class="light-blue">
    <div class="nav-wrapper container">
	<a id="logo-container" class="brand-logo center">easyScan</a>
    </div>
  </nav>
  
  <div class="section no-pad-bot" id="index-banner">
    <div class="container">
	<br>
		<h5 class="header center orange-text">Gast Löschen</h5>
	<br>
    </div>
  </div>
  
  <br>
  
	<div class ="row" >
		<form method="post" action="gastBearbeiten.php">
		  <input type="text" id="search" name="search" style="visibility: hidden" />
            <!--Search-->
		<div class="input-field col s6">
			 <input name="suche" id="suche" type="text" class="validate" >
			 <label for="suche">Suchbegriff</label>
		</div>
		
		<div class="row col s6">
			<input type="submit" class="waves-effect waves-light btn" value="suchen"/>
		</div>
		</form>
	</div>
      
	  
	  <!--Gäste-->
		  <div class="row">
              <form method ="post" action="gastBearbeiten.php">
			<div class="row col s6">
			
               <select name="del">
                   <?php 	
                       if(isset($search))
                           {

                               foreach ($pdo->query('SELECT * FROM Gast WHERE vorname LIKE "%' . $search . '%" OR nachname LIKE "%' . $search . '%" OR barcode LIKE "%' . $search . '%" OR bEmail LIKE "%' . $search . '%" OR geburtsDatum LIKE "%' . $search . '%" ORDER BY vorname, nachname, bEmail, barcode, eID') as $row) 
                                { 
                                        echo '<option value="' . $row['barcode'] . '" >' . $row['vorname'] . ' ' . $row['nachname'] . '</option>';

                                } 
                             $_POST['suche'] = "";
                           }
                        else
                            {
                             
                            foreach ($pdo->query('SELECT barcode, vorname, nachname FROM Gast ORDER BY vorname, nachname, bEmail, barcode') as $row) 
                                { 
                                        echo '<option value="' . $row['barcode'] . '" >' . $row['vorname'] . ' ' . $row['nachname'] . '</option>';

                                } 
                             $_POST['suche']= "";
                            }
                 
						
			         ?>
                <option value="" disabled selected>Gäste</option>
                   
			   </select>  
                </div>
                 <div class="row col s6">
                     <input  type="submit" class="waves-effect waves-light btn"  value="löschen"/>
                  </div>
			</form>
		  
              
            
	  <br>
		<br>
		<br>
	
	  <nav class="light-blue">
		<div class="nav-wrapper container">
			<a id="logo-container" class="brand-logo center">Gast bearbeiten</a>
		</div>
	</nav>
  <br>


	 <div class="row">
	 <!--Formular-->
		<form class="col s12" action="gastBearbeiten.php" method="post"> 
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
			<input type="submit" class="waves-effect waves-light btn" value="Bearbeiten"/>
			</form>
  </div>
          
	</div>		

	
	<nav class="light-blue">
		<div class="nav-wrapper container">
			<a id="logo-container" class="brand-logo center">Gastinformationen</a>
		</div>
	</nav>
	
	<br><br>
	
	<div class="row">
		<form method ="post" action="gastBearbeiten.php">
			<div class="row col s6">
				   <select name="info">
					   <?php 	
                       if(isset($search))
                           {

                               foreach ($pdo->query('SELECT * FROM Gast WHERE vorname LIKE "%' . $search . '%" OR nachname LIKE "%' . $search . '%" OR barcode LIKE "%' . $search . '%" OR bEmail LIKE "%' . $search . '%" OR geburtsDatum LIKE "%' . $search . '%" ORDER BY vorname, nachname, bEmail, barcode, eID') as $row) 
                                { 
                                        echo '<option value="' . $row['barcode'] . '" >' . $row['vorname'] . ' ' . $row['nachname'] . '</option>';

                                } 
                           }
                        else
                            {
                             
                            foreach ($pdo->query('SELECT barcode, vorname, nachname FROM Gast ORDER BY vorname, nachname, bEmail, barcode') as $row) 
                                { 
                                        echo '<option value="' . $row['barcode'] . '" >' . $row['vorname'] . ' ' . $row['nachname'] . '</option>';

                                } 
                            
                            }
						
			         ?>
					<option value="" disabled selected>Gäste</option>
				   </select> 
			</div> 
            <div class="row col s6">
			<input type="submit" class="waves-effect waves-light btn" value="bestätigen"/>
		
			</div>
        </form>
			

	</div>
	<div class="infoContainer" >

		
		<div class="infoBox">
			<ul style="margin-top: 0px;">
                <?php
                // PROBLEME
                echo'<li>Barcode: ' . $infoGast['gBarcode'] . '</li>
                    <li>Name: ' . $infoGast['gVorname'] . '</li>
                    <li>Nachname: ' . $infoGast['gNachname'] . '</li>
                    <li>Geburtsdatum: ' . $infoGast['gGeburtsDatum'] . '</li>
                    <li>Event: ' . $infoGast['eName'] . '</li>
                    <li>Tischnummer: ' . $infoGast['gTischNr'] . '</li>
                    <li>Kartenverkäufer: ' . $infoGast['bVorname'] . ' ' . $infoGast['bNachname'] . '</li>';
                ?>
			</ul>
		</div>	
		
		<div class="ageBox">
			
		</div>
			
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
