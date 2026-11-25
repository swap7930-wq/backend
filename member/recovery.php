<?php
  if(!isset($_POST["email"]) or !isset($_POST["rid"]) or !isset($_POST["password"]) or !preg_match("/^[a-zA-Z0-9]{8,40}$/",$_POST["password"])){
              die("Invalid post data");
  }
 $filepath="../../recovery/".str_replace(".","+",$_POST["email"]);
 if(!file_exists($filepath)){
    die("0");
 }

 // check are the recovery id is match

 $fp=fopen($filepath,"r");
 $data=fread($fp,filesize($filepath));
 fclose($fp);

 if($data !== $_POST["rid"]){
        die("2");
 }
       

	$link = mysqli_connect('localhost', 'jacky', 'kontol666420',"project");
	if ($link->connect_errno) {
	    die('Could not connect: ' . mysqli->connect_error);
	}
          if($link->query("UPDATE member set password='{$_POST["password"]}' where email='{$_POST["email"]}'") and unlink($filepath)){
              
               print 1;
          }

          mysqli_close($link);




?>