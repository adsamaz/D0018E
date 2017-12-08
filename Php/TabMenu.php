<?php
  echo '
  <div class="tab">
    <a href="ViewProduct.php?tab=description&ID='.$id.'" class="tablinks">Description</a>
    <a href="ViewProduct.php?tab=ratings&ID='.$id.'" class="tablinks">Ratings</a>
    <a href="ViewProduct.php?tab=comments&ID='.$id.'" class="tablinks">Comments</a>
  </div>';


  if(!isset($_GET['tab']) || $_GET['tab'] == "description"){
    echo '
    <div id="description" class="tabcontent">
      <h3>Description</h3>
      <p>' . $row['Beskrivning'] . '</p>
    </div>';
  }
  else if($_GET['tab'] == "ratings"){
    echo "<div class='ratingsBox'>";
    include "Ratings.php";
    echo "</div>";
  }
  else if($_GET['tab'] == "comments"){
    echo "<div class='commentsBox'>";
    include "Comments.php";
    echo "</div>";
  }
?>
