<?php
/**
 * userSmile
 */

$timerStart = microtime(true);

header('Pragma: no-cache');
header('Content-Type: text/html; charset=UTF-8');
header('Cache-control: no-store, no-cache, must-revalidate');
header('Last_Modified: ' . gmdate('D, d M Y H:i:s', time()) . ' GMT');

define('P_ROOT', dirname(__FILE__));
require_once P_ROOT . '/inc/defines.php';

// parse current address
$app  = App::getInstance();
$page = $app->getTask();

// render page
if ($page == 'index') {
    echo $app->pageIndex();

} else if ($page == 'exectest') {
    echo $app->execTest();
    die;

} else if ($page == 'assets') {
    $app->assets();
    die;

} else if ($page == 'check-session') {
    $start = microtime(true);
    session_start();
    $finish = microtime(true);
    die('' . ($finish - $start));

} else {
    echo 'Undefined task!';
}

$timerFinish = microtime(true);
die('<!-- ' . round($timerFinish - $timerStart, 4) . ' -->');
