<?php	session_start(); ?>

<html>

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

.dropdown-content a:hover {background-color: #16a426}

.dropdown:hover .dropdown-content {
    display: block;
}
</style>
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
					if($_SESSION['u_role']=='pleb'){
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

				else if($_SESSION['u_role']=='Admin'){
						echo "Welcome " . $_SESSION['u_name']. " you are now logged in <br><br> Account information: <br>" ;
						echo "Username: " . $_SESSION['username']. "<br>";
						echo "Name: " . $_SESSION['u_name']. "<br>";
						echo "Address: " . $_SESSION['u_add']. "<br>";

						$TotalPris=0;
						$sql = $db->prepare("SELECT * FROM Ordrar WHERE Ok=1 AND Status='ok'" );
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
							echo "<br>Order placed by <br> USER: ".$row['Username'] ." <br>Order number: " . $row['ID']. "<br>Product: " .$rowP['Namn']." <br> Amount: " . $rowO['Antal'] . "<br>Price: " .$rowP['Pris']*$rowO['Antal']."<br>" ;
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
                              echo "<script> alert('Order is delivered!');window.location='/~adasaw-5/root/Php/Account.php';</script>";



                            }




					}

			}
				else{
					include "../Html/menu.html";
					echo "You need to be logged in to show your account information";
				}
			?>


        </table>


</body>
