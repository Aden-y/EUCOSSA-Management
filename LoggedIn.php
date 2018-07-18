<?php
include "db_Connection.php";
session_start();
class user extends Db_Connect{
  public function deleteAccount($pass){
      $query ="SELECT * FROM EUCOSSA.users WHERE usr_nm=? OR email=?";
      $this->connect();
      $run_query=$this->connect()->prepare($query);

			//execute query
      $run_query->execute([$_SESSION['username'],$_SESSION['email']]);
      if($run_query->rowCount()<1){


					//if not found echo out some error js
					echo "<script>alert('Username or Email Not Found')</script>";
					echo "<script>window.open('index.php','_self')</script>";

      }else{


						//if a user is found 
					if($row = $run_query->fetch(PDO::FETCH_ASSOC)) {
						
						//dehash the password and verify the password

							$dehash=password_verify($pass,$row['pwd']);

							//if it does not match
							if($dehash==false){

										//echo some error and open the login window
									echo "<script>alert('Password Incorrect')</script>";
									echo "<script>window.open('pwd_to_delete.php','_self')</script>";
							}
							elseif($dehash==true){

								//if passwords match
                                echo "<script>if(confirm('Are you sure you want to delete your account')){
                                window.location.href='delete.php';
                                }
                                </script>";
                               
							}
					}
						
			}
  }
}

if(isset($_POST['deleteAccount'])){
    
    $pass = $_POST['pwd_delete'];
    $currentUser = new user();
    $currentUser->deleteAccount($pass);
}

?>