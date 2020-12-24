<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
</head>
<body>
	<form action="sample.php" method="post">
		<h2>Sign up page</h2>
		<label for="userid">Userid 
			<input type="text" name="userid" autocomplete="off" placeholder="69">
		</label><br>
		<label for="username">Username 
			<input type="text" name="username" autocomplete="off" placeholder="Michael1234">
		</label><br>
		<label for="password"> password
			<input type="text" name="password" autocomplete="off" >
		</label><br>
		<input type="hidden" name="make" value="yes">
		<input type="submit" value="Create user">
	</form>
	<form action="sample.php" method="post">
		<h2>Login up page</h2>
		<label for="userid">Userid 
			<input type="text" name="userid" autocomplete="off" placeholder="69">
		</label><br>
		<label for="username">Username 
			<input type="text" name="username" autocomplete="off" placeholder="Michael1234">
		</label><br>
		<label for="password"> password
			<input type="text" name="password" autocomplete="off" >
		</label><br>
		<input type="hidden" name="enter" value="yes">
		<input type="submit" value="Login">
	</form>

	<form action="sample.php" method="post">
		<input type="hidden" name="logout" value="yes">
		<input type="submit" value="Logout">
	</form>
	<?php

		require_once 'test.php';
		$connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);


		function san_ip($var)
		{
			$var = stripslashes($var);
			$var = htmlentities($var);
			$var = strip_tags($var);
			return $var; 
		}
		if(isset($_POST['make']))
		{
			if(san_ip($_POST['make']) == 'yes')
			{
				$user_id = san_ip($_POST['userid']);
				$user_name = san_ip($_POST['username']);
				$pwd = san_ip($_POST['password']);
				$query = "Insert into sample values ($user_id ,'$user_name', '$pwd' )";
				$result = $connection->query($query);
				if(!$result) 
					echo "<h3> $connection->error </h3>";
				else 
					echo "<h2>User account created successfully</h2>";
			}
			

		}
		elseif(isset($_POST['enter']))
		{

			$user_id = san_ip($_POST['userid']);
			$user_name = san_ip($_POST['username']);
			$pwd = san_ip($_POST['password']);
			$query = "Select * from sample where username='$user_name'";
			$result = $connection->query($query);
			if(!$result) 
				echo "<h3> $connection->error </h3>";
			else 
				$user_id = san_ip($_POST['userid']);
				$user_name = san_ip($_POST['username']);
				$pwd = san_ip($_POST['password']);
				setcookie('username',$username,time()+2592000,'/');
				echo "welcome ".$username;

		}
		elseif (isset($_COOKIE['username'])) {
			# code...
			echo "welcome ".$_COOKIE['username'] ;
		}
		elseif (isset($_POST['logout'])) {
			# code...
		setcookie('username',$username,time()-2592000,'/');
		}
	?>
</body>
</html>