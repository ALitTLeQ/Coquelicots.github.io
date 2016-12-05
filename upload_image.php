<?php
$upload_dir = "upload/";
$img = $_POST['imageUrl'];
$img = str_replace('data:image/png;base64,', '', $img);
$img = str_replace(' ', '+', $img);
$data = base64_decode($img);
$newfilename = rand(1,99999) . '.png');
$file = $upload_dir . $newfilename;
$success = file_put_contents($file, $data);
print $success ? $file : 'Unable to save the file.';
echo '
{
"title":"'.$newfilename.'",
}'; 


?>