<?php
session_start();
if (isset($_SESSION['title'])) {
echo $_SESSION['title'];
};
$m = array();
$file = fopen('text.txt','r') or die('Faild');
while (!feof($file)) {
$a= fgets($file);
$data =  explode(',',$a);
$tit=$data[0];
$cont=$data[1];
$img=$data[2];
//echo $tit . ' '.$cont.' '.$img;
//$arr  = array($data);
if (isset($data)) {

    echo
     '<form Action='.$_SERVER['PHP_SELF'].' METHOD="POST">
      <div style="padding-top:50px; padding-left: 30px; background:lightgray ; display:inline-block;width:320px;height:270px;float:auto">
     
     <img src='.$img.' style="width:150;hieght150px;">
    <h3>
        <input readonly type="text" name="title" value="'.$tit.'"'.$tit.'>
    </h3>
    <p>'.$cont.'></p>
    <button class="btn btn-danger" type="submit">Delete</button>
</div></form>';
}
if ($_SERVER['REQUEST_METHOD']=='POST') {
  
    $search= $_POST['title'];
  // retrieve the file into an array where each line is a value
//  not done delete 
$rows = file("./text.txt");    
$blacklist = $search;

unset($rows[3]);

file_put_contents("solved.txt", implode("\n", $rows));
}
}
fclose($file);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" />
</head>