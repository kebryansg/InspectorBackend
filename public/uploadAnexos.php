<?php
header('Access-Control-Allow-Origin: *');
$target_path = __DIR__ . "\\Imgs\\Inspeccion\\insp_". $_POST["id"]. '\\Anexos\\';

if (!file_exists($target_path)) {
    mkdir($target_path, 0777, true);
}

$target_path = $target_path . basename($_FILES['file']['name']);

if (move_uploaded_file($_FILES['file']['tmp_name'], $target_path)) {
    echo "Upload and move success";
} else {
    echo $target_path;
    echo "There was an error uploading the file, please try again!";
}