<html>
<head>
    <link rel="stylesheet" type="text/css" href="../Css/StandardStyle.css">
    <link rel="stylesheet" type="text/css" href="../Css/StoreStyle.css">
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

    $stmt = $db->prepare("SELECT * FROM Produkter WHERE kategori = 'vape'");
	$stmt->execute();
	
	echo "<ul class='storeList'>";
	$i = 1;
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		if($i > 5){
			$i = 1;
			echo "</ul> <ul class='storeList'>";
		}
            $id = $row['ID'];
            //echo "<a href='ViewProduct.php?ID=$id' class='LinkItem'>";

			echo "<li><a href='ViewProduct.php?ID=$id' class='LinkItem'><h3>" . $row['Namn'] . "</h3>";
			echo "<br /> <b>Description</b> <br />" . $row['Beskrivning'];
			echo "<br /><br /> <b>Price:</b> $" . $row['Pris'];
			echo " <b>In Stock:</b> " . $row['LagerAntal'] . "</a></li>";

            //echo "</a>";
			
		
		
	$i++;
	}
	echo "</ul>";
	
    ?>

	

</body>
</html>
