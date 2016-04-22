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
		
		//include 'OperPage.php';
			echo 
			'You logged in as <h3>'.$_SESSION["session_name"].'</h3>
			<form method = "post" action = "MyPage.php">
			<input type = "submit" class="btn btn-default" name = "logout" value = "Log out"></input>
			</form>';

		$con = new MongoClient();
		$collection = $con -> notes -> articles;
		//$CheckUser = $collection -> findOne(array('name' => $_SESSION["session_name"]));
		$CurrNote = $collection ->find();
		while($document = $CurrNote->getNext())	{
			if ($_SESSION["session_name"] == $document["name"]){

				echo "<div class='container'>
						<div class='row'>
					        <div class='note'>
						         <div class='col-md-2'><p>".$document["title"]."</div>
						         <div class='col-md-4'>".$document["text"]."</p></div>

                                
						         <form method = 'post' class='navbar-form pull-left' action = 'DeleteNotes.php'>
						         <input hidden name='noteToDelete' value=".$document['_id']."></input>
								 <input type = 'submit' class='btn btn-default' name = 'delete' value = 'Delete'></input>
								 </form>							

								 <form method = 'post' class='navbar-form pull-left' action = 'EditNotes.php'>
						         <input hidden name='noteToEdit' value=".$document['_id']."></input>
								 <input type = 'submit' class='btn btn-default' name = 'edit' value = 'Edit'></input>
								 </form>			

								 </div>

							</div>
					    </div>
				      </div>";
				  }
				} 
$con -> close();
		
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Home page</title>

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
  <!-- Trigger the modal with a button -->
<button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal">Create</button>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Just start printing!</h4>
      </div>
      <div class="modal-body">
        <p>Title</p>
        <form method="post" action="OperPage.php">
			<p><input class="form-control" type="text" autocomplete="off" name="title"></input></p>
			<p>Note</p>
			<p><textarea class="form-control" rows="7" autocomplete="off" name="note"></textarea></p>
			<p><input type="submit" id="close" class="btn btn-default" name="submit" value="Create"></input></p>
			<!--<script type="text/javascript">
				close.onclick = function() {
					$('#myModal').modal('hide')};
			</script>-->
		</form>
      </div>
    </div>   
  </div>
</div>



								 






<!--<script>
    $(document).ready(function(){
        $('#EditBID').click(function(){
            $.ajax( {
                type: "GET",
                url: 'EditNotes.php',
                data: $('#firmID').serialize(),
                success: function(response) {
                    $('#response').html(response);
                }
            } );
        });
    });
</script>-->



  	<div class="container">
		<div class="row">
			<div class="col-lg-8 col-md-8 col-sm-6 col-xs-4"></div>
		</div>
	</div>	
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.js"></script>
  </body>
</html>