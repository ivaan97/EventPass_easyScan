<?php  session_start(); ?>
<?php

	include("konfiguration.php");
    if($_SESSION['bEmail'] == '') //wird überprüft ob eine Session besteht
    header('Location: index.php');
	
	$username = $_SESSION['bEmail'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title>Angestellten Panel</title>

  <!-- CSS  -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
 
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 
</head>
<body>

<?php
	
?>
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
		<h5 class="header center orange-text">Scan</h5>
    </div>
  </div>
      
	 <div class="scanContainer" >
		
		 
	<!------------ Scanner ------------>
		
	<video class="scanContainer" id="preview"></video>
		
		
    <script type="text/javascript">
	
     window.addEventListener('load', function() {
				var scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
				  scanner.addListener('scan', function (content) {
					console.log(content);
					
					
					var xhttp = new XMLHttpRequest();
					xhttp.onreadystatechange = function() {
						if (this.readyState == 4 && this.status == 200) {
							myObj = JSON.parse(xhttp.responseText);
						//---	document.getElementById("demo").innerHTML = myObj.name;			
							}
							alert(myObj['vorname']);
						};
					xhttp.open("GET", "getDataFromBarcode.php?id=".content, true);
					xhttp.send();
							
				  });
				  

				
				  
				  Instascan.Camera.getCameras().then(function (cameras) {
					if (cameras.length > 1) {
					  scanner.start(cameras[1]);
					} else if (cameras.length > 0) {
					  scanner.start(cameras[0]);
					} else {
					  console.error('No cameras found.');
					}
				  }).catch(function (e) {
					console.error(e);
				  });
		});
	  
	  
    </script>
		
	<!------------ Scanner ------------>
			
			
	</div>
	
     <!--<h5 class="header center orange-text">Gastinformationen</h5>-->
<nav class="light-blue">
    <div class="nav-wrapper container">
		<a id="logo-container" class="brand-logo center">Gastinformationen</a>
    </div>
 </nav>	  

	  
	<div class="infoContainer" >

		
		<div class="infoBox">
			<ul style="margin-top: 0px;">
				<li>Name: <output name="vorname" id="vorname"></output></li>
				<li>Nachname: <output name="nachname" id="nachname"></output></li>
				<li>Geburtsdatum: <output name="geburtsDatum" id="geburtsDatum"></output></li>
				<li>Position: <output name="gIN" id="gIN"></output></li>
				<li>Tischnummer: <output name="tischNr" id="tischNr"></output></li>
				<li>Verkäufer Mail: <output name="bEmail" id="bEmail"></output></li>
			</ul>
		</div>	
		
		<div class="ageBox">
			
		</div>
		
					<script>
					
			
			function calculateAge(birth)
			{
				
				var birthDay = birth.getDate();
				var birthMonth = birth.getMonth();
				var birthYear = birth.getFullYear();
				
				
			  todayDate = new Date();
			  todayYear = todayDate.getFullYear();
			  todayMonth = todayDate.getMonth();
			  todayDay = todayDate.getDate();
			  age = todayYear - birthYear; 

			  if (todayMonth < birthMonth - 1)
			  {
				age--;
			  }

			  if (birthMonth - 1 == todayMonth && todayDay < birthDay)
			  {
				age--;
			  }
			  return age;
			}
			
			if (calculateAge(document.getElementById(geburtsDatum))<16)
			{	
				document.getElementById("ageBox").style.backgroundColor = "red";
			}
			
			if (calculateAge(new Date(document.getElementById(geburtsDatum))) == 16)
			{
				document.getElementById("ageBox").style.backgroundColor = "yellow";
			}
			
			if (calculateAge(new Date(document.getElementById(geburtsDatum))) > 18)
			{
				document.getElementById("ageBox").style.backgroundColor = "green";
			}
			
			</script>
	</div>	 
	
<nav class="light-blue">
    <div class="nav-wrapper container">
		<a id="logo-container" class="brand-logo center">
			Weitere Funktionen
		</a>
    </div>
 </nav>	 
 
 <div class="buttonContainer" style="text-align:center;">
	 </br> </br>
		<a class="waves-effect waves-light btn" href="eventBearbeiten.php">Events bearbeiten</a> </br> </br>
		<a class="waves-effect waves-light btn" href="eventErstellen.php">Events erstellen</a> </br> </br>
		<a class="waves-effect waves-light btn" href="gastBearbeiten.php">Gäste bearbeiten</a> </br> </br>
		<a class="waves-effect waves-light btn" href="gastErstellen.php">Gäste erstellen</a> </br> </br>
		<a class="waves-effect waves-light btn" href="tischErstellen.php">Tischinventar erstellen</a>
	</br>
	<!-- gäste ausgeben/events ausgeben/tische ausgeben -->
 </div>
		</br>	
	  
  <footer class="page-footer orange">
			<?php
				echo '<a style="margin-left:20%; margin-bottom: 3%;">User: ' . $username . '</a>';
			?>
  </footer>

  

  <!--  Scripts-->
  <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
  <script src="js/materialize.js"></script>
  <script src="js/init.js"></script>
  <script src="js/script.js"></script>
   <script src="js/instascan.min.js"></script>
  <script>
				   $(document).ready(function() {
					$('select').material_select();
				  });
			</script>

  </body>
</html>
