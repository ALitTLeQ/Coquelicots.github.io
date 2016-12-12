<?php
$upload_dir = "upload/";
$img = $_POST['imageUrl'];
$img = str_replace('data:image/png;base64,', '', $img);
$img = str_replace(' ', '+', $img);
$data = base64_decode($img);
$newfilename = uniqid() . '.png';
$file = $upload_dir . $newfilename;
$success = file_put_contents($file, $data);

date_default_timezone_set("Asia/Taipei");

$content = array(
  "refreshTime" => date("Y-m-d H:i:s"),
  "str" => date("m月d日 H:i"),
  "title" => "https://itoiletapp.azurewebsites.net/upload/".$newfilename,
  "Protein" => rand(140,160),
  "Sugar" => rand(0, 30)*5 > 50,
  "SpecificGravity" => 1 + (rand(15, 24) / 1000),
  "UrineOB" => rand(1,10) > 7,
  "StoolOB" => rand(1,10) > 7,
  "PH" => rand(35, 80) / 10,
);

file_put_contents('filename.json', json_encode($content));

if (($inp = file_get_contents('logs.json'))!= null) {
    $json = json_decode($inp, true);
    $tempArray = $json['data'];
    
    array_push($tempArray, $content);
    $jsonData = json_encode(array("data"=>$tempArray));
    file_put_contents('logs.json', $jsonData);
}
else{
    file_put_contents('logs.json', json_encode(array("data"=>array($content))));
}

