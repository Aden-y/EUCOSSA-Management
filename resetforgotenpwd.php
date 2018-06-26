<?php 
include_once 'login.php';
if (!isset($_SESSION['username'])) {
   header("Location:loginpage.php?msg=please login first");

}else{
	?>

   <!DOCTYPE html>
   <html>
   <head>
   	<title>Reset password</title>
   </head>
   <body>
   	<form method="POST" action="resetpassword.php">
      
         <input type="email" name="email" placeholder="Email"><br><br>
         <input type="password" name="pwd" placeholder="Password"><br><br>
         <input type="password" name="c_pwd" placeholder="Confirm Password"><br><br>
         <input type="submit" name="newpass" Value="RESET">

   	</form>
   
   </body>
   </html>


	<?php
}


 ?>