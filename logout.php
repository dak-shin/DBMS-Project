<?PHP

	session_start();
	if(isset($_SESSION['username']))
	{
		session_destroy();
	}
	header('Location: http://localhost/scripts/')

?>