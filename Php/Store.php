<?php	session_start(); ?>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../Css/StandardStyle.css">
    <link rel="stylesheet" type="text/css" href="../Css/StoreStyle.css">
</head>


<body>

<?php
  if(isset($_SESSION['username'])){
    include "../Html/LogIN.html";
  }
  else{
    include "../Html/menu.html";
  }
?>
  <div class="parallax"></div>
  <div id="wrap">
<?php

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
    $ImageID = $row['Bild'];

			echo "<li><a href='ViewProduct.php?ID=$id' class='LinkItem'><h3>" . $row['Namn'] . "</h3>";
      echo "<img src='../Images/ProductImage$ImageID.jpg' />";
      //echo "<br /> <b>Description</b> <br />" . $row['Beskrivning'];
			echo "<br /><br /> <b>Price:</b> $" . $row['Pris'];
			echo " <b>In Stock:</b> " . $row['LagerAntal'] . "</a></li>";

            //echo "</a>";



	$i++;
	}
	echo "</ul>";

?>
</div>


</body>
</html>
