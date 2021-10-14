
<?php

$path = explode('/', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) )[2];

require($_SERVER['DOCUMENT_ROOT'] . '/templates/header.php');

require($_SERVER['DOCUMENT_ROOT'] . "/templates/$path.php");

require($_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php');
