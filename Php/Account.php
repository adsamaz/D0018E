<!DOCTYPE html>
<?php	session_start(); ?>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="../Css/StandardStyle.css">
</head>

<body>


    <form name="Account" method="POST" action="Login.php">

			<?php
			try{

					$db = new PDO('mysql:host=127.0.0.1;port=3306;dbname=adasaw5db', 'adasaw-5', '1234');
				}
				catch(Exception $e){

					echo $e->getMessage();
				}
				if(isset($_SESSION['username'])){
					include "../Html/LogIN.html";
					if($_SESSION['u_role']=='pleb'){
						echo "Welcome " . $_SESSION['u_name']. " you are now logged in <br><br> Account information: <br>" ;
						echo "Username: " . $_SESSION['username']. "<br>";
						echo "Name: " . $_SESSION['u_name']. "<br>";
						echo "Address: " . $_SESSION['u_add']. "<br>";
						$TotalPris=0;

						$sql = $db->prepare("SELECT * FROM Ordrar WHERE Users_ID ='". $_SESSION['id']."' AND Ok=1" );
						$sql->execute();
						echo "<br><br> Your placed orders: <br><br>";
						while($row = $sql->fetch(PDO::FETCH_ASSOC)){
						echo "Order number: " . $row['ID'] . "<br>";

							$sqlO = $db->prepare("SELECT * FROM Produkter_Ordrar WHERE Ordrar_ID ='". $row['ID'] ."'" );
							$sqlO->execute();
							$rowO = $sqlO->fetch(PDO::FETCH_ASSOC);

							$sqlP=$db->prepare("SELECT * FROM Produkter WHERE ID ='". $rowO['Produkter_ID'] ."'" );
							$sqlP->execute();
							$rowP = $sqlP->fetch(PDO::FETCH_ASSOC);
							$TotalPris += $rowP['Pris']*$rowO['Antal'];
							echo "Product: " .$rowP['Namn']." - Amount: " . $rowO['Antal'] . "- Price: " .$rowP['Pris']*$rowO['Antal']."<br>" ;
						}
						echo "<br> Total price: ". $TotalPris. "<br>";



					}


				else if($_SESSION['u_role']=='Admin'){
						echo "Welcome " . $_SESSION['u_name']. " you are now logged in <br><br> Account information: <br>" ;
						echo "Username: " . $_SESSION['username']. "<br>";
						echo "Name: " . $_SESSION['u_name']. "<br>";
						echo "Address: " . $_SESSION['u_add']. "<br>";

						$TotalPris=0;
						$sql = $db->prepare("SELECT * FROM Ordrar WHERE Ok=1" );
						$sql->execute();
						echo "<br><br> Orders: <br><br>";
						while($row = $sql->fetch(PDO::FETCH_ASSOC)){

							$sqlO = $db->prepare("SELECT * FROM Produkter_Ordrar WHERE Ordrar_ID ='". $row['ID'] ."'" );
							$sqlO->execute();
							$rowO = $sqlO->fetch(PDO::FETCH_ASSOC);

							$sqlP=$db->prepare("SELECT * FROM Produkter WHERE ID ='". $rowO['Produkter_ID'] ."'" );
							$sqlP->execute();
							$rowP = $sqlP->fetch(PDO::FETCH_ASSOC);
							$TotalPris += $rowP['Pris']*$rowO['Antal'];
							echo "<br>Order placed by <br> USER: ".$row['Username'] ." <br>Order number: " . $row['ID']. "<br>Product: " .$rowP['Namn']." <br> Amount: " . $rowO['Antal'] . "<br>Price: " .$rowP['Pris']*$rowO['Antal']."<br><br>" ;
						}



					}

			}
				else{
					include "../Html/menu.html";
					echo "You need to be logged in to show your account information";
				}
			?>


        </table>
    </form>


</body>
</html>
