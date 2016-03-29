<?php
session_start();
if(isset($_POST["logout"]))
	{
		unset($_SESSION["session_name"]);
		session_destroy();
		header('Refresh:0;URL=http://calendar/registry.php');
	}
if (!isset($_SESSION["session_name"]))
	{
		echo "You are not logged in.<p> Visit <a href = 'http://calendar/registry.php'>Registration page</a></p>";
		exit();
	}	
	echo 
		'You '.$_SESSION["session_name"].' are logged in
		<form method = "post" action = "MyPage.php">
		<input type = "submit" name = "logout" value = "Log out"></input>
		</form>';
	$NoteTitle = $_POST['title'];
	$NoteText = $_POST['note'];
	$Message = "";
	if (!empty($NoteText) && !empty($NoteTitle))
	{
		$con = new MongoClient();
		$collection = $con -> notes -> articles;		
		$user = array('name' => $_SESSION["session_name"], 'title' => $NoteTitle, 'text' => $NoteText);
		$collection -> insert($user);
		$Message = "Note successfully created";
		$con -> close();
	}
	$con = new MongoClient();
	$collection = $con -> notes -> articles;
	//$CheckUser = $collection -> findOne(array('name' => $_SESSION["session_name"]));
	$CurrNote = $collection ->find();
	while($document = $CurrNote->getNext())	{
		if ($_SESSION["session_name"] == $document["name"]){
		echo "<p> Name:".$document["title"]."</br>";
		echo "Login:".$document["name"]."</br>";
		echo "Note:".$document["text"]."</p>";
		}
	}
	$con -> close();
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<form method="post" action="MyPage.php">
<p><input type="text" name="title"></input>
<p><textarea name="note"></textarea></p>
<p><input type="submit" name="submit" value="Create"></input></p>
</form>
</body>
</html>
