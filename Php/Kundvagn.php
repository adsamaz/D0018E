<?php session_start();?>


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
  					echo "<h3>Your cart</h3>";
            $sql = $db->prepare("SELECT * FROM Kundvagn WHERE Users_ID ='". $_SESSION['u_ID']."'" );
  					$sql->execute();
  					$TotalPris=0;
  					echo "Welcome " . $_SESSION['u_name']. " to the shopping cart <br><br> Your orders: <br>" ;

  					while($row = $sql->fetch(PDO::FETCH_ASSOC)){
  					//	echo "Order number: " . $row['ID'] . "<br>";

              $sqlO = $db->prepare("SELECT * FROM Kundvagn_has_Produkter WHERE ID ='". $row['ID'] ."'" );
  						$sqlO->execute();
  						$rowO = $sqlO->fetch(PDO::FETCH_ASSOC);
  						$sqlP=$db->prepare("SELECT * FROM Produkter WHERE ID ='". $rowO['Produkter_ID'] ."'" );
  						$sqlP->execute();
  						$rowP = $sqlP->fetch(PDO::FETCH_ASSOC);
  						$TotalPris += $rowP['Pris']*$rowO['Antal'];
  						echo "Product: " .$rowP['Namn']." - Amount: " . $rowO['Antal'] . "- Price: " .$rowP['Pris']*$rowO['Antal']."<br>" ;


  					}
  					echo "<br> Total price: ". $TotalPris. "<br>";

  					echo "<br> To proceed with the order please press the ORDER button or if you wish to remove the order simply press CLEAR. <br>";

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
                  $stmt = $db->prepare("INSERT INTO Ordrar (ID,Users_ID,Datum,Status,OrderID) VALUES ('" . ($random) . "', '" . ($_SESSION['u_ID']) ."', '" . date("Y-m-d") ."', '".  $NewOrder . "','". $OrderIDR."')");
                  $stmt->execute();
                  $sqlO = $db->prepare("SELECT * FROM Kundvagn_has_Produkter WHERE ID ='". $row['ID'] ."'" );
        					$sqlO->execute();
        					$rowO = $sqlO->fetch(PDO::FETCH_ASSOC);
                  $stmt1 = $db->prepare("INSERT INTO Produkter_Ordrar(Produkter_ID, Ordrar_ID, Antal, OrderID) VALUES ('".$rowO['Produkter_ID']."','". $random ."','".$rowO['Antal']."','". $OrderIDR . "' )");
                  $stmt1->execute();

                  $sqlP=$db->prepare("SELECT * FROM Produkter WHERE ID ='". $rowO['Produkter_ID'] ."'" );
                  $sqlP->execute();
                  $rowP = $sqlP->fetch(PDO::FETCH_ASSOC);
                  $TotalLager = $rowP['LagerAntal'];
                  $nyttAntal = $TotalLager - $rowO['Antal'];
                  $sqlP=$db->prepare("UPDATE Produkter SET LagerAntal =".$nyttAntal." WHERE Produkter.ID =".$rowO['Produkter_ID']."");
                  $sqlP->execute();

                  $sqlDel = $db->prepare("DELETE FROM Kundvagn_has_Produkter WHERE Kundvagn_has_Produkter.ID =". $row['ID']);
                  $sqlDel->execute();
                  $sqlDelK = $db->prepare("DELETE FROM Kundvagn WHERE Kundvagn.ID =". $row['ID']);
                  $sqlDelK->execute();

  							echo "<script> alert('Thank you for the order!'); window.location='Kundvagn.php'; </script>";
  						}
            }
  						if(isset($_POST['Clear_button']))
  						{
                $sqlD = $db->prepare("SELECT * FROM Kundvagn WHERE Users_ID ='". $_SESSION['u_ID']."'" );
      					$sqlD->execute();
  							while($rowD = $sqlD->fetch(PDO::FETCH_ASSOC)){
                  $sqlDel = $db->prepare("DELETE FROM Kundvagn_has_Produkter WHERE Kundvagn_has_Produkter.ID =". $rowD['ID']);
                  $sqlDel->execute();
                  $sqlDelK = $db->prepare("DELETE FROM Kundvagn WHERE Kundvagn.ID =". $rowD['ID']);
                  $sqlDelK->execute();
  							}


  							echo "<script> alert('All your orders is now cleared!'); window.location='/~adasaw-5/root/Php/Kundvagn.php'; </script>";
  						}



  					}

  		else{
  				echo "You need to be signed in to access your shopping cart";
  		}
  	?>
  </div>
  <canvas class="parallax"></canvas>
  <?php include "../Html/Footer.html"; ?>

</body>
</html>
