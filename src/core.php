<?php

require($_SERVER['DOCUMENT_ROOT'] . '/src/functions.php');
require($_SERVER['DOCUMENT_ROOT'] . '/src/main_menu.php');

$pathToUpload = $_SERVER['DOCUMENT_ROOT'] . '/upload';
//echo preg_replace('/[^\w-]/', '_', 'IMG_1195 — копия.jpg');


if ( isset($_POST['delete']) ) {
    if ( isset($_POST['deleteAll']) ) {
        foreach ( preg_grep('/^([^.])/', scandir($pathToUpload) ) as $key => $value ) {
            unlink($pathToUpload . '/' . $value);
        }
    } else {
        foreach ($_POST as $i => $item) {
            foreach ( preg_grep('/^([^.])/', scandir($pathToUpload) ) as $key => $value ) {
                if ($i === $value) {
                    unlink($pathToUpload . '/' . $value);
                }
            }
        }
    }
}
