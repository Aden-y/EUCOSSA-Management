<?php
include "db_Connection.php";

class test extends Db_Connect{
    public function get_Content(){
        $query = "select * from eucossa.posts";
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
            
            <p>Comment</p>
            <form action='comments.php' method='POST' enctype='multipart/form-data'>
            <textarea name='comment'></textarea><br>
            <input name='p_id' value=".$p_id." hidden/>
            <input type='submit' value='Comment' name='sub_comment'>
            </form>
            </div>
    
        </div>";
        }
    }
}
$class = new test();
?>
<!DOCTYPE html>
<html>
    <div class = 'post_form' style ='background-color:orange'>
    <form action='post.php' method='POST' enctype='multipart/form-data'>
            <input type=text name='post'><br>
            <input type='file' name='file'>
            <input type='submit' value='Post' name='upload'>
            </form>
        </div>
    <?php $class->get_Content();?>
    
</html>