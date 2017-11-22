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
		$stmt=$db->prepare("Select * FROM Users WHERE Username ='" . $_POST["username"] . "'");
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		if(!$row){
			$_SESSION['message']="This user dosent exist in the database";
			//header("Location: Login.php");
			echo "<script> alert('Wrong username or password, try again!')</script>";
		}
		else{

		if($_POST["username"] == $row['Username']){
			if($_POST["password"] == $row['Password']){
				//Starting a new session for the user->login the user
				//echo "<script> alert('USER FOUND IN DATABASE!')</script>";
        $_SESSION['id']= $row['ID'];
				$_SESSION['username']= $row['Username'];
				$_SESSION['u_name']= $row['Namn'];
				$_SESSION['u_add']= $row['Adress'];
				$_SESSION['u_role']= $row['Roll'];


				//echo "<script> alert('Welcome to the store! You are now signed in.'); window.location='/~adasaw-5/root/Php/Account.php?login=success'; </script>";
				header("Location: Account.php?login=success");
				exit();

		}

		}
		}

	}

	?>

    <form name="Login" method="post" action="">
		<div class="alert"> <?=$_SESSION['message']?></div>
		    <div class="container">
            <label>Username</label>
            <input type="text" placeholder="Username" name="username" value="<?php if(isset($_POST['username'])) echo $_POST['username'];?>" required>
			<label>Password</label>
            <input type="password" placeholder="Password" name="password" value="<?php if(isset($_POST['password'])) echo $_POST['password'];?>" required>


            <div class="clear">
                <button type="Login" class="loginbtn">Login</button>

            </div>
        </div>


        </table>
    </form>


</body>
</html>
