<?php
include "db_Connection.php";
//Inherit session variables
session_start();

//Class to connect to database and delete account
class deleteAccount extends DB_Connect{
    function __construct(){
        
        $this::perform();
    }
    //Function to delete account from database
    function perform(){
        if(isset($_SESSION['username']) && isset($_SESSION['email'])){
           
            //Get variables from session
            $user = $_SESSION['username'];
            $email = $_SESSION['email'];
           
            $query = "DELETE FROM EUCOSSA.users where usr_nm= ? OR email= ? ;";
            $pre=$this->connect()->prepare($query);
	       $pre->execute([$user,$email]);
            session_destroy();//Close session after deleting account
            echo "<script>alert('Account deleted Successfully')</script>";
            echo  "<script>window.location.href='index.php';</script>";//Redirect to home page
        }
    } 
}
$delete = new deleteAccount();
?>