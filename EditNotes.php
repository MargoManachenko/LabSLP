<?php 
session_start();
$id = $_POST['noteToEdit'];         
$con = new MongoClient(); 
$collection = $con -> notes -> articles;  
$note = $collection->findOne(array('_id' => new MongoId($id)));        
 
$out = "<form method='post' action='EditCurrent.php'  >
	
	<p><input class='form-control' type='text' name= 'title' autocomplete='off' value = ".$note['title']."></input></p>
	<p><textarea class='form-control' autocomplete='off' name= 'text' >".$note['text']."</textarea></p>
	<input type='button'  class='btn btn-default' onClick='location.href=`MyPage.php`' value='Back'></input>

	<input hidden name='noteToEdit' value = ".$note['_id']."></input>
	<input type='submit'  class='btn btn-default' name='save' value='Save'></input>

	</form>";

$con -> close();
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Edit</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/styleMYPage.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
  <center>
    <h1>Edit</h1>
    <?php echo $out; ?>
    </center>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
