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

if($inp = file_get_contents('logs.json') !== false){
    $tempArray = json_decode($inp);
    array_push($tempArray, $content);
    $jsonData = json_encode($tempArray);
    file_put_contents('logs.json', $jsonData);
}
else
{
    file_put_contents('logs.json', json_encode(array($content)));
}

$file_name="logs.xlsx";
header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment; filename=\"$file_name\"");
header("Cache-Control: max-age=0");

require('Classes/PHPExcel.php');
require_once "Classes/PHPExcel/IOFactory.php";
$file1=file_get_contents("logs.json");
$objXLS =new PHPExcel();
$value=1;
$array=json_decode($file1);
$man_val=array();
//set the heading for first time

foreach ($array as $key => $jsons) { 
    foreach($jsons as $key => $value1) {
        array_push($man_val,$key);
    }
    break;
}
$objXLS->getSheet(0)->fromArray($man_val, null, "A".$value);
$man_val=array();
$value=2;
foreach ($array as $key => $jsons) { 
    
    foreach($jsons as $key => $value1) {
        array_push($man_val,$value1);
    }
    $objXLS->getSheet(0)->fromArray($man_val, null, "A".$value);
    $value=$value+1;
    $man_val=array();
}


$fileType = 'Excel2007';
$fileName = $file_name;
$objWriter = PHPExcel_IOFactory::createWriter($objXLS, $fileType);
$objWriter->save("php://output");
$objXLS->disconnectWorksheets();
unset($objXLS);


?>