
<?php session_start();?>
<?php


include('konfiguration.php');


session_start();
$dsn="mysql:host=ubuntuserver16;dbname=DB_barcode;";
$user="stferfab";
$pass="mypass";
 
$pdo= new PDO($dsn, $user, $pass);
 $temp=false;
if($_SERVER["REQUEST_METHOD"] == "POST")
{
    
    if($_SESSION['bEmail'] == '') //wird überprüft ob eine Session besteht
    header('Location: index.php');
                     //temp ist das resultat der SQL-Abfragen und wird auf false gesetzt um voreilige Ausgaben zu verhindern

    // Daten vom Formular     
    $adminEmail= $_SESSION['bEmail']; 
    $eName =$_POST['eName']; 
	$eOrt =$_POST['eOrt'];
	$eStartZeit =$_POST['eStartZeit'];
	$eEndeZeit =$_POST['eEndeZeit'];
	$eVeranstalter =$_POST['eVeranstalter'];
    $eID=$_POST['eID'];
    
   
	
    
   //SQL-Abfragen der Daten 
    
    //Suche
    $search = $_POST["suche"];
    
    
    //Delete
    
    $delete = $_POST['del'];
   if(isset($_POST['del']))
   {
       $deleteTemp=false;
        $result= $pdo->prepare("DELETE FROM Event WHERE eID = ?");
                    $deleteTemp = $result->execute([$delete]);
        
        if($deleteTemp)
        {
             $message = "Event wurde erfolgreich gelöscht";
                echo "<script type='text/javascript'>alert('$message');</script>";
        }
        else
        {
             $message = "Event wurde nicht erfolgreich gelöscht";
                echo "<script type='text/javascript'>alert('$message');</script>";
        }
   }
    
    $info = $_POST['info'];
    if(isset($_POST['info']))
   {
       $selectTemp=false;
        $result= $pdo->prepare("SELECT eID, eName, date(eStartZeit) as eStartDatum, date(eEndeZeit) as eEndeDatum, time(eStartZeit) as eAnfangsZeit, time(eEndeZeit) as eSchlussZeit, eOrt, eVeranstalter FROM Event NATURAL JOIN getGaeste WHERE eID = ?");
        $selectTemp = $result->execute([$info]);
        $infoEvent = $result->fetch();
        
        if(!$selectTemp)
        {
             $message = "Es ist ein Fehler beim ausgeben des Events aufgetreten";
                echo "<script type='text/javascript'>alert('$message');</script>";
        }
        
   }
    
    if(isset($eID))
    {
        
        
                 //Update
                    $result= $pdo->prepare("UPDATE Event SET  eName = ?, eOrt = ?, eStartZeit = ?, eEndeZeit = ?, eVeranstalter = ? WHERE eID = ?");
                
                    $updateTemp=$result->execute([$eName,$eOrt, $eStartZeit, $eEndeZeit, $eVeranstalter, $eID]);

        //Ausgabe des Ergebnis der SQL-Abfrage
        if($updateTemp){

           $message = "Event wurde erfolgreich bearbeitet";
            echo "<script type='text/javascript'>alert('$message');</script>";

        }else{
            $message = "Event konnte nicht bearbeitet werden!";
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
  <title>Event Verwalten</title>

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
		<h5 class="header center orange-text">Event Löschen</h5>
	<br>
    </div>
  </div>
  
  <br>
  
	<div class ="row" >
		<form method="post" action="eventBearbeiten.php">
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
      
	  
	  <!--Events-->
		  <div class="row">
              <form method ="post" action="eventBearbeiten.php">
			<div class="row col s6">
			
               <select name="del">
                   <?php 	
                       if(isset($search))
                           {

                               foreach ($pdo->query('SELECT * FROM Event WHERE eName LIKE "%' . $search . '%" OR eID LIKE "%' . $search . '%" OR eOrt LIKE "%' . $search . '%" OR eVeranstalter LIKE "%' . $search . '%" OR eStartZeit LIKE "%' . $search . '%" OR eEndeZeit LIKE "%' . $search . '%" ORDER BY eID, eName, eStartZeit') as $row) 
                                { 
                                        echo '<option value="' . $row['eID'] . '" >' . $row['eName'] . '</option>';

                                } 
                             $_POST['suche'] = "";
                           }
                        else
                            {
                             
                             foreach ($pdo->query('SELECT eID, eName FROM Event ORDER BY eID, eName') as $row) 
                                { 
                                        echo '<option value="' . $row['eID'] . '" >' . $row['eName'] . '</option>';

                                } 
                            
                             $_POST['suche']= "";
                            }
                 
						
			         ?>
                <option value="" disabled selected>Events</option>
                   
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
			<a id="logo-container" class="brand-logo center">Event bearbeiten</a>
		</div>
	</nav>
  <br>


<div class="row">
	 
		<form class="col s12" action="eventBearbeiten.php" method="post"> 
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
                 <!--EID-->
			<div class="input-field col s6">
			  <input name="eID" id="eID" type="number" class="validate" min="0" required >
			  <label for="eID">Event ID</label>
			</div>
			
			
		  </div>
		  
		   
			
			<input type="submit" class="waves-effect waves-light btn" value="Erstellen"/>
			</form>
			
  </div>
          
	</div>		

	
	<nav class="light-blue">
		<div class="nav-wrapper container">
			<a id="logo-container" class="brand-logo center">Eventinformationen</a>
		</div>
	</nav>
	
	<br><br>
	
	<div class="row">
		<form method ="post" action="eventBearbeiten.php">
			<div class="row col s6">
				   <select name="info">
					   <?php 	
                       if(isset($search))
                           {

                               foreach ($pdo->query('SELECT * FROM Event WHERE eName LIKE "%' . $search . '%" OR eID LIKE "%' . $search . '%" OR eOrt LIKE "%' . $search . '%" OR eVeranstalter LIKE "%' . $search . '%" OR eStartZeit LIKE "%' . $search . '%" OR eEndeZeit LIKE "%' . $search . '%" ORDER BY eID, eName, eStartZeit') as $row) 
                                { 
                                        echo '<option value="' . $row['eID'] . '" >' . $row['eName'] . '</option>';

                                } 
                             $_POST['suche'] = "";
                           }
                        else
                            {
                             
                             foreach ($pdo->query('SELECT eID, eName FROM Event ORDER BY eID, eName') as $row) 
                                { 
                                        echo '<option value="' . $row['eID'] . '" >' . $row['eName'] . '</option>';

                                } 
                            
                             $_POST['suche']= "";
                            }
                 
						
			         ?>
					<option value="" disabled selected>Events</option>
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
               
                echo'<li>Event ID: ' . $infoEvent['eID'] . '</li>
                    <li>Name: ' . $infoEvent['eName'] . '</li>
                    <li>Start Datum: ' . $infoEvent['eStartDatum'] . '</li>
                    <li>End Datum: ' . $infoEvent['eEndeDatum'] . '</li>
                    <li>Startzeit: ' . $infoEvent['eAnfangsZeit'] . '</li>
                    <li>Endzeit: ' . $infoEvent['eSchlussZeit'] . '</li>
                    <li>Ort: ' . $infoEvent['eOrt'] . '</li>
                    <li>Veranstalter: ' . $infoEvent['eVeranstalter'] . '</li>';
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
