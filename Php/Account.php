<!DOCTYPE html>
<?php	session_start(); ?>

<html>

<head>
  <title>VapeNation AB</title>
  <meta charset="utf-8" />
  <link rel="icon" type="image/png" href="https://febrezeinwash.com/wp-content/themes/febreze/images/smoke_icon_vector.png">
  <link rel="stylesheet" type="text/css" href="../Css/FooterStyle.css">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="../Css/StandardStyle.css">
  <link rel="stylesheet" type="text/css" href="../Css/AccountStyle.css">
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
  				if($_SESSION['u_Role']=='pleb'){
  					echo "Welcome " . $_SESSION['u_name']. " you are now logged in <br><br> Account information: <br>" ;
  					echo "Username: " . $_SESSION['username']. "<br>";
  					echo "Name: " . $_SESSION['u_name']. "<br>";
  					echo "Address: " . $_SESSION['u_add']. "<br>";
  					$TotalPris=0;

  					// $sql = $db->prepare("SELECT * FROM Ordrar WHERE Username ='". $_SESSION['username']."' AND Ok=1" );
  					// $sql->execute();
            $sql = $db->prepare("SELECT * FROM Ordrar WHERE Users_ID ='". $_SESSION['u_ID']."'" );
  					$sql->execute();

  					echo "<br><br> Your placed orders: <br><br>";

  					while($row = $sql->fetch(PDO::FETCH_ASSOC)){

  						$sqlO = $db->prepare("SELECT * FROM Produkter_Ordrar WHERE OrderID ='". $row['OrderID'] ."'" );
  						$sqlO->execute();
  						$rowO = $sqlO->fetch(PDO::FETCH_ASSOC);

  						$sqlP=$db->prepare("SELECT * FROM Produkter WHERE ID ='". $rowO['Produkter_ID'] ."'" );
  						$sqlP->execute();
  						$rowP = $sqlP->fetch(PDO::FETCH_ASSOC);
  						$TotalPris += $rowP['Pris']*$rowO['Antal'];
  						echo "Product: " .$rowP['Namn']." - Amount: " . $rowO['Antal'] . "- Price: " .$rowP['Pris']*$rowO['Antal']. " - Status: ". $row['Status']. "<br>" ;

  					}
  					echo "<br> Total price: ". $TotalPris. "<br>";



  				}

  			else if($_SESSION['u_Role']=='Admin'){
  					echo "Welcome " . $_SESSION['u_name']. " you are now logged in <br><br> Account information: <br>" ;
  					echo "Username: " . $_SESSION['username']. "<br>";
  					echo "Name: " . $_SESSION['u_name']. "<br>";
  					echo "Address: " . $_SESSION['u_add']. "<br>";

  					$TotalPris=0;
  					$sql = $db->prepare("SELECT * FROM Ordrar WHERE Status='New Order, waiting to be delivered.'" );
  					$sql->execute();
  					echo "<br><br> Orders: <br><br>";
            echo "<form method='post'";
  					while($row = $sql->fetch(PDO::FETCH_ASSOC)){

  						$sqlO = $db->prepare("SELECT * FROM Produkter_Ordrar WHERE Ordrar_ID ='". $row['ID'] ."'" );
  						$sqlO->execute();
  						$rowO = $sqlO->fetch(PDO::FETCH_ASSOC);

  						$sqlP=$db->prepare("SELECT * FROM Produkter WHERE ID ='". $rowO['Produkter_ID'] ."'" );
  						$sqlP->execute();
  						$rowP = $sqlP->fetch(PDO::FETCH_ASSOC);
  						$TotalPris += $rowP['Pris']*$rowO['Antal'];
  						echo "<br>Order placed by <br> USER ID: ".$row['Users_ID'] ." <br>Order number: " . $row['ID']. "<br>Product: " .$rowP['Namn']." <br> Amount: " . $rowO['Antal'] . "<br>Price: " .$rowP['Pris']*$rowO['Antal']."<br>" ;
                           // echo "<input type='submit' name ='use_button' value=".$row['ID']." />";
                            echo "<button type='submit' class='button3' name ='use_button' value=".$row['ID'].">Deliver</button>";
                            echo "<br>";
                            //ehheehhe
  					}
                        echo "</form>";
                        if(isset($_POST["use_button"]))
                            {
                              //ändra status på odern
                              $sql_deliver = $db->prepare("UPDATE Ordrar SET Status = 'Delivered' WHERE Ordrar.ID =". $_POST['use_button']);
                              $sql_deliver->execute();
                              echo "<script> alert('Order is delivered!');window.location='Account.php';</script>";



                            }




  				}

  		}
  			else{
  				echo "You need to be logged in to show your account information";
  			}
  		?>
      </table>

    </div>
    <canvas class="parallax"></canvas>
    <?php include "../Html/Footer.html"; ?>
</body>
