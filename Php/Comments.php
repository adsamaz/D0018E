
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

  while($rowC = $stmt->fetch(PDO::FETCH_BOTH))
  {
    $User="";
    $Comment="-";

    $Comment = $rowC['Kommentar'];
    $uID = $rowC['Users_ID'];
    $stmtU = $db->prepare("SELECT * FROM Users WHERE ID=$uID");
    $stmtU->execute();
    $rowU = $stmtU->fetch(PDO::FETCH_ASSOC);
    $User=$rowU['Username'];

	  echo "<b>" . $User . " - </b>";
	  echo " <b>Comment:</b> " . $Comment . "<br/>";
	}

  if($_SERVER['REQUEST_METHOD']=='POST'){
  	if (isset($_POST['Comment'])){
	    $stmtE = $db->prepare("SELECT * FROM Kommentarer WHERE Users_ID='".($_SESSION['u_ID'])."' AND Produkter_ID=$id");
	    $stmtE->execute();
	    $rowE = $stmtE->fetch(PDO::FETCH_ASSOC);
	    if($rowE['Users_ID']!=NULL){
	      $stmtPost = $db->prepare("UPDATE Kommentarer SET Kommentar ='".$_POST['Comment']."' WHERE Kommentarer.Users_ID=".($_SESSION['u_ID'])." AND Kommentarer.Produkter_ID=".$id."");
	      $stmtPost->execute();
		  }
			else{
		    $stmtPost = $db->prepare("INSERT INTO Kommentarer (Users_ID,Produkter_ID,Kommentar) VALUES ('".($_SESSION['u_ID'])."','".$id."','".$_POST['Comment']."')");
		    $stmtPost->execute();
		  }
			header("Refresh:0");
  	}
	}
	?>

  <form name="Comment" action="" method="post">
    <label for="antal">Write a comment:</label>
    <input type="text" id="Comment" name="Comment" value="<?php if(isset($_POST['Comment'])) echo $_POST['Comment'];?>">
    <input type="submit" id="btnSubmit" name="btnSubmit" value="Comment">
  </form>
