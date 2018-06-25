<?php
include_once 'db_Connection.php';

class ForgotPass extends Db_Connect{

	private $email;

	public function __construct($email){

		$this->email=$email;


	}

	protected function getUserEmail($email){

		//to verify if the email entered by user is alredy used

	$this->email=$email;

	$pattern="/^[a-z0-9-_]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i";

	if(!preg_match($pattern, $this->email)){

				echo "<script>alert('Invalid Email')</script>";
				echo "<script>window.open('forgotpwd.php','_self')</script>";
				exit();

		}else{


	$query="SELECT * FROM EUCOSSA.users WHERE email=?";
	$pre=$this->connect()->prepare($query);
	$pre->execute([$this->email]);
	$rows=$pre->rowCount();
 
	if ($rows>0) {
		

		//get the email to send mail
		return $this->email;
	}else{

		echo "<script>alert('Email Not Found')</script>";
		echo "<script>window.open('forgotpwd.php','_self')</script>";
		exit();

		
		}

	}
}

//destruction method
public function __destruct(){


}
}

//added this class on the same file  coz we cannot send form  action on 2 different pages

class ConfirmMail extends ForgotPass {

		private $email

		public function __construct($email){

			$this->email= $email;
		}

		public function sendConfirmMail($email){

			$this->email=$email
			$subject="Reset Password";
			$recipient=$this->getUserEmail($this->email);

			//body of the mail from with link to password reset page
			$body='To reset your password"<a href="http://127.0.0.1/reset_password.php>Clic Here</a>" and reset. Dont Reply';

			$send= mail($recipient, $subject, $body,"From\r\n");

			if(!$send){
				//will be removed if mail function works
				echo "<script>alert('Mail not Send')</script>";
				echo "<script>window.open('forgotpwd.php','_self')</script>";
			}

			else{
					//will be removed if mail function works
				echo "<script>alert('Mail Send')</script>";
				echo "<script>window.open('login.php','_self')</script>";
			}

		}

		public function __destruct(){


		}
	}


if(isset($_POST['forgotpwd'])){

	$inemail = $_POST['email'];

	$forgot = new ConfirmMail($inemail);
	$forgot = new sendConfirmMail($inemail);

}