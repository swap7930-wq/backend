<?php
 
        if(!isset($_POST["email"]) or !preg_match("/^[a-zA-Z0-9\_\.\+]{2,40}@[a-zA-Z0-9\-]{1,20}\.[A-Za-z0-9\.]{1,40}$/",$_POST["email"])){
              die("Wrong post query");
        }
        $link = mysqli_connect('localhost', 'jacky', 'kontol666420',"project");
	if ($link->connect_errno) {
	    die('Could not connect: ' . mysqli->connect_error);
	}
       $data=$link->query("SELECT name FROM member where email='{$_POST["email"]}'");
       mysqli_close($link);
       if($data -> num_rows === 0){
            die("0");      
       }
       


        $path="http://localhost/member/recovery.html";
        $aid=sha1($_POST["email"].time());
        $msg="{$path}?email={$_POST['email']}&rid={$aid}";        

 
        


        $to      = $_POST["email"];
	$subject = "Password recovery";	
        $message = "Hello ,this is recovery email for recovering your password ,click the link below to recover .<br/>{$msg}";
        $headers = 'From: webmaster@localhost' . "\r\n" .
            'Reply-To: webmaster@localhost' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        if(mail($to, $subject, $message,$headers)){
               

                $filepath="../../recovery/".str_replace(".","+",$_POST["email"]);
                $fp=fopen($filepath,"w");
                fwrite($fp,$aid);
                fclose($fp);

                print '1';
               
        }

        die();
?>