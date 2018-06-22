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
        if(isset($_SESSION[/*name of user session variable*/]) || isset($_SESSION[/*name of email session variable*/])){
           
            //Get variables from session
            $user = $_SESSION[/*name of user session variable*/];
            $email = $_SESSION[/*name of email session variable*/];
           
            $query = "DELETE FROM git./*Table Name*/ where userName= ? OR email= ? ;";
            $pre=$this->connect()->prepare($query);
	   $pre->execute([$user,$email]);
            session_destroy();//Close session after deleting account
            echo  "<script>window.location.href='Home_page';</script>";//Redirect to home page
        }
    } 
}

$delete = new deleteAccount();

?>