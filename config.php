<?php

//jbdump::showErrors();

if ($_SERVER['HTTP_HOST'] == 'jbhostchecker') {
    define('DB_HOST', '127.0.0.1');
    define('DB_NAME', 'test');
    define('DB_USER', 'root');
    define('DB_PORT', '3306');
    define('DB_PASS', '');
}

