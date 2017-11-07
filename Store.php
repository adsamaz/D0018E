<html>
    <style>
ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
    overflow: hidden;
    
}
ul.menu{
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
			echo "<li><h3>" . $row['Namn'] . "</h3>";
			echo "<br /> <b>Description</b> <br />" . $row['Beskrivning'];
			echo "<br /><br /> <b>Price:</b> $" . $row['Pris'];
			echo "   <b>In Stock:</b> " . $row['LagerAntal'] . "</li>";
			
		
		
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
