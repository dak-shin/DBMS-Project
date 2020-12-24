<?php
	require_once 'test.php';
	$connection =  new mysqli($db_hostname, $db_username, $db_password, $db_database);

	if($_POST['create_user'] == 'yes')
	{	$id = 1; 
		$username = $_POST['username'];
		$password = $_POST['password'];
		$query = "Insert into sample values"." ($id,'$username', '$password' )";
		$id++;
		$result = $connection->query($query);
		if (!$result) 
			echo "INSERT failed: $query<br>" .$connection->error . "<br><br>";
		else
			echo "<h2>Account created successfully</h2>";
	}
	else
	{
		echo "Nothing submitted";
	}

?>
