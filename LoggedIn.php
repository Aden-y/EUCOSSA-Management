<?php
//Function to delete user account
include_once"db_Connection.php";

session_start();
class user extends DB_Connect
{
    public function __construct(){

    }
    public function deleteAccount(){
        if(isset($_SESSION['username'])&& isset($_SESSION['email'])){
            echo "<script>if(confirm('Are you sure you want to delete your account')){
                window.location.href='delete.php';
            }
            </script>";
        }
    }
}

if(isset($_POST['deleteAccount'])){
    
    $currentUser = new user();
    $currentUser->deleteAccount();
}
?>