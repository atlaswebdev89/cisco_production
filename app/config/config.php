<?php

define('PREF', 'cisco_');

define('HOST', getenv('DB_HOST'));
define('DBNAME', getenv('DB_DB'));
define('USER', getenv('DB_USER'));
define('PASSWORD', getenv('DB_PASS'));

define('MAX_TIME_SESSION', 3600);
define('INTERVAL_UPDATE', 300);
define('INTERVAL_ONLINE', 1440);

define('SALT_SESSION', '123fseQfdfOi34gfvbBA');


//Pagination
//Количество точек на странице
define('POST_NUMBER', 10);
// Количчество ссылок в меню пагинации
define('NUMBER_LINKS', 2);

?>