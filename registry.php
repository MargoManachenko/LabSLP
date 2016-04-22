<?php
/////"Register" (add account to DB) 
	$name = $_POST['login'];
	$pass = $_POST['password'];
	$rpass = $_POST['r_password'];
	$errorResult = "Login is taken, enter another login";	
	$errorResultPass = "Passwords do not match";
	$registrMessage = "";
	if(!empty($name) && !empty($pass) && !empty($rpass))
	{

		$con = new MongoClient();
		$collection = $con -> notes -> users;
		$CheckUser = $collection -> findOne(array('name' => $name));
		if(empty($CheckUser))
		{
			if ($pass == $rpass)
			{
				$user = array('name' => $name, 'password' => md5($pass));
				$collection -> insert($user);
				$registrMessage = "Registration is successfull";

			}
		}
		$con -> close();
	}

/////"Log in" (check account)
	$Aname = $_POST['Alogin'];
	$Apass = $_POST['Apassword'];
	$errorAMessage = "Login or password error";
	if (!empty($Aname) && !empty($Apass))
	{
		$errorMessage = "Login or password error";
		$con = new MongoClient();
		$collection = $con -> notes -> users;
		$user = $collection -> findOne(array('name' => $Aname));
		if (!empty($user)){
			if ($user['password'] == md5($Apass))
			{
				//setcookie("id", $user['_id']);
				session_start();
				$_SESSION["session_name"] = $Aname;
		 		header('Location: /MyPage.php');
			}		
			
		}	
		$con -> close();
	}	
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Registry</title>

    <!-- Bootstrap -->
	<link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
  <div class="container"> 
	
	<form method = "post" action = "registry.php">
	<h2 class="form-signin-heading">Please sign in</h2>
	<input type = "email" class="form-control" placeholder = "Email address" name = "login" autocomplete="off" required /><br>
	<input type = "password" class="form-control" placeholder = "Password" name = "password" required pattern = "(?=^.{6,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" autocomplete="off" required /><br>
	<input type = "password" class="form-control" placeholder = "Confirm password" name = "r_password" required /><br>
	<?php
		if (!empty($CheckUser))
			echo $errorResult;
		if ($pass != $rpass)
			echo $errorResultPass;
		else
			echo $registrMessage;
	?><br>

	<input type = "submit" class="btn btn-lg btn-primary btn-block" name = "submit" value = "Register" />	
	</form>
	<h1>Log in</h1>
<form method = "post" action = "registry.php"><br>
	<input type = "text" placeholder = "Login or e-mail" name = "Alogin" autocomplete="off" required /><br>
	<input type = "password" placeholder = "Password" name = "Apassword" autocomplete="off" required /><br>
	<?php			
		if(empty($user))
			echo $errorMessage;
	?>
	<br>
	<label class="checkbox">
    	<input type="checkbox" value="remember-me"> Remember me
    </label>
	<input type = "submit" name = "submit" value = "Log in" />
	</div>


	<!--<div class="container">

      <form class="form-signin" role="form">
        <h2 class="form-signin-heading">Please sign in</h2>
        <input type="email" class="form-control" placeholder="Email address" required autofocus>
        <input type="password" class="form-control" placeholder="Password" required>
        
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
      </form>

    </div> <!-- /container -->

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>