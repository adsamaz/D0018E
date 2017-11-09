
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
<?php 

	session_start();
	$_SESSION['message']='';
	try{
		$db = new PDO('mysql:host=127.0.0.1;port=3306;dbname=adasaw5db', 'adasaw-5', '1234');
	}
	catch(Exception $e){
		die;
		echo $e->getMessage();
	}
	if($_SERVER['REQUEST_METHOD']=='POST'){

		$stmt = $db->prepare("INSERT INTO Users (Username, Password, Namn, Adress, Roll) VALUES ('" . $_POST["username"] . "', '" . $_POST["password"] . "', '" . $_POST["Namn"] . "', '" . ($_POST["Address"]) . "', '" . 'pleb' . "')");
		$stmt->execute();
		
		//echo "<script> alert('You are now registered, thank you!'); window.location='/~adasaw-5/root/Index.html'; </script>";
		$stmt1=$db->prepare("Select * FROM Users WHERE Username ='" . $_POST["username"] . "'");
		$stmt1->execute();
		$row = $stmt1->fetch(PDO::FETCH_ASSOC);
		
		$_SESSION['username']= $row['Username'];
		$_SESSION['u_name']= $row['Namn'];
		$_SESSION['u_add']= $row['Adress'];
				
				//echo "<script> alert('Welcome to the store! You are now signed in.'); window.location='/~adasaw-5/root/Php/Account.php?login=success'; </script>";
		header("Location: Account.php?login=success");
		exit();

		
		
	}

	?>

<body>
    <form name="Registration" method="post" action="">
		<div class="alert"> <?=$_SESSION['message']?></div>
        <div class="container">
            <label>Username</label>
            <input type="text" placeholder="Enter Username" name="username" value="<?php if(isset($_POST['username'])) echo $_POST['username'];?>" required>
			<label>Name</label>
			<input type="text" placeholder="Enter Name" name="Namn" value="<?php if(isset($_POST['Namn'])) echo $_POST['Namn'];?>" required>
			<label>Address</label>
			<input type="text" placeholder="Enter Address" name="Address" value="<?php if(isset($_POST['Address'])) echo $_POST['Address'];?>" required>
			<label>Password</label>
            <input type="password" placeholder="Enter Password" name="password" value="<?php if(isset($_POST['password'])) echo $_POST['password'];?>" required>
           
			
            <div class="clear">
                <button type="button" class="cancelbtn">Cancel</button>
                <button type="submit" class="signupbtn">Register</button>
            </div>
        </div>
    </form> 

</body>
</html>