<?php  
    session_start();
	if (isset($_POST[/*'logout button'*/])) 
	{
		    session_unset();
	    	session_destroy();
	    header('location: login.php');
	}
?>