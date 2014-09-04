<?php

$helper = new AppPHPModules();

$list = $helper->getAllList();

$rowsYes = $rowsNo = array();

$realList = get_loaded_extensions();
$realList = array_map('strtolower', $realList);

$r = array();
foreach ($realList as $real) {
    if (!isset($list[$real])) {
        $r[] = $real;
    }
}

//dump($r);

foreach ($list as $module => $data) {

    if (!in_array($module, $realList)) {
        continue;
    }

    if ($helper->checkModule($module)) {
        $rowsYes[] = array(
            $module . ' :: <a href="http://php.net/' . $module . '" target="_blank">' . $data['name'] . '</a>',
            App::YES,
            $data['desc']
        );
    } else {
        $rowsNo[] = array(
            $module . ' :: <a href="http://php.net/' . $module . '" target="_blank">' . $data['name'] . '</a>',
            App::NO,
            $data['desc']
        );
    }
}


?>

<h4>&nbsp;</h4>
<p>&nbsp;</p>

<ul class="nav nav-tabs" id="tabs-modules">
    <li><a data-toggle="tab" href="#tab-mods-enabled">Включенные модули</a></li>
    <li><a data-toggle="tab" href="#tab-mods-disabled">Недоступные модули</a></li>
</ul>
<div class="tab-content">
    <div class="tab-pane" id="tab-mods-enabled">
        <?php echo AppWidget::renderTable(array('rows' => $rowsYes)); ?>
    </div>
    <div class="tab-pane" id="tab-mods-disabled">
        <?php echo AppWidget::renderTable(array('rows' => $rowsNo)); ?>
    </div>
</div>


<?php
return;
$stdList = array(
    'core',
    'pdo',
    'phar',
    'reflection',
    'bcmath',
    'calendar',
    'ctype',
    'date',
    'ereg',
    'filter',
    'ftp',
    'hash',
    'libxml',
    'pcre',
    'session',
    'standard',
    'tokenizer',
    'wddx',
    'xml',
    'xmlreader',
    'xmlwriter',
    'zip',
    'zlib'
);


//dump(array_diff($list, $all));


$extList = array(
    'speedup'    => array(
        'apc'
    ),

    'general'    => array(),
    'audio'      => array(),
    'debug'      => array(
        'apd'
    ),
    'auth'       => array(),
    'cmdline'    => array(),
    'arch'       => array(),
    'payment'    => array(),
    'crypt'      => array(),
    'database'   => array(),
    'datetime'   => array(),
    'locales'    => array(),
    'images'     => array(),
    'mail'       => array(),
    'math'       => array(),
    'nontext'    => array(),
    'process'    => array(),
    'search'     => array(),
    'server'     => array(),
    'session'    => array(),
    'text'       => array(),
    'vartype'    => array(),
    'webservice' => array(),
    'windows'    => array(),
    'xml'        => array(),

    'others'     => array('bcompiler', 'blenc'),
);


?>

<h3>PHP Extensions</h3>

<table class="table table-hover">
    <thead>
    <th>
        <td>Ext name</td>
        <td>State</td>
        <td>Description</td>
    </th>
    </thead>
    <tbody>
    <tr>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    </tbody>
</table>

<?php if (0) : ?>
    <div class="col-md-6">
        <h4>iconv</h4>
        <?php echo AppWidget::renderTable(array('rows' => array(
            array('Input encoding', $helper->getParam('iconv.input_encoding')),
            array('Internal encoding', $helper->getParam('iconv.internal_encoding')),
            array('Output eencoding', $helper->getParam('iconv.output_encoding')),
        ))); ?>
    </div>

    <div class="col-md-6">
        <h4>mbstring</h4>
        <?php echo AppWidget::renderTable(array('rows' => array(
            array('Language', $helper->getParam('mbstring.language')),
            array('Func overload', $helper->getParam('mbstring.func_overload')),
            array('Encoding translation', $helper->getParam('mbstring.encoding_translation')),
            array('Internal encoding', $helper->getParam('mbstring.internal_encoding')),
        ))); ?>
    </div>
<?php endif; ?>

<pre>
    Xdebug
    настройки APC
    Акселератор php

    Модули
    Модуль Mcrypt
    Функции работы с сокетами:
    XML Enabled
    Zlib Enabled
    Native ZIP Enabled
    Disabled Functions
    Mbstring Enabled
    Iconv Available
    Регулярные выражения PHP
    Регулярные выражения Perl
    GD lib extension
    Free Type extension
    Поддержка SSL
    Поддержка mbstring
    Включен режим UTF для mbstring:

    STD libs
        ioncube
        SPL
        pcre
        session
        ctype
        SimpleXML
        libxml
        dom
        ftp
        zip
        XMLWriter
        hash
        gd
        xml
        intl
        XSLT
        curl
        mbstring

        bz2
        curl
        fileinfo
        gd2
        gettext
        gmp
        intl
        imap
        imagick
        interbase
        ldap
        exif
        mongo
        oci8
        oci8_11g
        openssl
        shmop
        snmp
        soap
        sockets
        sqlite3
        sybase_ct
        tidy
        xmlrpc
        xsl

        xcache
        eaccelerator
        memcache
        apc

    DB libs
        mysqli
        PDO
        pdo_sqlite
        pdo_mysql
        php_mongo
        pdo_firebird
        pdo_mysql
        pdo_oci
        pdo_odbc
        pdo_pgsql
        pdo_sqlite
        pgsql

    GDlib: Установлена версия bundled (2.1.0 compatible)
        FreeType Support
        GIF Read Support
        GIF Create Support
        JPEG Support
        PNG Support
        WBMP Support
        XPM Support
        XBM Support
</pre>