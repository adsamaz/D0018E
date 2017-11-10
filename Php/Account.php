

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
    <ul>
  <li><a href="/~adasaw-5/root/Index.html">Home</a></li>
  <li class="dropdown">
    <a href="javascript:void(0)" class="dropbtn">Store</a>
    <div class="dropdown-content">
      <a href="Store.php">Product Typ 1</a>
      <a href="#">Product Typ 2</a>
      <a href="#">Product Typ 3</a>

    </div>
  </li>
  <li><a href="Account.php">Account</a></li>
  <li style="float:right"><a href="Login.php">Login</a></li>
  <li style="float:right"><a href="Register.php">Register</a></li>
  <li style="float:right"><a href="Kundvagn.php">Kundvagn</a></li>


</ul>



    <form name="Account" method="POST" action="Login.php">
		<div class="alert"> <?=$_SESSION['message']?></div>
			<?php  try{
					$db = new PDO('mysql:host=127.0.0.1;port=3306;dbname=adasaw5db', 'adasaw-5', '1234');
				}
				catch(Exception $e){
					
					echo $e->getMessage();
				}
				if(isset($_SESSION['username'])){
					echo "Welcome " . $_SESSION['u_name']. " you are now logged in <br><br> Account information: <br>" ;
					echo "Username: " . $_SESSION['username']. "<br>";
					echo "Name: " . $_SESSION['u_name']. "<br>";
					echo "Address: " . $_SESSION['u_add']. "<br>";
					$TotalPris=0;

					$sql = $db->prepare("SELECT * FROM Ordrar WHERE Username ='". $_SESSION['username']."' AND Ok=1" );
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
			?>


        </table>
    </form>
 

</body>
</html>
