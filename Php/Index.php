<!DOCTYPE html>
<?php	session_start(); ?>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../Css/StandardStyle.css">
</head>
<body>

<?php
  if(isset($_SESSION['username'])){
    include "../Html/LogIN.html";
  }
  else{
    include "../Html/menu.html";
  }
?>

<h3>Welcome</h3>
<p>....ste...</p>

</body>
</html>
