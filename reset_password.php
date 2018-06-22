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

		$query="SELECT * from/* EUCOSA.users */where email=? and name=?";
		$run_query=$this->connect()->prepare($query);
		$run_query->execute([$username,$email]);
		$row = $run_query->fetch(PDO::FETCH_ASSOC);
		//see if the user has entered the correct innitial password
		if (password_verify($this->pass,$row['password'])) {
			if (password_verify($new_pass,password_hash($new_pass,PASSWORD_DEFAULT)) !=password_verify($con_new_pass,password_hash($con_new_pass,PASSWORD_DEFAULT))) {
			echo "<script> alert('Passwords dont match')</script>";
			}else{
				$update="UPDATE /*EUCOSA.users*/ set password=? where email=? and name=?";//the database and table goes here
				$update_run=$this->connect()->prepare($update);
		       $update_run->execute([password_hash($new_pass,PASSWORD_DEFAULT),$email],$username);
		       echo "<script> alert('Password changed successfully')</script>";

			}
			
		}else{
			echo "<script> alert('Enter correct innitial password')</script>";

		}

	}	
	}


 }

if(isset($_POST[/*'update'*/])){
    $email=$_SESSION['email'];
	$username=$_SESSION['username'];
	$pass=$_POST[/*'password'*/];
	$con_pass=$_POST[/*'con_pass'*/];
	$initial_pass=$_POST[/*'initial'*/];

	$allow = new resetPass($username,$email,$initial_pass);

//call method to update password
	$allow->updatePassword($email,$username,$initial_pass,$pass,$con_pass);

}
?>
