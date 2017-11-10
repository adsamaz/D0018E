﻿<?php session_start();?>


<!DOCTYPE html>
<html>
<head>
    <style>
        ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            overflow: hidden;
            background-color: #393939;
        }

        li {
            float: left;
        }

            li a, .dropbtn {
                display: inline-block;
                color: white;
                text-align: center;
                padding: 14px 16px;
                text-decoration: none;
            }

                li a:hover, .dropdown:hover .dropbtn {
                    background-color: #16a426;
                }

            li.dropdown {
                display: inline-block;
            }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
        }

            .dropdown-content a {
                color: black;
                padding: 12px 16px;
                text-decoration: none;
                display: block;
                text-align: left;
            }

                .dropdown-content a:hover {
                    background-color: #16a426
                }

        .dropdown:hover .dropdown-content {
            display: block;
        }
    </style>
</head>
<body>

    <ul>
        <li><a href="Htmlpage1.html">Home</a></li>
        <li class="dropdown">
            <a href="javascript:void(0)" class="dropbtn">Store</a>
            <div class="dropdown-content">
                <a href="Store.html">Product Typ 1</a>
                <a href="#">Product Typ 2</a>
                <a href="#">Product Typ 3</a>

            </div>
        </li>
        <li><a href="Account.php">Account</a></li>
        <li style="float:right"><a href="Login.php">Login</a></li>
        <li style="float:right"><a href="Register.php">Register</a></li>
        <li style="float:right"><a href="Kundvagn.php">Kundvagn</a></li>


    </ul>

    <h3>Your cart</h3>
    <?php 
		try{
		$db = new PDO('mysql:host=127.0.0.1;port=3306;dbname=adasaw5db', 'adasaw-5', '1234');
		}
		catch(Exception $e){
			
			echo $e->getMessage();
		}


		
	
		if(isset($_SESSION['username'])){
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
							//echo "Thank you for the order.";
						}
						if(isset($_POST['Clear_button']))
						{
							
							$sqlDelete = $db->prepare("DELETE FROM Ordrar WHERE Username = '". $_SESSION['username']."'" );
							$sqlDelete->execute();
							echo "Order is now cleared!";
						}

					

					}
					
		else{
						echo "You need to be signed in to access your shopping cart";
		}
	
	
	
	?>

</body>
</html>