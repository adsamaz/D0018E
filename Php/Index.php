<!DOCTYPE html>
<?php	session_start(); ?>
<html>
<head>
  <meta charset="utf-8" />
  <link rel="icon" type="image/png" href="https://febrezeinwash.com/wp-content/themes/febreze/images/smoke_icon_vector.png">
  <link rel="stylesheet" type="text/css" href="../Css/FooterStyle.css">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="../Css/StandardStyle.css">
  <link rel="stylesheet" type="text/css" href="../Css/Home.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script type="text/javascript" src="../Javascript/Smoke.js"></script>
  <script type="text/javascript" src="../Javascript/ActiveLink.js"></script>
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

  <canvas class="parallax"></canvas>
  <div id="wrap">

    <h3>Welcome to VapeNation</h3>
    <p>Here you will find a wide range of Vapes and E-juice for both beginners and experts.
      High level of service and customer satisfaction has been the base of our business since we opened in 1337AD. We are certified by Nordic Vapeing, so you can feel safe when you shop from us.
      If you have any questions, please contact us and we will help you!</p>

  </div>
  <canvas class="parallax"></canvas>
  <?php include "../Html/Footer.html"; ?>

</body>
</html>
