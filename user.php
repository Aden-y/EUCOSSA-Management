<?php 
//start a new session
session_start();
class User  
{
	private $con;
	
	function __construct()
	{
	include_once("db_Connection.php");
	//create a new Db_connect class
	$this->con=new Db_Connect();
	//create a connection to the database
	$this->con->connect() or die (mysqli_error($this->con));
	}

	//see if the user email already exists in the database** the method is private since we'll only use it from within the function
	private function emailExists($email,$table){
		$sql="SELECT * from '$table' where email='$email' ";
		$result=mysqli_query($this->con,$sql) or die($this->con->error);
		if (mysqli_num_rows($result)>0) {
			return true;
		}else{
			return false;

		}
	}
	//add user details in the database if the email doesnt exist , else return a string message **EMAIL_USED
	public function registerUser($table,$fname,$lname,$email,$reg_number,$password){
		$hashedPassword=password_hash($password,PASSWORD_DEFAULT);
		if ($this->emailExists($email,$table)) {
		  return "EMAIL_USED";
		}else{
		$pre=$this->con->prepare("INSERT into ? values(?,?,?,?,?)");
		$pre->bind_param("ssssss",$table,$fname,$lname,$email,$reg_number,$hashedPassword);
		$result=$pre->execute() or die($this->con->error);
		if ($result) {
			return "REGISTERED";
		}else{
			return "ERROR";
		}

		}

	}
	//verify user login credetials and if valid login user and set session variables. else return a string message PASSWORD_INCORRECT
	//the user will be able to login with either email or reg_number   
	public function userLogin($table,$email_Or_Reg_number,$password){
		$sql="SELECT * from '$table' where email='$email_Or_Reg_number' or reg_number='$email_Or_Reg_number'";
		$result=maysqli_query($this->con,$sql) or die($this->con->error);
		$row=maysqli_fetch_assoc($result);

		if (password_verify($password,$row["password"])) {

			$_SESSION["id"]=$row["User_id"];
			$_SESSION["fname"]=$row["fname"];
			$_SESSION["lname"]=$row["lname"];
			$_SESSION["email"]=$row["email"];
			$_SESSION["reg_number"]=$row["reg_number"];
			//now redirect the user to dashboard page

			
		}else{
			return "PASSWORD_INCORRECT";
		}

	}
	//for changing password
	public function changePassword($table,$email,$password,$new_password){
		$sql="SELECT * from '$table' where email='$email'";
		$result= mysqli_query($this->con,$sql) or die($this->con->error);
		$row=maysqli_fetch_assoc($result);
		if (password_verify($password,$row["password"])) {
			$hashed_password=password_hash($new_password,PASSWORD_DEFAULT);
			$update="UPDATE '$table' set  password= '$hashed_password'where email='$email'";
			$result=mysqli_query($this->con,$update) or die($this->con->error);
			if ($result) {
			return true;
			}else{
				return false;
			}

		}
	}
}

 ?>