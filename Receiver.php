



<!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">

  <title>The HTML5 Herald</title>
  <meta name="description" content="The HTML5 Herald">
  <meta name="author" content="SitePoint">

  <link rel="stylesheet" href="css/styles.css?v=1.0">

  <!--[if lt IE 9]>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
  <![endif]-->
  
</head>

<body>
  
 <?php
	//;charset=utf8mb4
	$name = $_POST['firstname'];
	echo $name;
	
	try{
		$db = new PDO('mysql:host=127.0.0.1;port=3306;dbname=adasaw5db', 'adasaw-5', '1234');
	}
	catch(Exception $e){
		
		echo $e->getMessage();
	}
	
	
	//$stmt = $db->prepare("INSERT INTO test1(name,lastname) VALUES($name,'hej')");
	//$stmt->execute();
	$stmt = $db->prepare("INSERT INTO test1(name,lastname) VALUES(:name,:lastname)");
	$stmt->execute(array(':name' => $name, ':lastname' => 'hej'));
	//$stmt = $db->prepare("SELECT * FROM test1");
	//$stmt->execute();
	
//	$row=$stmt->fetch();
	
	//echo $row['name'];
	

?>
  
</body>
</html>