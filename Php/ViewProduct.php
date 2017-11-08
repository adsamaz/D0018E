<html>
<head>
    <link rel="stylesheet" type="text/css" href="../Css/StandardStyle.css">
</head>

<php
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

	

	//echo "</ul> <ul class='storeList'>";
    //$id = $row['ProduktID'];
    //echo "<a href='ViewProduct.php?ID=$id' class='LinkItem'>";

	echo "<h3>" . $row['Namn'] . "</h3>";
	echo "<br /> <b>Description</b> <br />" . $row['Beskrivning'];
	echo "<br /><br /> <b>Price:</b> $" . $row['Pris'];
	echo " <b>In Stock:</b> " . $row['LagerAntal'];



	
    ?>
	<script type="text/javascript" src="../Javascript/disableButtonOutOfStock">
	</script>
	<form action="#" method="post">
		<input type="text" name="antal" value="0">
		<input type="submit" id="btnSubmit" name="btnSubmit" value="Add to cart">
	</form>

</body>
</html>
