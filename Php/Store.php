<html>
    <link rel="stylesheet" type="text/css" href="../Css/StandardStyle.css">
    <!--<link rel="stylesheet" type="text/css" href="../Css/StoreStyle.css">-->
</head>

<body>
    <ul class="menu">
  <li><a href="Index.html">Home</a></li>
  <li class="dropdown">
    <a href="javascript:void(0)" class="dropbtn">Store</a>
    <div class="dropdown-content">
      <a href="Store.php">Product Typ 1</a>
      <a href="#">Product Typ 2</a>
      <a href="#">Product Typ 3</a>

    </div>
  </li>
  <li><a href="#account">Account</a></li>
  <li style="float:right"><a href="Login.html">Login</a></li>
  <li style="float:right"><a href="Register.html">Register</a></li>
  <li style="float:right"><a href="Kundvagn.html">Kundvagn</a></li>


</ul>
<br />
<?php


    try{
		$db = new PDO('mysql:host=127.0.0.1;port=3306;dbname=adasaw5db', 'adasaw-5', '1234');
	}
	catch(Exception $e){
		
		echo $e->getMessage();
	}

    $stmt = $db->prepare("SELECT * FROM Produkter WHERE kategori = 'vape'");
	$stmt->execute();
	
	echo "<ul>";
	$i = 1;
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		if($i > 5){
			$i = 1;
			echo "</ul> <ul>";
		}
            $id = $row['ProduktID'];
            //echo "<a href='ViewProduct.php?ID=$id' class='LinkItem'>";

			echo "<li><a href='ViewProduct.php?ID=$id' class='LinkItem'><h3>" . $row['Namn'] . "</h3>";
			echo "<br /> <b>Description</b> <br />" . $row['Beskrivning'];
			echo "<br /><br /> <b>Price:</b> $" . $row['Pris'];
			echo " <b>In Stock:</b> " . $row['LagerAntal'] . "</a></li>";

            //echo "</a>";
			
		
		
	$i++;
	}
	echo "</ul>";
	
    ?>
    <!--<p>
        Store...</p>

    <table style="width:100%;">
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
    </table>-->
    <?php
     
	//;charset=utf8mb4
	//$name = $_POST['firstname'];
	//echo $name;
	
	
	
	
	//$stmt = $db->prepare("INSERT INTO test1(name,lastname) VALUES($name,'hej')");
	//$stmt->execute();
	//$stmt = $db->prepare("INSERT INTO test1(name,lastname) VALUES(:name,:lastname)");
	//$stmt->execute(array(':name' => $name, ':lastname' => 'hej'));
	//$stmt = $db->prepare("SELECT * FROM test1");
	//$stmt->execute();
	
//	$row=$stmt->fetch();
	
	//echo $row['name'];
	

?>



</body>
</html>
