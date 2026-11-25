<?php
//require("Exception.php");
//require("smtp.php");
//include("PHPMailer.php");

//use PHPMailer\PHPMailer\PHPMailer;
//use PHPMailer\PHPMailer\SMTP;
//use PHPMailer\PHPMailer\Exception;



//$mail = new PHPMailer(true);
//$mail->SMTPDebug =SMTP::DEBUG_SERVER;
//$mail->Debugoutput ='html';
//$mail->isSMTP();
//$mail->Host = 'localhost';
//$mail->port= '25';
//$mail->setFrom('admin@hstn.me', 'From Name');
//$mail->addAddress('swap793@proton.me', 'Recipient Name');

//$mail->isHTML(false); // Set email format to plain text
//$mail->Subject = 'Your Subject Here';
//$mail->Body    = 'This is the plain text message body';






 $data=array("email"=>"","password"=>"","address"=>"","province"=>"","name"=>"","phone"=>"","sex"=>"");
$regex=array('email'=>"/^[a-zA-Z0-9\_\.\+]{2,40}@[a-zA-Z0-9\-]{1,20}\.[A-Za-z0-9\.]{1,40}$/",
	   'password'=>"/^[a-zA-Z0-9]{8,40}$/",
	   'address'=>"/^[a-zA-Z0-9\s\-\#\/\.\,]{1,80}$/",
           'province'=>"/^[A-Za-z\s]{2,40}$/",
	   'name'=>"/^[a-zA-Z\s]{1,40}$/",
	   'phone'=>"/^[0-9]{5,20}$/",
            'sex'=>"/^[a-zA-Z]{4,10}$/"
            );

 $error=0; 
 foreach($regex as $field=>$reg){

         if(!preg_match($reg,$_POST[$field])){
              $error=$error+1;            
       }
 }

 if($error !== 0){
   print "Error in input";
 }
 else{
        $pid=sha1($_POST["email"]);    
        $response=array("email"=>$_POST["email"],"name"=>$_POST["name"],"pid"=>$pid); 


	$link = mysqli_connect('localhost', 'jacky', 'kontol666420',"project");
	if ($link->connect_errno) {
	    die('Could not connect: ' . mysqli->connect_error);
	}
       $data=$link->query("SELECT name FROM member where email='{$_POST["email"]}'");
       if($data -> num_rows > 0){
          
            print "1";

       }
       else{
        
        $path="http://localhost/member/activation.html";
        $aid=sha1($_POST["email"].time());
        $msg="{$path}?email={$_POST['email']}&aid={$aid}";


        $to      = $_POST["email"];
	$subject = "Account activation link";	
        $message = "Hello {$_POST["name"]} ,your registration was success .Click the link below to activate your account .\r\n{$msg}";
        $headers = 'From: webmaster@localhost' . "\r\n" .
            'Reply-To: webmaster@localhost' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        if(mail($to, $subject, $message,$headers)){



	$sql = "INSERT INTO member (email,password,name,sex,address,province,phone,status,aid) VALUES ('{$_POST["email"]}','{$_POST["password"]}','{$_POST["name"]}','{$_POST["sex"]}','{$_POST["address"]}','{$_POST["province"]}','{$_POST["phone"]}','0','{$aid}')";

	if ($link->query($sql) === TRUE) {
           header("Content-type: application/json; charset=utf-8");
	   print json_encode($response);
           session_id($pid);
           session_start();

	} else {
	   die('Could not connect: ' . mysqli->connect_error);
  	}
        }
        mysqli_close($link);
 

       }
	

   
 }


 die();


?>