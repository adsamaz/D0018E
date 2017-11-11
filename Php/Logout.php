<html>
    <style>

</head>

<body>
  
<?php 
	session_start();
	session_destroy();
	Header("Location: Login.php");
	?>

    
</html>
