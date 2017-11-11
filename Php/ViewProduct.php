<!DOCTYPE html>

<?php session_start();?>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../Css/StandardStyle.css">
    <script type="text/javascript" src="../Javascript/disableButtonOutOfStock.js"></script>

</head>


<body>

<?php
	include "../Html/menu.html";

    try{
		$db = new PDO('mysql:host=127.0.0.1;port=3306;dbname=adasaw5db', 'adasaw-5', '1234');
	}
	catch(Exception $e){

		echo $e->getMessage();
	}

	$id = $_GET['ID'];

    $stmt = $db->prepare("SELECT * FROM Produkter WHERE ID=$id");
	$stmt->execute();

	$row = $stmt->fetch(PDO::FETCH_ASSOC);

	$lagerAntal = $row['LagerAntal'];


	echo "<h3>" . $row['Namn'] . "</h3>";
	echo "<br /> <b>Description</b> <br />" . $row['Beskrivning'];
	echo "<br /><br /> <b>Price:</b> $" . $row['Pris'];
	echo " <b>In Stock:</b> " . $row['LagerAntal'];


	if($_SERVER['REQUEST_METHOD']=='POST'){
		$random = rand();
		$stmt = $db->prepare("INSERT INTO Ordrar (ID,Datum,Status,Username,Ok) VALUES ('" . ($random) . "', '" . date("Y-m-d") . "', '" . "ok" . "', '" . ($_SESSION['username']) . "','" . 0 . "') ON DUPLICATE KEY UPDATE ID=". rand());
		$stmt->execute();
		$stmt1 = $db->prepare("INSERT INTO Produkter_Ordrar(Produkter_ID, Ordrar_ID, Antal) VALUES ('".$id."','". $random ."', '". $_POST['antal']. "' )");
		$stmt1->execute();
		$rowOP = $stmt1->fetch(PDO::FETCH_ASSOC);
		$rowO = $stmt->fetch(PDO::FETCH_ASSOC);

		$_SESSION['ProductID'] = $id;

		echo "<br> Added to your cart <br>";
	}

  ?>
  <div id="largeOrder"> </div>



	<form action="" method="post">
      <label for="antal">Amount:</label>
  		<input type="text" onkeyup="checkAmount()" id="antal" name="antal" value="<?php if(isset($_POST['antal'])) echo $_POST['antal'];?>">
  		<input type="submit" id="btnSubmit" name="btnSubmit" value="Add to cart" disabled>
	</form>


<?php
//checks if username is set and creats the javascript variable lagerAntal
  echo '<script type="text/javascript">';
  echo 'var lagerAntal = ' . json_encode($lagerAntal) . ';';
  if(!isset($_SESSION['username'])){
    echo "document.getElementById('btnSubmit').disabled = true;";
    echo "document.getElementById('antal').disabled = true;";
    echo "document.getElementById('largeOrder').innerHTML = 'Log in to buy';";
  }
  echo '</script>';
?>

</body>
</html>
