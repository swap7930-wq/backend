<?php





	$link = mysqli_connect('localhost', 'jacky', 'kontol666420',"project");
	if ($link->connect_errno) {
	    die('Could not connect: ' . mysqli->connect_error);
	}
       $data=$link->query("SELECT aid,password,name FROM member where email='{$_POST["email"]}'");
       if($data -> num_rows > 0){
               $response=array();
               $pid=sha1($_POST["email"]);
                while ($row = $data->fetch_row()) {
                             $response["email"]=$_POST["email"];
                            
                             $response["pid"]=$pid;
                             $response["name"]=$row[2];
                   }

          
            if($link->query("UPDATE member set status='1' where email='{$_POST["email"]}'")){
                     header("Content-type: application/json; charset=utf-8");
	             print json_encode($response);
                     session_id($pid);
                     session_start();

            }

       }
       else{
              print "0";
       }

       mysqli_close($link);
?>