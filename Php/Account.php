﻿

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
			<?php 
				if(isset($_SESSION['username'])){
					echo "Welcome " . $_SESSION['u_name']. " you are now logged in <br><br> Account information: <br>" ;
					echo "Username: " . $_SESSION['username']. "<br>";
					echo "Name: " . $_SESSION['u_name']. "<br>";
					echo "Address: " . $_SESSION['u_add']. "<br>";
				
				}
			?>


        </table>
    </form>
 

</body>
</html>
