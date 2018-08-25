<?php
include_once 'db_Connection.php';
session_start();

class post extends Db_Connect{
    
    private $user_id;
    private $post_file;
    private $post_date;
    private $post_text;
    private $no_posts;
    private $post_id;
    //private $c_id;
    //private $p_id;
    
    public function __construct($post_text, $post_file){
        //$this->p_id = $p_id;
        //$this->c_id = $c_id;
        $this->post_text = $post_text;
        $this->user_id = $_SESSION['id'];
        $this->post_date = $this->get_date();
        $this->get_id();
        $this->post_file = $post_file;
        $this::insert_post();
    }
    public function get_post_file(){
        if($this->post_file === 0){
        }else{
            $file = $_FILES['file']['name'];
            $target_dir = "post/";
            $target_file = $target_dir.basename($_FILES["file"]["name"]);
            $exts = array("jpg","png");
            $ext = strtolower(end(explode('.',$_FILES["file"]['name'])));
            if($target_file == $target_dir){
                echo "<script>alert('Select a file');</script>";
                return -1;
            }else{
            if(!in_array($ext,$exts)){
                echo "<script>alert('File type not allowed');</script>";
                return -1;
            }else if(move_uploaded_file($_FILES['file']["tmp_name"], $target_file)){

                return $target_file;
            }else{
                echo "<script>alert('Upload failed');</script>";
                return -1;
            }
        }
    }
    }
    public function get_date(){
        $date = date('d/m/y');
        return $date;
    }
    public function get_id(){
        $query ="SELECT posts FROM eucossa.users WHERE id=?";			
        
        $run=$this->connect()->prepare($query);
        
        $run->execute([$this->user_id]);
        $row = $run->fetch(PDO::FETCH_ASSOC);
        $this->no_posts = $row['posts'];
        $this->post_id = $this->user_id."-".($this->no_posts+1);
    }
    public function insert_post(){
        $query = "select * from eucossa.users where id=?";
        $run = $this->connect()->prepare($query);
        $run->execute([$this->user_id]);
        if($run->rowCount() < 1){
            echo "<script>alert('You must be logged in to make a post'); window.open('loginpage.php','_self');</script>";
        }else{
            //check file
            $post_file = $this->get_post_file();
            //update comment table
            $new_no_posts = $this->no_posts+1;
            $query = "update eucossa.users set posts =? where id =?";
            $run = $this->connect()->prepare($query);
            $run->execute([$new_no_posts, $this->user_id]);
            //insert
            $query = "insert into eucossa.posts(post_file,post_id,post_text,user_id) values(?,?,?,?)";
            $run = $this->connect()->prepare($query);
            $run->execute([$this->post_file, $this->post_id, $this->post_text, $this->user_id]);
        }
    }
    
}

if(isset($_SESSION['email']) && isset($_POST['upload'])){
    $file = $_FILES['file']['name'];
    if(strlen($file) == 0){
        $file = 0;
    }
    $class = new post($_POST['post'],$file);
    echo "<script>window.open('index.php','_self')</script>";

}else{
    echo "<script>alert('You must be logged in to post to a comment');</script>";
    echo "<script>window.open('loginpage.php','_self')</script>";

}

?>