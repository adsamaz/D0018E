
<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="../Css/StandardStyle.css">
</head>
<body>

<?php
	include "../Html/menu.html";
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
    $_SESSION['u_ID']= $row['ID'];
		$_SESSION['u_name']= $row['Namn'];
		$_SESSION['u_add']= $row['Adress'];
    $_SESSION['u_Role']= $row['Roll'];

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
