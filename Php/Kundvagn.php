<?php session_start();?>


<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="../Css/StandardStyle.css">
</head>
<body>

    <?php
		try{
		$db = new PDO('mysql:host=127.0.0.1;port=3306;dbname=adasaw5db', 'adasaw-5', '1234');
		}
		catch(Exception $e){

			echo $e->getMessage();
		}




		if(isset($_SESSION['username'])){
					include "../Html/LogIN.html";
					echo "<h3>Your cart</h3>";
					$sql = $db->prepare("SELECT * FROM Ordrar WHERE Username ='". $_SESSION['username']."' AND Ok=0" );
					$sql->execute();
					$TotalPris=0;
					echo "Welcome " . $_SESSION['u_name']. " to the shopping cart <br><br> Your orders: <br>" ;

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

					echo "<br> To proceed with the order please press the ORDER button or if you wish to remove the order simply press CLEAR. <br>";

					echo
					"<form action='' method='post'>
					<button type='ORDER' class='button1' name ='use_button'>ORDER</button>
					<button type='CLEAR' class='button2' name ='Clear_button'>CLEAR</button>
					</form>";

						if(isset($_POST['use_button']))
						{

							$sql = $db->prepare("UPDATE Ordrar SET Ok = '1' WHERE Ordrar.Username = '". $_SESSION['username']."'" );
							$sql->execute();
							echo "<script> alert('Thank you for the order!'); window.location='/~adasaw-5/root/Php/Kundvagn.php'; </script>";
						}
						if(isset($_POST['Clear_button']))
						{
							$sqlD=$db->prepare("SELECT ID FROM Ordrar WHERE Ok = '0' AND Username ='". $_SESSION['username'] ."'" );
							$sqlD->execute();
							while($rowD = $sqlD->fetch(PDO::FETCH_ASSOC)){
								$sqlDelete1 = $db->prepare("DELETE FROM Produkter_Ordrar WHERE Ordrar_ID = '". $rowD['ID']."'" );
								$sqlDelete1->execute();
								$sqlDelete = $db->prepare("DELETE FROM Ordrar WHERE ID = '". $rowD['ID'] ."'" );
								$sqlDelete->execute();
							}


							echo "<script> alert('All your orders is now cleared!'); window.location='/~adasaw-5/root/Php/Kundvagn.php'; </script>";
						}



					}

		else{
				include "../Html/menu.html";
				echo "You need to be signed in to access your shopping cart";
		}



	?>

</body>
</html>
