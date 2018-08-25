<?php
	session_start();
    include "db_Connection.php";

	/*if(!isset($_SESSION['username'])){

			header('location: loginpage.php');
	}*/

    class test extends Db_Connect{
    public function get_Content(){
        $query = "select * from eucossa.posts order by post_id DESC";
        $run = $this->connect()->query($query);
        
        while($items = $run->FETCH()){
            $image_path = "post/".$items['post_file'];
            $text = $items['post_text'];
            $by = $items['user_id'];
            //$date = $items[];
            $p_id = $items['post_id'];
            
            echo "<div class = 'post' style ='background-color:blue'>
            <img src=\"".$image_path."\"
            >    
            <p>".$text."</p>
            <div class= 'comment' style ='background-color:green'>
            <p>Comments</p>
            ";
            $this->get_Comments($p_id);
            echo "<form action='comments.php' method='POST' enctype='multipart/form-data'>
            <textarea name='comment'></textarea><br>
            <input name='p_id' value=".$p_id." hidden/>
            <input type='submit' value='Comment' name='sub_comment'>
            </form>
            </div>
    
        </div>";
        }
    }
    private function get_Comments($p_id){
        $query = "select * from eucossa.comments where post_id = '".$p_id."' order by c_id DESC";
        $run = $this->connect()->query($query);
        
        while($items = $run->FETCH()){
            $text = $items['c_text'];
            $by = $items['user_id'];
            $c_id = $items['c_id'];
            if($by==0)
                $by=7;
            
            $query = "select usr_nm from eucossa.users where id = '".$by."'";
            $getName = $this->connect()->query($query);
            $name = $getName->FETCH();
            
            echo "<div class = 'post2' style ='background-color:cyan'>
            <p> By ".$name['usr_nm']."</p>
            <p>".$text."</p>
    
        </div>";
        }
        
    }
    public function checK_login(){
        if(isset($_SESSION['username'])){
        echo "<h1>Welcome ". @$_SESSION['username']."</h1>";

	   echo "<a href='resetPasswordPage.php'>Reset password</a><br><br>";

	   echo "<a href='logout.php'>Log out</a><br><br>
        <a href='pwd_to_delete.php'>Delete Account</a><br><br>";
        }else{
            echo "<h1>Welcome</h1>";
            echo "<a href='loginpage.php'>Log In</a><br><br>";
        }
    }
}
$class = new test();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Home Page</title>
</head>
<body>
    <?php $class->check_login();?>
	
    <div class = 'post_form' style ='background-color:orange'>
    <p>What's on your mind</p>
    <form action='post.php' method='POST' enctype='multipart/form-data'>
        <textarea type=text name='post'></textarea><br>
            <input type='file' name='file'>
            <input type='submit' value='Post' name='upload'>
            </form>
        </div>
    <?php $class->get_Content();?>
</body>
</html>

