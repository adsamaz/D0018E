<?php
  echo '
  <div class="tab">
    <a href="ViewProduct.php?tab=description&ID='.$id.'" class="tablinks">Description</a>
    <a href="ViewProduct.php?tab=ratings&ID='.$id.'" class="tablinks">Ratings</a>
    <a href="ViewProduct.php?tab=comments&ID='.$id.'" class="tablinks">Comments</a>
  </div>';


  if(!isset($_GET['tab']) || $_GET['tab'] == "description"){
    echo '
    <div id="Description" class="tabcontent">
      <h3>Description</h3>
      <p>' . $row['Beskrivning'] . '</p>
    </div>';
  }
  else if($_GET['tab'] == "ratings"){
    include "Ratings.php";
  }
  else if($_GET['tab'] == "comments"){
    include "Comments.php";
  }
?>
