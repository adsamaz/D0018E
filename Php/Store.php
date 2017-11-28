<!DOCTYPE html>
<?php	session_start(); ?>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../Css/StandardStyle.css">
    <link rel="stylesheet" type="text/css" href="../Css/StoreStyle.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script type="text/javascript" src="../Javascript/Smoke.js"></script>

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
  <canvas class="parallax"></canvas>
  <div id="wrap">
    <div class="content">
      <h1>Vapes</h1>
    	<form class="searchForm" action ="Store.php" method="post">
    			<input type="text" class="searchField" name="search" placeholder="Search" />
    			<input type="submit" class="searchButton" name="btnSearch" value="Search" />
    	</form>

      <?php
      try{
    		$db = new PDO('mysql:host=127.0.0.1;port=3306;dbname=adasaw5db', 'adasaw-5', '1234');
    	}
    	catch(Exception $e){

    		echo $e->getMessage();
    	}
    	if(isset($_POST['search'])){
    		$searchValue = $_POST['search'];
    		$stmt = $db->prepare("SELECT * FROM Produkter WHERE kategori LIKE '%$searchValue%' OR Namn LIKE '%$searchValue%'");
    	}
    	else if(isset($_GET['category'])){
        $category = $_GET['category'];
        $stmt = $db->prepare("SELECT * FROM Produkter WHERE kategori = '$category'");
      }
      else{
        $stmt = $db->prepare("SELECT * FROM Produkter");
      }
      $stmt->execute();

    	$i = 0;
    	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    		//if($i >= 5){
    			//$i = 1;
    			//echo "<div class='clear'> </div>"; //4 products in a row
    		//}
        $id = $row['ID'];
        $ImageID = $row['Bild'];

        echo "<div class='productBox'><a href='ViewProduct.php?ID=$id'><h3>" . $row['Namn'] . "</h3>";
        echo "<img src='../Images/ProductImage$ImageID.jpg' />";
        echo "<br /><br /> <b>Price:</b> $" . $row['Pris'];
        echo " <b>In Stock:</b> " . $row['LagerAntal'] . "</a></div>";



    	  $i++;
    	}
    	//echo "</ul>";

    ?>
    </div>
  </div>

  <canvas class="parallax"></canvas>
</body>
</html>
