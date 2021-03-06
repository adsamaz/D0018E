﻿<?php session_start();?>


<!DOCTYPE html>
<html>
<head>
  <title>VapeNation AB</title>
  <meta charset="utf-8" />
  <link rel="icon" type="image/png" href="https://febrezeinwash.com/wp-content/themes/febreze/images/smoke_icon_vector.png">
  <link rel="stylesheet" type="text/css" href="../Css/FooterStyle.css">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="../Css/StandardStyle.css">
  <link rel="stylesheet" type="text/css" href="../Css/CartStyle.css">
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




  		if(isset($_SESSION['username'])){
  					echo '<div class="shopping-cart">
                <div class="title">
                  Shopping Bag
                </div>';
            $sql = $db->prepare("SELECT * FROM Kundvagn WHERE Users_ID ='". $_SESSION['u_ID']."'" );
  					$sql->execute();
  					$TotalPris=0;

  					while($row = $sql->fetch(PDO::FETCH_ASSOC)){
  					  $ID = $row['Produkter_ID'];

              echo '<div class="item">';

              // $sqlO = $db->prepare("SELECT * FROM Kundvagn WHERE ID ='". $ID ."'" );
  						// $sqlO->execute();
  						// $rowO = $sqlO->fetch(PDO::FETCH_ASSOC);
  						$sqlP=$db->prepare("SELECT * FROM Produkter WHERE ID ='". $row['Produkter_ID'] ."'" );
  						$sqlP->execute();
  						$rowP = $sqlP->fetch(PDO::FETCH_ASSOC);
  						$TotalPris += $rowP['Pris']*$row['Antal'];
              $ImageID = $rowP['Bild'];

              echo "<div class='image'>
                      <img src='../Images/ProductImage$ImageID.png' />
                    </div>";
              echo '<div class="description">
                      <span>' . $rowP['Namn'] . '</span>
                    </div>';
              echo "<div class='quantity'>
                      <a href='ChangeAmount.php?action=decrease&ID=$ID'><img src='../Images/Minus.png' /></a>
                      <span>". $row['Antal'] ."</span>
                      <a href='ChangeAmount.php?action=increase&ID=$ID'><img src='../Images/Plus.png' /></a>
                    </div>";
            echo '<div class="total-price">$'. $rowP['Pris'] .'</div>';
            echo '</div>';
  					}
  					echo "<div class='total'> Total price: $". $TotalPris. "</div>";

  					echo
  					"<form action='' method='post'>
    					<button type='ORDER' class='button1' name ='use_button'>ORDER</button>
    					<button type='CLEAR' class='button2' name ='Clear_button'>CLEAR</button>
  					</form>";

  						if(isset($_POST['use_button']))
  						{
                $sql = $db->prepare("SELECT * FROM Kundvagn WHERE Users_ID ='". $_SESSION['u_ID']."'" );
      					$sql->execute();
                while($row = $sql->fetch(PDO::FETCH_ASSOC)){
                  $random= rand();
                  $OrderIDR=($_SESSION['username']).$random;
                  $NewOrder='New Order, waiting to be delivered.';
                  $stmt = $db->prepare("INSERT INTO Ordrar (OrderID,Users_ID,Datum,Status,OrderPris) VALUES ('" . ($OrderIDR) . "', '" . ($_SESSION['u_ID']) ."', '" . date("Y-m-d") ."', '".  $NewOrder . "','". $TotalPris."')");
                  $stmt->execute();
                  // $sqlO = $db->prepare("SELECT * FROM Kundvagn_has_Produkte WHERE ID ='". $row['ID'] ."'" );
        					// $sqlO->execute();
        					// $rowO = $sqlO->fetch(PDO::FETCH_ASSOC);
                  $sqlP=$db->prepare("SELECT * FROM Produkter WHERE ID ='". $row['Produkter_ID'] ."'" );
                  $sqlP->execute();
                  $rowP = $sqlP->fetch(PDO::FETCH_ASSOC);

                  $stmt1 = $db->prepare("INSERT INTO Produkter_Ordrar(OrderID,Produkter_ID,Antal,ProduktPris) VALUES ('".$OrderIDR."','".$row['Produkter_ID']."','".$row['Antal']."','".$rowP['Pris']."' )");
                  $stmt1->execute();


                  $TotalLager = $rowP['LagerAntal'];
                  $nyttAntal = $TotalLager - $row['Antal'];
                  $sqlP=$db->prepare("UPDATE Produkter SET LagerAntal =".$nyttAntal." WHERE Produkter.ID =".$row['Produkter_ID']."");
                  $sqlP->execute();

                  // $sqlDel = $db->prepare("DELETE FROM Kundvagn_has_Produkter WHERE Kundvagn_has_Produkter.ID =". $row['ID']);
                  // $sqlDel->execute();
                  $sqlDelK = $db->prepare("DELETE FROM Kundvagn WHERE Kundvagn.Users_ID =". $row['Users_ID']);
                  $sqlDelK->execute();

  							echo "<script> alert('Thank you for the order!'); window.location='Kundvagn.php'; </script>";
  						}
            }
  						if(isset($_POST['Clear_button']))
  						{
                $sqlD = $db->prepare("SELECT * FROM Kundvagn WHERE Users_ID ='". $_SESSION['u_ID']."'" );
      					$sqlD->execute();
  							while($rowD = $sqlD->fetch(PDO::FETCH_ASSOC)){
                  // $sqlDel = $db->prepare("DELETE FROM Kundvagn_has_Produkter WHERE Kundvagn_has_Produkter.ID =". $rowD['ID']);
                  // $sqlDel->execute();
                  $sqlDelK = $db->prepare("DELETE FROM Kundvagn WHERE Kundvagn.Users_ID ='". $_SESSION['u_ID']."'");
                  $sqlDelK->execute();
  							}


  							echo "<script> alert('All your orders is now cleared!'); window.location='Kundvagn.php'; </script>";
  						}



  					}

  		else{
  				echo "You need to be signed in to access your shopping cart";
  		}
  	?>
    </div>
  </div>
  <canvas class="parallax"></canvas>
  <?php include "../Html/Footer.html"; ?>

</body>
</html>
