
<?php

//______________________Если путь существует____________________________________

  //isCurrentUrl('/route/directory/') true

function isCurrentUrl(string $url): bool
{
    return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) === $url;
}

//______________________________________________________________________________
