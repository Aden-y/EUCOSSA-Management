<?php
	session_start();

	if(!isset($_SESSION['username'])){

			header('location: loginpage.php?msg=please login first');

	}else{	
?>
<!DOCTYPE html>
<html>
<head>
	<title>Home Page</title>
</head>
<body>
	<h1>Welcome <?php echo $_SESSION['username'];?></h1>
	<a href="resetPasswordPage.php">Reset password</a>


</body>
</html>

<?php }?>>