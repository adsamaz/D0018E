<!DOCTYPE html>

<?php session_start();?>
<html>
<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="../Css/FooterStyle.css">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../Css/StandardStyle.css">
    <link rel="stylesheet" type="text/css" href="../Css/ViewProductStyle.css">
    <script type="text/javascript" src="../Javascript/disableButtonOutOfStock.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script type="text/javascript" src="../Javascript/Smoke.js"></script>
    <script type="text/javascript" src="../Javascript/ActiveLink.js"></script>
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
    <?php

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
      $ImageID = $row['Bild'];

    	echo "<h1>" . $row['Namn'] . "</h1>";
      echo "<img class='productImage' src='../Images/ProductImage$ImageID.png' />";
    	echo "<div class='description'><h3>Description</h3><p>" . $row['Beskrivning'] . "</p></div>";
    	echo "<div class='info'><b>Price:</b> $" . $row['Pris'];
    	echo " <b>In Stock:</b> " . $row['LagerAntal'] . "<br />";
      echo "<a class='button' href='/~adasaw-5/root/Php/Comments.php?ID=".$id."' target='blank'>Comments and ratings for this product</a>";
    	if($_SERVER['REQUEST_METHOD']=='POST'){
        $stmt = $db->prepare("INSERT INTO Kundvagn (ID,Users_ID) VALUES (DEFAULT,'" . ($_SESSION['u_ID']) ."')");
        $stmt->execute();
        //(SELECT ID FROM Kundvagn WHERE Users_ID = ".($_SESSION['u_ID']).")
        $LastID=$db->lastInsertId();
        $stmt1 = $db->prepare("INSERT INTO Kundvagn_has_Produkter (ID, Produkter_ID, Antal) VALUES ('". $LastID . "', '" . ($id) ."', '" . $_POST['antal'] ."')");
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
    </form>

    </div>


    <?php
    //checks if username is set and creates the javascript variable lagerAntal
      echo '<script type="text/javascript">';
      echo 'var lagerAntal = ' . json_encode($lagerAntal) . ';';
      if(!isset($_SESSION['username'])){
        echo "document.getElementById('btnSubmit').disabled = true;";
        echo "document.getElementById('antal').disabled = true;";
        echo "document.getElementById('largeOrder').innerHTML = 'Log in to buy';";
      }
      echo '</script>';
    ?>
  </div>
  <canvas class="parallax"></canvas>
  <?php include "../Html/Footer.html"; ?>
</body>
</html>
