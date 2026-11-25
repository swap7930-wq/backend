<?php

     $regex=array('email'=>"/^[a-zA-Z0-9\_\.\+]{2,40}@[a-zA-Z0-9\-]{1,20}\.[A-Za-z0-9\.]{1,40}$/",
	   'password'=>"/^[a-zA-Z0-9]{8,40}$/");
      

    if($_SERVER["HTTP_REFERER"] !=="http://localhost:5173/"){
          die("Wrong request");
    }
    if(isset($_POST["accessToken"])){

           $accessToken=$_POST['accessToken'];
           $url="https://www.googleapis.com/oauth2/v3/userinfo";
            $ch=curl_init($url);

            curl_setopt($ch,CURLOPT_HTTPHEADER,['Authorization: Bearer '.$accessToken]);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
            $response=curl_exec($ch);
            curl_close($ch);

            if (!$response) {
                print 4;
                die();
           }

            $payload = json_decode($response, true);


            
    
                  $googleUserId = $payload['sub'];
                  $email = $payload['email'];
                  $name=$payload['name'];

                  $sessid=sha1($email);
                  session_id($sessid);
                  session_start();
                  $_SESSION['user_id'] = $googleUserId;
                  $_SESSION['email'] = $email;
                  $_SESSION['name']=$name;

                  $response=array("email"=>$email,"name"=>$name);
              

                 print json_encode($response);
                 return ;
      }



     $email=$_POST["email"];
     $password=$_POST["password"];

     if(!preg_match($regex["email"],$email) or !preg_match($regex["password"],$password)){
          print "0";
        
     }
     else{
           $response=array("email"=>$email,"name"=>"","pid"=>"","status"=>"");     
	$link = mysqli_connect('localhost', 'jacky', 'kontol666420',"project");
	if ($link->connect_errno) {
	    die('Could not connect: ' . mysqli->connect_error);
	}
       $data=$link->query("SELECT name,password,status FROM member where email='{$email}'");
       if($data -> num_rows > 0){
                 $pass="";
                 while ($row = $data->fetch_row()) {
                             $response["name"]=$row[0];
                             $pass=$row[1];                              
                             $response["status"]=$row[2];

                 }
                 
                 if($password === $pass){
  
                    $response["pid"]=$id=sha1($email);
                    session_id($id);
                    session_start();
                    print json_encode($response);
                 }
                 else{
                   print 3;
                 }
              
                
        }
        else{
                 print 2;
        }        
        mysqli_close($link);  

     }

     
     die();


?>