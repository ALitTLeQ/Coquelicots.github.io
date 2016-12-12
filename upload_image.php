<?php
$upload_dir = "upload/";
$img = $_POST['imageUrl'];
$img = str_replace('data:image/png;base64,', '', $img);
$img = str_replace(' ', '+', $img);
$data = base64_decode($img);
$newfilename = uniqid() . '.png';
//$newfilename = 'image.png';
$file = $upload_dir . $newfilename;
$success = file_put_contents($file, $data);

$content = array(
  "title" => "https://alittleq.com/upload/".$newfilename,
  "Protein" => rand(140,160),
  "Sugar" => rand(0,2),
  "SpecificGravity" => 1 + (rand(15, 24) / 1000),
  "UrineOB" => rand(1,10) > 7,
  "StoolOB" => rand(1,10) > 7,
  "PH" => rand(35, 80) / 10,
);

file_put_contents('filename.json', json_encode($content));
?>