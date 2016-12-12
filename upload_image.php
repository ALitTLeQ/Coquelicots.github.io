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
  "title" => "https://itoiletapp.azurewebsites.net/upload/".$newfilename,
  "Protein" => rand(140,160),
  "Sugar" => rand(0, 30)*5 > 50,
  "SpecificGravity" => 1 + (rand(15, 24) / 1000),
  "UrineOB" => rand(1,10) > 7,
  "StoolOB" => rand(1,10) > 7,
  "PH" => rand(35, 80) / 10,
);

file_put_contents('filename.json', json_encode($content));

//file_put_contents('logs.json', $content.PHP_EOL , FILE_APPEND | LOCK_EX);

if (($inp = file_get_contents('logs.json'))!= false) {
    $tempArray = json_decode($inp);
    echo "inp:".json_decode($inp);
    array_push($tempArray, $content);
    $jsonData = json_encode($tempArray);
    echo "j:".$jsonData;
    file_put_contents('logs.json', $jsonData);
}
else{
    file_put_contents('logs.json', json_encode(array($content)));
}

$file = file_get_contents('logs.json');
$json = json_decode($file);

$csvfile = fopen('file.csv', 'w+');
foreach ($json as $row) {
    $line = "'" . join("\",\"", $row) . "\"\n";
    fputs($csvfile, $line);
}
fclose($csvfile);

?>