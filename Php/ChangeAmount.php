<?php
session_start();

try{
$db = new PDO('mysql:host=127.0.0.1;port=3306;dbname=adasaw5db', 'adasaw-5', '1234');
}
catch(Exception $e){

  echo $e->getMessage();
}

if(isset($_SESSION['username'])){
  $ID = $_GET['ID'];
  $action = $_GET['action'];

  if($action == "increase"){
      $sql = $db->prepare("UPDATE Kundvagn SET Antal = Antal + 1 WHERE Kundvagn.Produkter_ID = $ID");
      $sql->execute();
  }

  else if($action == "decrease"){
      $sql = $db->prepare("UPDATE Kundvagn SET Antal = Antal - 1 WHERE Kundvagn.Produkter_ID = $ID");
      $sql->execute();

      $sql2 = $db->prepare("SELECT Antal FROM Kundvagn WHERE Kundvagn.Produkter_ID = $ID");
      $sql2->execute();
      $row = $sql2->fetch(PDO::FETCH_ASSOC);
      if($row['Antal'] <= 0){
        $sql3 = $db->prepare("DELETE FROM Kundvagn WHERE Kundvagn.Produkter_ID = $ID");
        $sql3->execute();
        $sqlDelK = $db->prepare("DELETE FROM Kundvagn WHERE Kundvagn.Produkter_ID = $ID");
        $sqlDelK->execute();
      }
  }
}
header("Location: Kundvagn.php");

?>
