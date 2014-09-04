<?php

defined('P_ROOT') or die('Restricted access');

if (file_exists(P_ROOT . '/config.php')) {
    require_once P_ROOT . '/config.php';
}

// include required libs and functions
require_once P_ROOT . '/inc/langs.php';
require_once P_ROOT . '/inc/functions.php';
require_once P_ROOT . '/inc/class.app.php';
require_once P_ROOT . '/inc/class.app.db.php';
require_once P_ROOT . '/inc/class.app.php.php';
require_once P_ROOT . '/inc/class.app.env.php';
require_once P_ROOT . '/inc/class.app.data.php';
require_once P_ROOT . '/inc/class.app.widget.php';
require_once P_ROOT . '/inc/class.app.cmdline.php';
require_once P_ROOT . '/inc/class.app.overview.php';
require_once P_ROOT . '/inc/class.app.benchmark.php';
require_once P_ROOT . '/inc/class.app.phpmodules.php';

// paths
define('DS', DIRECTORY_SEPARATOR);
define('P_TMP', App::cleanPath(P_ROOT . DS . 'tmp'));
define('P_TMPL', App::cleanPath(P_ROOT . DS . 'tmpl'));
