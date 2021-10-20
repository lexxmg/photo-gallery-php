
<?php

$arrFiles = preg_grep('/^([^.])/', scandir($_SERVER['DOCUMENT_ROOT'] . '/upload') );
$pathToUpload = $_SERVER['DOCUMENT_ROOT'] . '/upload';

if ( isset($_POST['delete']) ) {
    if ( isset($_POST['deleteAll']) ) {
        foreach ($arrFiles as $key => $value) {
            unlink($pathToUpload . '/' . $value);
        }
    } else {
        foreach ($_POST as $i => $item) {
            foreach ($arrFiles as $j => $value) {
                if ($i === $value) {
                    unlink($pathToUpload . '/' . $value);
                }
            }
        }
    }

    $arrFiles = preg_grep('/^([^.])/', scandir($_SERVER['DOCUMENT_ROOT'] . '/upload') );
}


$arr = [];

foreach ($arrFiles as $key => $value) {
  $arr[] = [
    'name' => $value,
    'date' => date('m.d.Y H:i:s' ,filectime($_SERVER['DOCUMENT_ROOT'] . '/upload/' . $value) ),
    'size' => filesize( $_SERVER['DOCUMENT_ROOT'] . '/upload/' . $value )
  ];
}

echo json_encode($arr, JSON_UNESCAPED_UNICODE);
