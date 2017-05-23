
<?php session_start();?>

<?php

include('konfiguration.php');
 
 $temp=false;
if($_SERVER["REQUEST_METHOD"] == "POST")
{
    
    if($_SESSION['bEmail'] == '') //wird überprüft ob eine Session besteht
    header('Location: index.php');
                     //temp ist das resultat der SQL-Abfragen und wird auf false gesetzt um voreilige Ausgaben zu verhindern

    // Daten vom Formular
    $bEmail =$_POST['bEmail']; 
    $password1 =$_POST['password1'];
    $password2 =$_POST['password2'];
    $vorname =$_POST['vorname']; 
    $nachname =$_POST['nachname']; 
    $typ =$_POST['typ']; 
    
   //SQL-Abfragen der Daten 
    
    //Suche
    $search = $_POST["suche"];
    
    
    //Delete
    
    $delete = $_POST['del'];
   if(isset($_POST['del']))
   {
       $deleteTemp=false;
        $result= $pdo->prepare("DELETE FROM Benutzer WHERE bEmail = ?");
                    $deleteTemp = $result->execute([$delete]);
        
        if($deleteTemp)
        {
             $message = "Benutzer wurde erfolgreich gelöscht";
                echo "<script type='text/javascript'>alert('$message');</script>";
        }
        else
        {
             $message = "Benutzer wurde nicht erfolgreich gelöscht";
                echo "<script type='text/javascript'>alert('$message');</script>";
        }
   }
    
    $info = $_POST['info'];
    if(isset($_POST['info']))
   {
       $selectTemp=false;
        $result= $pdo->prepare("SELECT * FROM Benutzer WHERE bEmail = ?");
        $selectTemp = $result->execute([$info]);
        $infoBenutzer = $result->fetch();
        
        if(!$selectTemp)
        {
             $message = "Es ist ein Fehler beim ausgeben des Benutzers aufgetreten";
                echo "<script type='text/javascript'>alert('$message');</script>";
        }
   }
    
    if(isset($bEmail))
    {
        
        
                 
        
        if($password1 != $password2) //Passwörter werden überprüft
    {
            
          $message = "Passwörter stimmen nicht überein";
            echo "<script type='text/javascript'>alert('$message');</script>";
    }
    else
    {
        
    
    $password1 =md5($password1); // Passwort mit MD5 gehasht
        
        //Update
        $result= $pdo->prepare("UPDATE Benutzer SET  passwort = ?, vorname = ?, nachname = ?, typ = ? WHERE bEmail = ?");
       
    $updateTemp=$result->execute([ $password1, $vorname, $nachname, $typ, $bEmail]);


        //Ausgabe des Ergebnis der SQL-Abfrage
        if($updateTemp){

           $message = "Benutzer wurde erfolgreich bearbeitet";
            echo "<script type='text/javascript'>alert('$message');</script>";

        }else{
            $message = "Benutzer konnte nicht bearbeitet werden!";
            echo "<script type='text/javascript'>alert('$message');</script>";
        } 

    }          
}
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title>Benutzer Verwalten</title>

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
		<h5 class="header center orange-text">Benutzer Löschen</h5>
	<br>
    </div>
  </div>
  
  <br>
  
	<div class ="row" >
		<form method="post" action="benutzerBearbeiten.php">
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
      
	  
	  <!--Benutzer-->
		  <div class="row">
              <form method ="post" action="benutzerBearbeiten.php">
			<div class="row col s6">
			
               <select name="del">
                   <?php 	
                       if(isset($search))
                           {

                               foreach ($pdo->query('SELECT * FROM Benutzer WHERE vorname LIKE "%' . $search . '%" OR nachname LIKE "%' . $search . '%" OR bEmail LIKE "%' . $search . '%" ORDER BY vorname, nachname, bEmail, typ') as $row) 
                                { 
                                        echo '<option value="' . $row['bEmail'] . '" >' . $row['vorname'] . ' ' . $row['nachname'] . '</option>';

                                } 
                             $_POST['suche'] = "";
                           }
                        else
                            {
                             
                            foreach ($pdo->query('SELECT bEmail, vorname, nachname FROM Benutzer ORDER BY vorname, nachname, bEmail, typ') as $row) 
                                { 
                                        echo '<option value="' . $row['bEmail'] . '" >' . $row['vorname'] . ' ' . $row['nachname'] . '</option>';

                                } 
                             $_POST['suche']= "";
                            }
                 
						
			         ?>
                <option value="" disabled selected>Benutzer</option>
                   
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
			<a id="logo-container" class="brand-logo center">Benutzer bearbeiten</a>
		</div>
	</nav>
  <br>


	     <div class="row">
		<form class="col s12" action="benutzerBearbeiten.php" method="post"> 
            
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
        
          
	</div>		

	
	<nav class="light-blue">
		<div class="nav-wrapper container">
			<a id="logo-container" class="brand-logo center">Benutzerinformationen</a>
		</div>
	</nav>
	
	<br><br>
	
	<div class="row">
		<form method ="post" action="benutzerBearbeiten.php">
			<div class="row col s6">
				   <select name="info">
					   <?php 	
                       if(isset($search))
                          {

                               foreach ($pdo->query('SELECT * FROM Benutzer WHERE vorname LIKE "%' . $search . '%" OR nachname LIKE "%' . $search . '%" OR bEmail LIKE "%' . $search . '%" ORDER BY vorname, nachname, bEmail, typ') as $row) 
                                { 
                                        echo '<option value="' . $row['bEmail'] . '" >' . $row['vorname'] . ' ' . $row['nachname'] . '</option>';

                                } 
                             $_POST['suche'] = "";
                           }
                        else
                            {
                             
                            foreach ($pdo->query('SELECT bEmail, vorname, nachname FROM Benutzer ORDER BY vorname, nachname, bEmail, typ') as $row) 
                                { 
                                        echo '<option value="' . $row['bEmail'] . '" >' . $row['vorname'] . ' ' . $row['nachname'] . '</option>';

                                } 
                             $_POST['suche']= "";
                            }
						
			         ?>
					<option value="" disabled selected>Benutzer</option>
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
                echo'<li>Email: ' . $infoBenutzer['bEmail'] . '</li>
                    <li>Name: ' . $infoBenutzer['vorname'] . '</li>
                    <li>Nachname: ' . $infoBenutzer['nachname'] . '</li>
                    <li>Typ: ' . $infoBenutzer['typ'] . '</li>';
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
