<?php
	session_start();

	if(!isset($_SESSION['username'])){

			header('location: loginpage.php');

	}else{	
?>
<!DOCTYPE html>
<html>
<head>
	<title>Home Page</title>
</head>
<body>
	<h1>Welcome <?php echo $_SESSION['username'];?></h1>

</body>
</html>

<?php }?>>