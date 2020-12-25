<?PHP

	session_start();
	if(isset($_SESSION['admin_name']))
	{
		session_destroy();
	}
	header('Location: http://localhost/scripts/')

?>