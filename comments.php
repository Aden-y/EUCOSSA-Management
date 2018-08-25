<?php  
  session_start();
  include_once 'db_Connection.php';

   class Comment extends Db_Connect{
        private $comment_text;
        private $comment_id;
        private $post_id;
        private $user_id;
       // public $comment_file;
        private $No_of_comments;

   	public function __construct($comment,$post_id){
        $this->comment_text=$comment;
        $this->post_id=$post_id;
        $this->user_id=$_SESSION['id'];
        $this->comment_id=$this->generateId();   

       $this->updateComments();
          
   	}
    //function returns number of comments or a specified record
   	private function getId($column,$tableName,$primary_key,$data){
   		$query="SELECT $column from eucossa.$tableName where $primary_key=?";
   		$run_query=$this->connect()->prepare($query);
   		$run_query->execute([$data]);
   		$row=$run_query->fetch(PDO::FETCH_ASSOC);
   		   return $row[$column];
        }
     //Function used to generate comment ID
    private function generateId(){
    	$this->No_of_comments=$this->getId("comments","posts","post_id",$this->post_id)+1;
      return $this->post_id."-".$this->No_of_comments;
    }
    //function for file upload
   /* public function uploadFile($filename, $location){

        $extension=substr($filename, strpos($filename, ".")+1);
        $allowed_extensions=array("jpg","jpeg","mp4","png","mkv");
        $dir=$this->get_Dir();
        $this->comment_file=$this->comment_id.".".$extension;

        if (!in_array($extension, $allowed_extensions)) {
          echo "<script>alert('File type not supported')</script>";
          return false;
        }else if (!is_dir($dir)) {
           mkdir($dir, 0777, true);
             if(move_uploaded_file($location, $dir."/".$this->comment_file))
                 return true;
             else
                 return false;
        }else if(move_uploaded_file($location, $dir."/".$this->comment_file))
            return true;
         else
            return false;
    }*/

    //This function calculates and returns the images directory
    /*private function get_Dir(){
        $PostOwnerId=$this->getId("user_id","posts","post_id",$this->post_id);
        $PostOwnerU_name=$this->getId("usr_nm","users","id",$PostOwnerId);
        $directory=$PostOwnerU_name."/".$this->post_id."/comments/images";
        return $directory;
    }*/

    private function updateComments(){
      $insert="INSERT INTO eucossa.comments(user_id, post_id, c_id, c_text, replies) VALUES ('".$this->user_id."','".$this->post_id."', '".$this->comment_id."', '".$this->comment_text."','0')";
      $this->connect()->exec($insert);
      $this->update_No_OfComments();
    }

    private function update_No_OfComments(){
       $no_Comments=$this->No_of_comments;//getId("comments","posts","post_id",$this->post_id)+1;
      $update="UPDATE eucossa.posts set comments=$no_Comments WHERE post_id='$this->post_id'";
      $this->connect()->exec($update);
    }

   }


   if (isset($_POST['sub_comment'])){
      $comment_text=$_POST['comment'];
      $p_id=$_POST['p_id'];
      $com=new Comment($comment_text,$p_id);          
    }
   header("Location:index.php");
   
?>