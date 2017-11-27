<!DOCTYPE html>
<?php session_start();?>

<html>
<head>

  <link rel="stylesheet" type="text/css" href="../Css/StandardStyle.css">

</head>

<body>
<?php
	try{
		$db = new PDO('mysql:host=127.0.0.1;port=3306;dbname=adasaw5db', 'adasaw-5', '1234');
	}
	catch(Exception $e){
		echo $e->getMessage();
	}
        $id = $_GET['ID'];

        $stmt = $db->prepare("SELECT * FROM Kommentarer WHERE Produkter_ID=$id");
        $stmt->execute();

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        $Comment = $row['Kommentar'];
        $uID = $row['Users_ID'];

        $stmtU = $db->prepare("SELECT * FROM Users WHERE ID=$uID");
        $stmtU->execute();

        $rowU = $stmtU->fetch(PDO::FETCH_ASSOC);

        echo "<b>" . $rowU['Username'] . "</b><br>";
        echo " <b>Comment:</b> " . $Comment . "<br />";
      }

        if($_SERVER['REQUEST_METHOD']=='POST'){

          if (isset($_POST['rating'])){
              echo "LÖSER RATING EFTER DAGENS MÖTE MED Uffe";
          }

          else if (isset($_POST['Comment'])){
          $stmtE = $db->prepare("SELECT * FROM Kommentarer WHERE Users_ID='".($_SESSION['u_ID'])."' AND Produkter_ID=$id");
          $stmtE->execute();
          $rowE = $stmtE->fetch(PDO::FETCH_ASSOC);
          if($rowE['Users_ID']!=NULL){
            echo "You can only post one comment per product";
          }else{
          $stmtPost = $db->prepare("INSERT INTO Kommentarer (Users_ID,Produkter_ID,Kommentar) VALUES ('".($_SESSION['u_ID'])."','".$id."','".$_POST['Comment']."')");
          $stmtPost->execute();
          header("Location: Comments.php?ID=$id");
          }
        }


	}
	?>

  <form action="" method="post">
    <label for="antal">Write a comment:</label>
    <input type="text" id="Comment" name="Comment" value="<?php if(isset($_POST['Comment'])) echo $_POST['Comment'];?>">
    <input type="submit" id="btnSubmit" name="btnSubmit" value="Comment">

  </form>
  <form name="Rate" method="post" action=""><br>
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
</div>

</body>
</html>
