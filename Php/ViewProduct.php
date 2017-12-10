<!DOCTYPE html>

<?php session_start();?>
<html>
<head>
    <title>VapeNation AB</title>
    <meta charset="utf-8" />
    <link rel="icon" type="image/png" href="https://febrezeinwash.com/wp-content/themes/febreze/images/smoke_icon_vector.png">
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
    	//echo "<div class='description'><h3>Description</h3><p>" . $row['Beskrivning'] . "</p></div>";
      include "TabMenu.php";

    	echo "<div class='info'><div class='pris'>$" . $row['Pris'] . "</div>";
    	echo "<div>In Stock: " . $row['LagerAntal'] . "</div>";
    	if($_SERVER['REQUEST_METHOD']=='POST'){
        if(isset($_POST['antal'])){
          $stmt = $db->prepare("INSERT INTO Kundvagn (ID,Users_ID) VALUES (DEFAULT,:username)");
          $stmt->bindValue(':username', ($_SESSION['u_ID']));
          $stmt->execute();
          //(SELECT ID FROM Kundvagn WHERE Users_ID = ".($_SESSION['u_ID']).")
          $LastID=$db->lastInsertId();
          $stmt1 = $db->prepare("INSERT INTO Kundvagn_has_Produkter (ID, Produkter_ID, Antal) VALUES (:id,:p_id,:antal)");
          $stmt1->bindValue(':id', $LastID);
          $stmt1->bindValue(':p_id', $id);
          $stmt1->bindValue(':antal', $_POST['antal']);
          $stmt1->execute();
      		$rowOP = $stmt1->fetch(PDO::FETCH_ASSOC);
      		$rowO = $stmt->fetch(PDO::FETCH_ASSOC);
      		$_SESSION['ProductID'] = $id;

      		echo "<div class='success'> Added to your cart </div>";
        }
    	}

      ?>
      <div id="largeOrder"> </div>
    	<form action="" method="post">
        <label for="antal">Amount:</label>
      	<input type="text" onkeyup="checkAmount()" id="antal" name="antal" value="<?php if(isset($_POST['antal'])) echo $_POST['antal'];?>">
      	<input type="submit" id="btnSubmit" name="btnSubmit" value="Add to cart" disabled>

      </form>

    </div>


    <?php
    //checks if username is set and creates the javascript variable lagerAntal
      echo '<script type="text/javascript">';
      echo 'var lagerAntal = ' . json_encode($lagerAntal) . ';';
      if(!isset($_SESSION['username'])){
        echo "document.getElementById('btnSubmit').disabled = true;";
        echo "var radios = document.getElementsByClassName('radio');";
        echo "for (i = 0; i < radios.length; i++) {
                radios[i].disabled = true;
              }";
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
