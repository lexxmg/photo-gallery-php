
<?php

const MAX_SIZE = 2 * 1024 * 1024;
const MAX_COUNT = 6;
const VALID_FORMAT = ['image/jpeg', 'image/png', 'image/jpg'];

$success = '';
$error = [];

$pathToUpload = $_SERVER['DOCUMENT_ROOT'] . '/upload';

// var_dump( !empty($error) );
// var_dump( isset($error) );

if ( isset($_POST['upload']) ) {
    //sleep(5);
    //echo 'была нажата кнопка';
    //var_dump($_FILES['file']);
    if ( !empty($_FILES['file']['name']) ) {
        if ( $_FILES['file']['name'][0] === '' ) {
            $error[] = 'Нужно выбрать хотя бы один файл!';
        } else if ( count($_FILES['file']['name']) > MAX_COUNT ) {
            $error[] = 'Можно загрузить максимум ' . MAX_COUNT . ' файлов!';
        } else {
            foreach ($_FILES['file']['name'] as $i => $item) {
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $type =  finfo_file($finfo, $_FILES['file']['tmp_name'][$i]);
                finfo_close($finfo);

                if ($_FILES['file']['size'][$i] > MAX_SIZE) {
                    $success = '';
                    $error[] = 'Размер файла не може привышать 2Mb ' . $item;
                    //break;
                }

                foreach (VALID_FORMAT as $j => $value) {
                    $err = true;

                    if ($type === $value) {
                        $err = false;
                        break;
                    }
                }

                if ($err) {
                    $error[] = 'Не допустимый формат файла! ' . $item;
                }
            }
        }

        if ( empty($error) ) {
            foreach ($_FILES['file']['error'] as $key => $value) {
                if ( $value === UPLOAD_ERR_OK ) {
                    $tmp_name = $_FILES['file']['tmp_name'][$key];
                    // basename() может предотвратить атаку на файловую систему;
                    // может быть целесообразным дополнительно проверить имя файла
                    $name = basename($_FILES['file']['name'][$key]);
                    //$name = $_FILES['file']['name'][$key];
                    $name = preg_replace('/[^\w-]/', '_', $name);
                    move_uploaded_file($tmp_name, "$pathToUpload/$name" );
                    $success = 'Файлы успешно загруженны';
                } else {
                    $error[] = "Произошла ошибка $value, повторите попытку позже.";
                    break;
                }
            }
        }
    }
}

$response = [
    'error' => $error,
    'success' => $success
];

echo json_encode($response, JSON_UNESCAPED_UNICODE);
