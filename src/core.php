<?php

require($_SERVER['DOCUMENT_ROOT'] . '/src/functions.php');
require($_SERVER['DOCUMENT_ROOT'] . '/src/main_menu.php');

const MAX_SIZE = 2 * 1024 * 1024;
const MAX_COUNT = 6;
const VALID_FORMAT = ['image/jpeg', 'image/png', 'image/jpg'];

$pathToUpload = $_SERVER['DOCUMENT_ROOT'] . '/upload';
//echo preg_replace('/[^\w-]/', '_', 'IMG_1195 — копия.jpg');
