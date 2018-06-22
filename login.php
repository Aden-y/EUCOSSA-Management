<?php

session_start();

include_once 'db_Connection.php';


class getUsers extends Db_Connect{

//attributes to login
	private $username;
	private $email;
	private $pass;

	public function __construct($username,$email,$pass){
		$this->username=$username;
		$this->email=$email;
		$this->pass=$pass;

	}

	//authentication methods

	public function authenticateUser($username,$email,$pass){

			$this->username=$username;
			$this->email=$email;
			$this->pass=$pass;

			//SQL query to search if username exists
			$query ="SELECT * FROM all_project_tests.users WHERE user_nm=? OR email=?";

			//connect to d
			$run_query=$this->connect()->prepare($query);

			//execute query
			$run_query->execute([$username,$email]);

			//get if there is a user in db
			if($run_query->rowCount()<1){


					//if not found echo out some error js
					echo "<script>alert('Username or Email Not Found')</script>";
					echo "<script>window.open('login.php','_self')</script>";

			}else{


						//if a user is found 
					if($row = $run_query->fetch(PDO::FETCH_ASSOC)) {
						
						//dehash the password and verify the password

							$dehash=password_verify($this->pass,$row['pwd']);

							//if it does not match
							if($dehash==false){

										//echo some error and open the login window
									echo "<script>alert('Username or Password Incorrect')</script>";
									echo "<script>window.open('login.php','_self')</script>";
							}
							elseif($dehash==true){

									//if passwords match

								//create sessions
							$_SESSION['session name']=$row[/*'user name from db'*/];
							$_SESSION['email']=$row[/*'email from db'*/];
							
							//show some success nofication and open the index window
							echo "<script>alert('Login Successful')</script>";

							}
					}


						
			}


	}
 }

if(isset($_POST['signin'])){

	$username=$_POST[/*'username or email from form'*/];
	$pass=$_POST[/*'password from form'*/];

//create an object of the class with its parameters
	$allow = new getUsers($username,$username,$pass);

//call method to authenticate user with its parameters
	$allow->authenticateUser($username,$username,$pass);

}