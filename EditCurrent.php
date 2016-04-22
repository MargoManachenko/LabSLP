<?php
	session_start();
	$NoteTitle = $_POST['title'];
	$NoteText = $_POST['text'];
	$id = $_POST['noteToEdit'];


	if (!empty($NoteText) && !empty($NoteTitle))
	{
	$con = new MongoClient();
	$collection = $con -> notes -> articles;	
	$newDocs = array('name' => $_SESSION["session_name"],'title' => $NoteTitle, 'text' => $NoteText);
	$collection -> update(array('_id' => new MongoId($id)), $newDocs, array("upset" => true));
	
	
	$con -> close();
}
	header('Location: /MyPage.php');

?>