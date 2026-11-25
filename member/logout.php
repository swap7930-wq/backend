<?php

  if(isset($_COOKIE["pid"]) and preg_match("/^[A-Za-z0-9]{40}$/",$_COOKIE["pid"])){
        $path=session_save_path();
        if(file_exists($path."/sess_".$_COOKIE["pid"])){
              session_id($_COOKIE["pid"]);
              session_start();
              session_destroy();
        }
        print 1;


  }

  die();
?>