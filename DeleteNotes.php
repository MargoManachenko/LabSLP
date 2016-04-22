<?php
	session_start();
	$id = $_POST['noteToDelete'];

	$con = new MongoClient();

	$collection = $con -> notes -> articles;	
	$collection -> remove(array('_id' => new MongoId($id)), array("justOne" => true));
	$con -> close();

	
	header('Location: /MyPage.php');

 ?>


