<?php
//Function to delete user account
include "db_Connection.php";

//Obtain session variables
session_start();

//Class can be any class in another page
class user extends DB_Connect
{
    public function __construct(){

    }
//Function to perform action to delete account
    public function deleteAccount(){
        if(isset($_SESSION[/*name of user session variable*/])|| isset($_SESSION[/*name of email session variable*/])){//Check if the user is logged in to his or her account
            
            echo "<script>if(confirm('Are you sure you want to delete your account')){
                window.location.href='delete.php';
            }
            </script>";
        }
    }
}

if(isset($_POST['deleteAccount'])){//Check whether the user has clicked button to delete account
    
    $currentUser = new user();
    $currentUser::deleteAccount();//call function to delete account
}

?>