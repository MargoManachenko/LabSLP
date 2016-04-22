<?php
	session_start();
	$NoteTitle = $_POST['title'];
	$NoteText = $_POST['note'];
		if (!empty($NoteText) && !empty($NoteTitle))
		{
			$con = new MongoClient();
			$collection = $con -> notes -> articles;		
			$user = array('name' => $_SESSION["session_name"], 'title' => $NoteTitle, 'text' => $NoteText);
			$collection -> insert($user);
			$con -> close();			            
		}
	header('Location: /MyPage.php');

	
?>