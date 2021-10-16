<?php

const MAX_SIZE = 2 * 1024 * 1024;
const MAX_COUNT = 6;
const VALID_FORMAT = ['image/jpeg', 'image/png', 'image/jpg'];

require($_SERVER['DOCUMENT_ROOT'] . '/src/functions.php');
require($_SERVER['DOCUMENT_ROOT'] . '/src/main_menu.php');

$pathToUpload = $_SERVER['DOCUMENT_ROOT'] . '/upload';
//echo preg_replace('/[^\w-]/', '_', 'IMG_1195 — копия.jpg');
$success = '';
$error = '';

if ( isset($_POST['upload']) ) {
    //echo 'была нажата кнопка';
    //var_dump($_FILES['file']);
    if ( !empty($_FILES['file']['name']) ) {
        if ( $_FILES['file']['name'][0] === '' ) {
            $error = 'Нужно выбрать хотя бы один файл!';
        } else if ( count($_FILES['file']['name']) > MAX_COUNT ) {
            $error = 'Можно закрузить максимум ' . MAX_COUNT . ' файлов!';
        } else {
            foreach ($_FILES['file']['type'] as $key => $item) {
                if ($_FILES['file']['size'][$key] > MAX_SIZE) {
                    $success = '';
                    $error = 'Размер файла не може привышать 2MB';
                    break;
                }

                foreach (VALID_FORMAT as $key => $value) {
                    $success = '';
                    $error = 'Не допустимый формат файла!';

                    if ($item === $value) {
                        $error = '';
                        $success = 'Файлы успешно загруженны';
                        break;
                    }
                }
            }
        }

        if ( $success ) {
            foreach ($_FILES['file']['error'] as $key => $value) {
                if ( $value === UPLOAD_ERR_OK ) {
                    $tmp_name = $_FILES['file']['tmp_name'][$key];
                    // basename() может предотвратить атаку на файловую систему;
                    // может быть целесообразным дополнительно проверить имя файла
                    $name = basename($_FILES['file']['name'][$key]);
                    //$name = $_FILES['file']['name'][$key];
                    $name = preg_replace('/[^\w-]/', '_', $name);
                    move_uploaded_file($tmp_name, "$pathToUpload/$name" );
                } else {
                    $error = 'Произошла ошибка, повторите попытку позже.';
                    break;
                }
            }
        }
    }
}

if ( isset($_POST['delete']) ) {
    foreach ($_POST as $i => $item) {
        foreach ( preg_grep('/^([^.])/', scandir($pathToUpload) ) as $key => $value ) {
            if ($i === $value) {
                unlink($pathToUpload . '/' . $value);
            }
        }
    }
}
