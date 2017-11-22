﻿<html>
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
