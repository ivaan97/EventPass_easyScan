<?php  session_start(); ?>

<?php

echo '<html lang="en">';
echo '<head>';
include("konfiguration.php");


$name = $_SESSION['bEmail'];
//echo $name;
$result = $pdo->prepare("SELECT typ FROM Benutzer WHERE bEmail= ? ");
$result->execute([$name]);
$typ = $result->fetch();
//echo $typ["typ"];



if($_SESSION['bEmail'] == '')
	header('Location: index.php');
//folien fehlermeldung aktivieren


if($typ["typ"] == 1)
{
    echo '<meta http-equiv="refresh" content="0; URL=adminGUI.php">';
	    
	//header('Location: adminGUI.php');
}

else if($typ["typ"] == 2)
{
	echo '<meta http-equiv="refresh" content="0; URL=angestellterGUI.php">';
   //header('Location: angestellterGUI.php');
}

else if($typ["typ"] == 3)
{
	echo '<meta http-equiv="refresh" content="0; URL=anwenderGUI.php">';
   //header('Location: anwenderGUI.php');
}

else
{
    echo "Benutzer ist ungültig!";
}

echo '</head>';
echo '</html>';

?>