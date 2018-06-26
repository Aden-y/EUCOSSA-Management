<?php
//include our database connection file
include_once 'db_Connection.php';

//extend to the database
class NewAccount extends Db_Connect{
//parameters to work on...Remember information hiding and /or encapsulation
private $username;//user name from form
private $email;//email of the user from form
private $pwd;//password of the user
private $c_pwd;//just to confirm the password from form
private $hashed_pwd;//the hashed password
private $hashed_c_pwd;//the hashed confirm password
private $time;//time of account creation ... system generated 


//constructor with all parameters... MUST Be Public

public function __construct($username,$email,$pwd,$c_pwd,$hashed_pwd,$hashed_c_pwd,$time){



	$this->username=$username;
	$this->email=$email;
	$this->pwd=$pwd;
	$this->c_pwd=$c_pwd;
	$this->hashed_pwd=$hashed_pwd;
	$this->hashed_c_pwd=$hashed_c_pwd;
	$this->time=$time;

}
//to verify if the email entered by user is alredy used
private function userNameTaken($username){

	$this->username=$username;

	$query="SELECT * FROM EUCOSSA.users WHERE usr_nm=?";
	$pre=$this->connect()->prepare($query);
	$pre->execute([$this->username]);
	$rows=$pre->rowCount();
 
	if ($rows>0) {
		
		return true;
	}else{
		return false;
	}
}

//method that creates the Account with all Parameters as use in construtor
public function createNewAccount($username,$email,$pwd,$c_pwd,$hashed_pwd,$hashed_c_pwd,$time){
	$this->username=$username;
	$this->email=$email;
	$this->pwd=$pwd;
	$this->c_pwd=$c_pwd;
	$this->hashed_pwd=$hashed_pwd;
	$this->hashed_c_pwd=$hashed_c_pwd;
	$this->time=$time;

//pattern of a valid email to be used in preg_match
	$pattern="/^[a-z0-9-_]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i";
	

	//verify if the passwords match
	if (!$this->userNameTaken($this->username)) 
	{
		if(($this->pwd) != ($this->c_pwd))
		{

			//javascript code to alert incase passwords do not match
				echo "<script>alert('Password Do Not Match')</script>";
				echo "<script>window.open('signupPage.php','_self')</script>";
				//echo 'P1='.$this->pwd.'<br> P2='.$this->c_pwd;
				exit();
	
		}else if(!preg_match($pattern, $this->email))
		{

				echo "<script>alert('Invalid Email')</script>";
				echo "<script>window.open('signupPage.php','_self')</script>";
				exit();

		}

		else{

			//insertion query

			$insert="INSERT INTO EUCOSSA.users(usr_nm,email,pwd,day) VALUES ('$this->username','$this->email','$this->hashed_pwd','$this->time')";

			//calls connect method in dtabbase connection class and execute the query
			$insert_results=$this->connect()->exec($insert);


			//notify success in account creation...Java Script
			echo"<script>alert('Account Created Sucessfully')</script>";
			echo"<script>window.open('loginpage.php','_self')</script>;";


		}


	}else

	{
	echo "<script>alert('The user Name is taken')</script>";
	echo "<script>window.open('signupPage.php','_self')</script>";
	exit();
}

			
}

//destructer of the class that ends database connection

public function __destruct(){

}

}

//the action code
//create the account
if(isset($_POST['buttontosignup'])){


	//method to get current date and time



	//get my time zone
	 	function getTheCurrentDate(){

	//get my time zone
	 	$zone = new DateTimeZone('Africa/Nairobi'); 

       $date = new DateTime('now',$zone);

        $currentDate=$date->format('l, F jS, Y, g:i A');

	return $currentDate;
}

	$inusername=$_POST['username'];
	$inemail=$_POST['email'];
	$inpwd=$_POST['password'];
	$inc_pwd=$_POST['conpass'];

	//hash and salt the passwords
	$hashedPwd = password_hash($inpwd,PASSWORD_DEFAULT);
	$hashedinc_Pwd = password_hash($inc_pwd,PASSWORD_DEFAULT);

	//get the date and time the account was created
	$timeCreated=date('y/m/d');

//create the class object and pass in the constructer values in their order
	$myAccount = new NewAccount($inusername,$inemail,$inpwd,$inc_pwd,$hashedPwd,$hashedinc_Pwd,$timeCreated);

//call to the method that create user and pass in values from the html form
	$myAccount->createNewAccount($inusername,$inemail,$inpwd,$inc_pwd,$hashedPwd,$hashedinc_Pwd,$timeCreated);
}