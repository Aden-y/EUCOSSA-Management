<?php
include_once 'db_Connection.php';
include_once 'login.php';


class resetPass extends Db_Connect{

//attributes to login 
	private $username;
	private $email;
	private $pass;

	public function __construct($username,$email,$pass){
		$this->username=$username;
		$this->email=$email;
		$this->pass=$pass;

	}
	public function updatePassword($email,$username,$initial_pass,$new_pass,$con_new_pass){
	if(isset($_SESSION['username']) && isset($_SESSION['email'])){
		//get user details from the database

		$query="SELECT * from EUCOSSA.users where usr_nm=? and email=?";
		$run_query=$this->connect()->prepare($query);
		$run_query->execute([$username,$email]);
		$row = $run_query->fetch(PDO::FETCH_ASSOC);


		//see if the user has entered the correct initial password
		if (password_verify($this->pass,$row['pwd'])) {
			if ($new_pass !=$con_new_pass) {
			echo "<script> alert('Passwords dont match')</script>";
			echo "<script>window.open('resetPasswordPage.php','_self')</script>";
			     exit();
			}else{
//<<<<<<< HEAD
            if(strlen($new_pass)<8){
                echo "<script> alert('Password should be a minimum of 8 characters')</script>";
                echo "<script>window.open('resetPasswordPage.php','_self')</script>";
            }else{
                $update="UPDATE EUCOSSA.users set pwd=? where email=? and usr_nm=?";//the database and table goes here
                $update_run=$this->connect()->prepare($update);
                $update_run->execute([password_hash($new_pass,PASSWORD_DEFAULT),$email,$username]);
                // echo "<script> alert('Password changed successfully')</script>";
                header("Location: index.php?msg=Password updates successfully");
            }

//=======

				if (strlen($new_pass)<8) {
			echo "<script> alert('Password must be atleast 8 characters')</script>";
			echo "<script>window.open('resetPasswordPage.php','_self')</script>";
				}else{
				$update="UPDATE EUCOSSA.users set pwd=? where email=? and usr_nm=?";//the database and table goes here
				$update_run=$this->connect()->prepare($update);
		       $update_run->execute([password_hash($new_pass,PASSWORD_DEFAULT),$email,$username]);
		      // echo "<script> alert('Password changed successfully')</script>";
		       header("Location: index.php?msg=Password updates successfully");
				}
//>>>>>>> 93858fdbd0c313d1ae354a5d7a12b96003928814
			}
			
		}else{
			echo "<script> alert('Enter correct innitial password')</script>";
			echo "<script>window.open('resetPasswordPage.php','_self')</script>";
			exit();

		}

	}else{

			echo "<script> alert('Please Login First To Reset Password')</script>";
			echo "<script>window.open('loginpage.php','_self')</script>";
			exit();

		}	
	}
}


	class PassReset{


		private $email;
		private $pass;
		private $c_pass;

		public function __construct($email,$pass,$c_pass){

			$this->email=$email;
			$this->pass=$pass;
			$this->c_pass=$c_pass;
		}
	

		//method to reset pass from mail
		public function resetPassMailLink($email,$pass,$confim_pwd){

			$hashedpass=password_hash($pass,PASSWORD_DEFAULT);
			$hashedC_pwd=password_hash($confim_pwd,PASSWORD_DEFAULT);

			$pattern="/^[a-z0-9-_]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i";

			if(!preg_match($pattern, $email)){

					echo "<script> alert('Invalid Email')</script>";
					echo "<script>window.open('reset_password.php','_self')</script>";
			}else{


				$query="SELECT * from EUCOSSA.users where email=?";
				$run_query=$this->connect()->prepare($query);
				$run_query->execute([$email]);
				$row = $run_query->fetch(PDO::FETCH_ASSOC);

			if($row<1){

				echo "<script> alert('Email Not Found')</script>";
				echo "<script>window.open('reset_password.php','_self')</script>";
				exit();

			}else
			{
				if(password_verify($pass,$hashedpass) != password_verify($confim_pwd,$hashedC_pwd))
				{

							echo "<script> alert('Passwords Do Not Match')</script>";
						echo "<script>window.open('reset_password.php','_self')</script>";
						exit();

				}else
					{

					$update="UPDATE EUCOSSA.users set pwd=? where email=?";//the database and table goes here
					$update_run=$this->connect()->prepare($update);
			        $update_run->execute($hashedpass,$email);
			        echo "<script> alert('Password changed successfully')</script>";

					}

			}
		}
 	}

}

if(isset($_POST['update'])){
    $email=$_POST['email'];
	$username=$_POST['username'];
	$pass=$_POST['password'];
	$con_pass=$_POST['con_pass'];
	$initial_pass=$_POST['initial_pass'];

	$ChangePassword = new resetPass($username,$email,$initial_pass);

//call method to update password
	$ChangePassword->updatePassword($email,$username,$initial_pass,$pass,$con_pass);

}

//loads default when reset page loads

//if(isset($_POST[/*'email'*/] && $_POST[/*'pass'*/] && $_POST[/*'c_pass'*/])){

//$inemail=$_POST[/*'email'*/];
//$inpass=$_POST[/*'pass'*/];
//$inc_pass=$_POST[/*'c_pass'*/];

//$reset = new PassReset($inemail,$inpass,$inc_pass);

//$reset->resetPassMailLink($inemail,$inpass,$inc_pass);

//}
?>
