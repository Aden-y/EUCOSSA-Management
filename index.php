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

	<a href="resetPasswordPage.php">Reset password</a><br><br>

	<a href="logout.php">Log out</a><br><br>
    <form action="loggedIn.php" method="post">
    <input type=submit value="Delete Account" name="deleteAccount"/>
    
    </form>
</body>
</html>

<?php }?>