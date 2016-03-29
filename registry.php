<?php
/////"Register" (add account to DB) 
	$name = $_POST['login'];
	$pass = $_POST['password'];
	$rpass = $_POST['r_password'];
	$errorResult = "Login is taken, enter another login";	
	$errorResultPass = "Passwords do not match";
	$registrMessage = "";
	if(!empty($name) && !empty($pass))
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
		 		header('Refresh:0;URL=http://calendar/MyPage.php');
			}		
			
		}	
		$con -> close();
	}	
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<p>Please sign in</p>
<form method = "post" action = "registry.php">
	
	<input type = "email" placeholder = "E-mail" name = "login" required /><br>
	<input type = "password" placeholder = "Password" name = "password" required pattern = "(?=^.{6,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" required /><br>
	<input type = "password" placeholder = "Confirm password" name = "r_password" required /><br>
	<?php
		if (!empty($CheckUser))
			echo $errorResult;
		if ($pass != $rpass)
			echo $errorResultPass;
		else
			echo $registrMessage;
	?><br>
	<input type = "submit" name = "submit" value = "Register" />	
</form>
<form method = "post" action = "registry.php"><br>
	<input type = "text" placeholder = "Login or e-mail" name = "Alogin" required /><br>
	<input type = "password" placeholder = "Password" name = "Apassword" required /><br>
	<?php			
		if(empty($user))
			echo $errorMessage;
	?>
	<br>
	<input type = "submit" name = "submit" value = "Log in" />
</form>
</body>
</html>