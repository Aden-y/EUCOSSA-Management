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
			$query ="SELECT * FROM EUCOSSA.users WHERE usr_nm=? OR email=?";

			//connect to d
			$run_query=$this->connect()->prepare($query);

			//execute query
			$run_query->execute([$username,$email]);

			//get if there is a user in db
			if($run_query->rowCount()<1){


					//if not found echo out some error js
					echo "<script>alert('Username or Email Not Found')</script>";
					echo "<script>window.open('loginpage.php','_self')</script>";

			}else{


						//if a user is found 
					if($row = $run_query->fetch(PDO::FETCH_ASSOC)) {
						
						//dehash the password and verify the password

							$dehash=password_verify($this->pass,$row['pwd']);

							//if it does not match
							if($dehash==false){

										//echo some error and open the login window
									echo "<script>alert('Username or Password Incorrect')</script>";
									echo "<script>window.open('loginpage.php','_self')</script>";
							}
							elseif($dehash==true){

									//if passwords match

								//create sessions
							$_SESSION['username']=$row['usr_nm'];
							$_SESSION['email']=$row['email'];
							$_SESSION['id']=$row['id'];
							
							//show some success nofication and open the index window
							//echo "<script>alert('Login Successful')</script>";
							header("Location: index.php?msg=logged in Successfully");

							}
					}


						
			}


	}
 }

if(isset($_POST['login'])){

	$username=$_POST['username'];
	$pass=$_POST['password'];

//create an object of the class with its parameters
	$allow = new getUsers($username,$username,$pass);

//call method to authenticate user with its parameters
	$allow->authenticateUser($username,$username,$pass);

}