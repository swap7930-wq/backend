<?php


$url="https://pictotext.io/api/v1/ocr";
$filepath="../data.jpg";





if(!isset($_FILES["attachment"])){
      die("You must choose a file for upload");
}

if($_FILES["attachment"]["size"] >10000000){
      die("File size is too large");
}


$filetype=$_FILES["attachment"]["type"];
if($filetype !== "image/jpeg" and $filetype !== "image.png"){
   die("Invalid file format");
}

 if (move_uploaded_file($_FILES["attachment"]["tmp_name"], $filepath)) {
      print "Succesfully record the uploaded file";      
 }
 else{
      print "Failed to record uploaded file";
 }



$ch=curl_init($url);
$postFields=["image"=>new CURLFile($filepath,$filetype,basename($filepath)),'documentType'=>'id_ktp'];
$header=["Authorization: Bearer sk-hQbKUkEhA3_5N3qG7KZB9hi8OK_bNAQB","Accept: application/json"];

curl_setopt_array($ch,[CURLOPT_HTTPHEADER =>$header,
                       CURLOPT_POST=>true,
                       CURLOPT_POSTFIELDS=>$postFields,
                       CURLOPT_RETURNTRANSFER=>true]);

$response=curl_exec($ch);
var_dump($response);
die();

?>