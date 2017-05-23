<?php  session_start(); ?>
<?php
	include("konfiguration.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>GetDataFromID</title>
</head>

<body>
	<?php 
		
		$id = $_GET['id'];
		$temp = $pdo->query("SELECT * FROM Gast WHERE barcode = $id");
		$result= $temp->fetch(PDO::FETCH_ASSOC);
		 
		echo json_encode($result);
	
	?>
	
	
</body>
</html>