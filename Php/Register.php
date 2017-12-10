
<!DOCTYPE html>
<html>
<head>
    <title>VapeNation AB</title>
    <meta charset="utf-8" />
    <link rel="icon" type="image/png" href="https://febrezeinwash.com/wp-content/themes/febreze/images/smoke_icon_vector.png">
    <link rel="stylesheet" type="text/css" href="../Css/FooterStyle.css">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../Css/StandardStyle.css">
    <link rel="stylesheet" type="text/css" href="../Css/RegisterStyle.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script type="text/javascript" src="../Javascript/Smoke.js"></script>
    <script type="text/javascript" src="../Javascript/ActiveLink.js"></script>
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

    $password = $_POST["password"];
    $hash = password_hash($password, PASSWORD_DEFAULT);
		$stmt = $db->prepare("INSERT INTO Users (Username, Password, Namn, Adress, Roll) VALUES (:username,:password,:namn,:adress,'pleb')");
    $stmt->bindValue(':username', $_POST["username"] );
    $password = $_POST["password"];
    $stmt->bindValue(':password', password_hash($password, PASSWORD_DEFAULT));
    $stmt->bindValue(':namn', $_POST["Namn"]);
    $stmt->bindValue(':adress', $_POST["Address"]);

    $stmt->execute();

		//echo "<script> alert('You are now registered, thank you!'); window.location='/~adasaw-5/root/Index.html'; </script>";
		$stmt1=$db->prepare("Select * FROM Users WHERE Username = :Username");
		$stmt1->execute(array('Username'=>$_POST["username"]));
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
  <canvas class="parallax"></canvas>
  <div id="wrap">

    <form name="Registration" method="post" action="">
		<div class="alert"> <?=$_SESSION['message']?></div>
      <div class="container">

        <h1>Register</h1>

        <span><label>Username: </label></span>
        <input type="text" placeholder="Enter Username" name="username" value="<?php if(isset($_POST['username'])) echo $_POST['username'];?>" required>
  			<label>Name: </label>
  			<input type="text" placeholder="Enter Name" name="Namn" value="<?php if(isset($_POST['Namn'])) echo $_POST['Namn'];?>" required>
  			<label>Address: </label>
  			<input type="text" placeholder="Enter Address" name="Address" value="<?php if(isset($_POST['Address'])) echo $_POST['Address'];?>" required>
  			<label>Password: </label>
        <input type="password" placeholder="Enter Password" name="password" value="<?php if(isset($_POST['password'])) echo $_POST['password'];?>" required>


        <button type="submit" class="signupbtn">Register</button>
        </div>
    </form>
  </div>
  <canvas class="parallax"></canvas>
  <?php include "../Html/Footer.html"; ?>
</body>
</html>
