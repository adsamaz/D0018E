<?php

try{
  $db = new PDO('mysql:host=127.0.0.1;port=3306;dbname=adasaw5db', 'adasaw-5', '1234');
}
catch(Exception $e){
  echo $e->getMessage();
}

$id = $_GET['ID'];
$TotalRating=0;
$SummaRating=0;
$SlutRating=0;
$stmtR = $db->prepare("SELECT * FROM Ratings WHERE Produkter_ID=$id");
$stmtR->execute();

while(($rowR = $stmtR->fetch(PDO::FETCH_BOTH)))
{
  $User="";
  $RatingE="-";


  $uID = $rowR['Users_ID'];
  $stmtU = $db->prepare("SELECT * FROM Users WHERE ID=$uID");
  $stmtU->execute();
  $rowU = $stmtU->fetch(PDO::FETCH_ASSOC);
  $User=$rowU['Username'];
  $stmtRate = $db->prepare("SELECT * FROM Ratings WHERE Users_ID=$uID AND Produkter_ID=$id");
  $stmtRate->execute();
  $rowRate = $stmtRate->fetch(PDO::FETCH_ASSOC);
  $Rating = $rowR['Rating'];
  //$RatingE = (string)$Rating;
  $TotalRating+=$Rating;
  $SummaRating++;

  echo "<b>" . $User . " - </b>";
  echo " <b>Rating:</b> ".$Rating." <br /> <br>";

}

if($TotalRating!=0 && $SummaRating!=0){
  $SlutRating=($TotalRating/$SummaRating);
}
echo "<b>General rating:</b> ". round($SlutRating, 1) ."<br>";

if($_SERVER['REQUEST_METHOD']=='POST'){
  if (isset($_POST['rating'])){
    $stmtC = $db->prepare("SELECT * FROM Ratings WHERE Users_ID='".($_SESSION['u_ID'])."' AND Produkter_ID=$id");
    $stmtC->execute();
    $rowC = $stmtC->fetch(PDO::FETCH_ASSOC);
    if($rowC['Users_ID']!=NULL){
      $stmtPost = $db->prepare("UPDATE Ratings SET Rating =".$_POST['rating']." WHERE Ratings.Users_ID =".($_SESSION['u_ID'])." AND Ratings.Produkter_ID =".$id."");
      $stmtPost->execute();
    }
    else{
      $stmtPost = $db->prepare("INSERT INTO Ratings (Users_ID,Produkter_ID,Rating) VALUES ('".($_SESSION['u_ID'])."','".$id."','".$_POST['rating']."')");
      $stmtPost->execute();
    }
    header("Refresh:0");
  }
}
?>

<form name="Rate" method="post" action=""><br>
<label> Rate this product <br> </label>
<input type="radio" id="ratingETT" name="rating" value="1" onclick="this.form.submit();" />
<label for="ratingETT">1</label>
<input type="radio" id="ratingTVA" name="rating" value="2" onclick="this.form.submit();"/>
<label for="ratingTVA">2</label>
<input type="radio" id="ratingTRE" name="rating" value="3" onclick="this.form.submit();"/>
<label for="ratingTRE">3</label>
<input type="radio" id="ratingFYRA" name="rating" value="4" onclick="this.form.submit();"/>
<label for="ratingFYRA">4</label>
<input type="radio" id="ratingFEM" name="rating" value="5" onclick="this.form.submit();"/>
<label for="ratingFEM">5</label>
</form>
