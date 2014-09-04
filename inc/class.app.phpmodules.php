<?php

defined('P_ROOT') or die('Restricted access');

/**
 * Class AppPHPModules
 */
class AppPHPModules
{

    private $_allModules = array(
        'apc'               => array(
            'name' => 'Alternative PHP Cache',
            'desc' => 'The Alternative PHP Cache (APC) is a free and open opcode cache for PHP. Its goal is to provide a free, open, and robust framework for caching and optimizing PHP intermediate code.',
        ),
        'bcmath'            => array(
            'name' => 'BCMath Arbitrary Precision Mathematics',
            'desc' => 'For arbitrary precision mathematics PHP offers the Binary Calculator which supports numbers of any size and precision, represented as strings.',
        ),
        'bz2'               => array(
            'name' => 'Bzip2',
            'desc' => 'The bzip2 functions are used to transparently read and write bzip2 (.bz2) compressed files.',
        ),
        'crack'             => array(
            'name' => 'Cracklib',
            'desc' => 'These functions allow you to use the CrackLib library to test the "strength" of a password.',
        ),
        'curl'              => array(
            'name' => 'Client URL Library',
            'desc' => 'В PHP включена поддержка libcurl - библиотеки функций, которая позволяет взаимодействовать с множеством различных серверов по множеству различных сетевых протоколов.',
        ),
        'dba'               => array(
            'name' => 'Database (dbm-style) Abstraction Layer',
            'desc' => 'These functions build the foundation for accessing Berkeley DB style databases.',
        ),
        'dbase'             => array(
            'name' => 'dbase',
            'desc' => 'These functions allow you to access records stored in dBase-format (dbf) databases.',
        ),
        'dbx'               => array(
            'name' => 'dbx',
            'desc' => 'The dbx module is a database abstraction layer (db "X", where "X" is a supported database). The dbx functions allow you to access all supported databases using a single calling convention. The dbx-functions themselves do not interface directly to the databases, but interface to the modules that are used to support these databases.',
        ),
        'dom'               => array(
            'name' => 'Document Object Model',
            'desc' => 'The DOM extension allows you to operate on XML documents through the DOM API with PHP 5.',
        ),
        'eaccelerator'      => array(
            'name' => 'eAccelerator',
            'desc' => 'PHP extension designed to improve the performance of software applications written in the PHP programming language.',
        ),
        'eio'               => array(
            'name' => 'Eio',
            'desc' => 'This extension provides asyncronous POSIX I/O by means of » libeio C library written by Marc Lehmann.',
        ),
        'enchant'           => array(
            'name' => 'Enchant spelling library',
            'desc' => 'Enchant steps in to provide uniformity and conformity on top of all spelling libraries, and implement certain features that may be lacking in any individual provider library. Everything should "just work" for any and every definition of "just working."',
        ),
        'ffmpeg'            => array(
            'name' => 'FFMpeg-php',
            'desc' => 'FFMpeg-php is an extension for PHP that adds an easy to use, object-oriented API for accessing and retrieving information from video and audio files.',
        ),
        'fileinfo'          => array(
            'name' => 'File Information',
            'desc' => 'The functions in this module try to guess the content type and encoding of a file by looking for certain magic byte sequences at specific positions within the file. While this is not a bullet proof approach the heuristics used do a very good job.',
        ),
        'functional'        => array('name' => '', 'desc' => '',),
        'gd'                => array(
            'name' => 'Image Processing and GD',
            'desc' => 'PHP is not limited to creating just HTML output. It can also be used to create and manipulate image files in a variety of different image formats, including GIF, PNG, JPEG, WBMP, and XPM. ',
        ),
        'gender'            => array(
            'name' => 'Determine gender of firstnames',
            'desc' => 'Gender PHP extension is a port of the gender.c program originally written by Joerg Michael. The main purpose is to find out the gender of firstnames. The current database contains >40000 firstnames from 54 countries.',
        ),
        'geoip'             => array(
            'name' => 'Geo IP Location',
            'desc' => 'The GeoIP extension allows you to find the location of an IP address. City, State, Country, Longitude, Latitude, and other information as all, such as ISP and connection type can be obtained with the help of GeoIP.',
        ),
        'haru'              => array(
            'name' => 'Haru PDF',
            'desc' => 'The PECL/haru extension provides bindings to the libHaru library. libHaru is a free, cross platform, and Open Source library for generating PDF files.',
        ),
        'hidef'             => array(
            'name' => 'hidef',
            'desc' => 'Allow definition of user defined constants in simple ini files, which are then processed like internal constants, without any of the usual performance penalties.',
        ),
        'htscanner'         => array(
            'name' => 'htaccess-like support for all SAPIs',
            'desc' => 'The htscanner extension gives the possibility to use htaccess-like file to configure PHP per directory, just like apache\'s htaccess. It is especially useful with fastcgi (ISS5/6/7, lighttpd, etc.).',
        ),
        'huffman'           => array(
            'name' => 'PHP-Huffman',
            'desc' => 'A fast and simple implementation of Huffman\'s algorithm in PHP',
        ),
        'idn'               => array(
            'name' => 'IDN',
            'desc' => 'Binding to the GNU libidn for using Internationalized Domain Names.',
        ),
        'igbinary'          => array(
            'name' => 'igbinary',
            'desc' => 'Igbinary is a drop in replacement for the standard php serializer. Instead of time and space consuming textual representation, igbinary stores php data structures in a compact binary form. Savings are significant when using memcached or similar memory based storages for serialized data.',
        ),
        'imagick'           => array(
            'name' => 'Image Processing (ImageMagick)',
            'desc' => 'Imagick is a native php extension to create and modify images using the ImageMagick API.',
        ),
        'imap'              => array(
            'name' => 'IMAP, POP3 and NNTP',
            'desc' => 'These functions enable you to operate with the IMAP protocol, as well as the NNTP, POP3 and local mailbox access methods.',
        ),
        'inclued'           => array(
            'name' => 'Traces through and dumps the hierarchy of file inclusions and class inheritance at runtime.',
            'desc' => 'Inclusion hierarchy viewer',
        ),
        'inotify'           => array(
            'name' => 'Inotify',
            'desc' => 'The inotify extension exposes the inotify functions inotify_init(), inotify_add_watch() and inotify_rm_watch()',
        ),
        'intl'              => array(
            'name' => 'Internationalization Functions',
            'desc' => 'Int. extension (further is referred as Intl) is a wrapper for » ICU library, enabling PHP programmers to perform » UCA-conformant collation and date/time/number/currency formatting in their scripts.',
        ),
        'ioncube loader'    => array(
            'name' => 'ionCube Loader',
            'desc' => '',
        ),
        'ldap'              => array(
            'name' => 'Lightweight Directory Access Protocol',
            'desc' => 'LDAP is the Lightweight Directory Access Protocol, and is a protocol used to access "Directory Servers". The Directory is a special kind of database that holds information in a tree structure.',
        ),
        'lzf'               => array(
            'name' => 'LZF',
            'desc' => 'LZF is a very fast compression algorithm, ideal for saving space with only slight speed cost. It can be optimized for speed or space at the time of compilation. This extension is using » liblzf library by Marc Lehmann for its operations.',
        ),
        'mailparse'         => array(
            'name' => 'Mailparse',
            'desc' => 'Mailparse is an extension for parsing and working with email messages. It can deal with » RFC 822 and » RFC 2045 (MIME) compliant messages.',
        ),
        'mbstring'          => array(
            'name' => 'Multibyte String',
            'desc' => 'mbstring provides multibyte specific string functions that help you deal with multibyte encodings in PHP. In addition to that, mbstring handles character encoding conversion between the possible encoding pairs.',
        ),
        'mcrypt'            => array(
            'name' => 'Mcrypt',
            'desc' => 'This is an interface to the mcrypt library, which supports a wide variety of block algorithms such as DES, TripleDES, Blowfish (default), 3-WAY, SAFER-SK64, SAFER-SK128, TWOFISH, TEA, RC2 and GOST in CBC, OFB, CFB and ECB cipher modes. Additionally, it supports RC6 and IDEA which are considered "non-free". CFB/OFB are 8bit by default',
        ),
        'memcache'          => array(
            'name' => 'Memcache',
            'desc' => 'Memcache module provides handy procedural and object oriented interface to memcached, highly effective caching daemon, which was especially designed to decrease database load in dynamic web applications.',
        ),
        'memcached'         => array(
            'name' => 'Memcached',
            'desc' => 'memcached is a high-performance, distributed memory object caching system, generic in nature, but intended for use in speeding up dynamic web applications by alleviating database load.',
        ),
        'mongo'             => array(
            'name' => 'MongoDB',
            'desc' => 'MongoDB databse handler',
        ),
        'msgpack'           => array('name' => '', 'desc' => '',),
        'mssql'             => array(
            'name' => 'Microsoft SQL Server',
            'desc' => 'These functions allow you to access MS SQL Server database.',
        ),
        'mysql'             => array(
            'name' => 'MySQL',
            'desc' => 'There are three PHP APIs for accessing the MySQL database. This guide explains the terminology used to describe each API, information about choosing which API to use, and also information to help choose which MySQL library to use with the API.',
        ),
        'mysqli'            => array(
            'name' => 'MySQL Improved Extension',
            'desc' => 'The mysqli extension allows you to access the functionality provided by MySQL 4.1 and above.',
        ),
        'ncurses'           => array(
            'name' => 'Ncurses Terminal Screen Control',
            'desc' => 'ncurses (new curses) is a free software emulation of curses in System V Rel 4.0 (and above).',
        ),
        'oauth'             => array(
            'name' => 'OAuth',
            'desc' => 'This extension provides OAuth consumer and provider bindings. OAuth is an authorization protocol built on top of HTTP which allows applications to securely access data without having to store usernames and passwords.',
        ),
        'odbc'              => array(
            'name' => 'ODBC (Unified)',
            'desc' => 'In addition to normal ODBC support, the Unified ODBC functions in PHP allow you to access several databases that have borrowed the semantics of the ODBC API to implement their own API. ',
        ),
        'opcache'           => array(
            'name' => 'OPcache',
            'desc' => 'OPcache improves PHP performance by storing precompiled script bytecode in shared memory, thereby removing the need for PHP to load and parse scripts on each request.',
        ),
        'pdo'               => array(
            'name' => 'PHP Data Objects',
            'desc' => 'The PHP Data Objects (PDO) extension defines a lightweight, consistent interface for accessing databases in PHP. Each database driver that implements the PDO interface can expose database-specific features as regular extension functions.',
        ),
        'pdo_mysql'         => array(
            'name' => 'MySQL Functions (PDO_MYSQL)',
            'desc' => 'PDO_MYSQL is a driver that implements the PHP Data Objects (PDO) interface to enable access from PHP to MySQL 3.x, 4.x and 5.x databases.',
        ),
        'pdo_odbc'          => array(
            'name' => 'ODBC and DB2 Functions (PDO_ODBC)',
            'desc' => 'DO_ODBC is a driver that implements the PHP Data Objects (PDO) interface to enable access from PHP to databases through ODBC drivers or through the IBM DB2 Call Level Interface (DB2 CLI) library. PDO_ODBC currently supports three different "flavours" of database drivers:',
        ),
        'pdo_pgsql'         => array(
            'name' => 'PostgreSQL Functions (PDO_PGSQL)',
            'desc' => 'PDO_PGSQL is a driver that implements the PHP Data Objects (PDO) interface to enable access from PHP to PostgreSQL databases.',
        ),
        'pdo_sqlite'        => array(
            'name' => 'SQLite Functions (PDO_SQLITE)',
            'desc' => 'PDO_SQLITE is a driver that implements the PHP Data Objects (PDO) interface to enable access to SQLite 3 databases.',
        ),
        'pgsql'             => array(
            'name' => 'PostgreSQL',
            'desc' => 'PostgreSQL database is Open Source product and available without cost.',
        ),
        'phar'              => array(
            'name' => 'Phar',
            'desc' => 'The phar extension provides a way to put entire PHP applications into a single file called a "phar" (PHP Archive) for easy distribution and installation.',
        ),
        'posix'             => array(
            'name' => 'POSIX',
            'desc' => 'This module contains an interface to those functions defined in the IEEE 1003.1 (POSIX.1) standards document which are not accessible through other means.',
        ),
        'pspell'            => array(
            'name' => 'Pspell',
            'desc' => 'These functions allow you to check the spelling of a word and offer suggestions.',
        ),
        'quickhash'         => array(
            'name' => 'Quickhash',
            'desc' => 'The quickhash extension contains a set of specific strongly-typed classes to deal with specific set and hash implementations.',
        ),
        'radius'            => array(
            'name' => 'Radius',
            'desc' => 'This package is based on the libradius (Remote Authentication Dial In User Service) of FreeBSD. It allows clients to perform authentication and accounting by means of network requests to remote servers.',
        ),
        'recode'            => array(
            'name' => 'GNU Recode',
            'desc' => '',
        ),
        'rsync'             => array(
            'name' => 'Wrapper for librsync library',
            'desc' => 'The librsync library itself can be found at http://librsync.sourceforge.net/ and implements rsync remote-delta algorithm (http://rsync.samba.org/tech_report).',
        ),
        'snmp'              => array(
            'name' => 'SNMP',
            'desc' => 'The SNMP extension provides a very simple and easily usable toolset for managing remote devices via the Simple Network Management Protocol.',
        ),
        'soap'              => array(
            'name' => 'SOAP',
            'desc' => 'The SOAP extension can be used to write SOAP Servers and Clients. It supports subsets of » SOAP 1.1, » SOAP 1.2 and » WSDL 1.1 specifications.',
        ),
        'sourceguardian'    => array(
            'name' => 'PHP source encoder',
            'desc' => 'Encoder is a leading php encoding, encryption, obfuscating and licensing software package designed to protect your PHP scripts.',
        ),
        'spl_types'         => array(
            'name' => 'SPL Type Handling',
            'desc' => 'This extension aims at helping people making PHP a stronger typed language and can be a good alternative to scalar type hinting. It provides different typehandling classes as such as integer, float, bool, enum and string.',
        ),
        'sqlite'            => array(
            'name' => 'SQLite',
            'desc' => 'This is an extension for the SQLite Embeddable SQL Database Engine. SQLite is a C library that implements an embeddable SQL database engine. Programs that link with the SQLite library can have SQL database access without running a separate RDBMS process.',
        ),
        'ssh2'              => array(
            'name' => 'Secure Shell2',
            'desc' => 'Bindings to the » libssh2 library which provide access to resources (shell, remote exec, tunneling, file transfer) on a remote machine using a secure cryptographic transport.',
        ),
        'stats'             => array(
            'name' => 'Statistic Functions',
            'desc' => 'This is the statistics extension. It contains few dozens of functions useful for statistical computations. ',
        ),
        'stem'              => array(
            'name' => 'PHP extension that provides word stemming',
            'desc' => 'This stem extension for PHP provides stemming capability for a variety of languages using Dr. M.F. Porter\'s Snowball API, which can be found at: http://snowball.tartarus.org',
        ),
        'stomp'             => array(
            'name' => 'Stomp Client',
            'desc' => 'This extension allows php applications to communicate with any Stomp compliant Message Brokers through easy object oriented and procedural interfaces.',
        ),
        'suhosin'           => array(
            'name' => 'Suhosin',
            'desc' => 'The goal behind Suhosin is to be a safety net that protects servers from insecure PHP coding practices.',
        ),
        'sysvmsg'           => array(
            'name' => 'Semaphore, Shared Memory and IPC',
            'desc' => 'This module provides wrappers for the System V IPC family of functions. It includes semaphores, shared memory and inter-process messaging (IPC).',
        ),
        'sysvsem'           => array(
            'name' => 'Semaphore, Shared Memory and IPC',
            'desc' => 'This module provides wrappers for the System V IPC family of functions. It includes semaphores, shared memory and inter-process messaging (IPC).',
        ),
        'sysvshm'           => array(
            'name' => 'Shared Memory Functions',
            'desc' => 'Shmop is an easy to use set of functions that allows PHP to read, write, create and delete Unix shared memory segments.',
        ),
        'tidy'              => array(
            'name' => 'Tidy',
            'desc' => 'Tidy is a binding for the Tidy HTML clean and repair utility which allows you to not only clean and otherwise manipulate HTML documents, but also traverse the document tree.',
        ),
        'timezonedb'        => array(
            'name' => 'Timezone Database to be used with PHP\'s date and time functions',
            'desc' => 'This extension is a drop-in replacement for the builtin timezone database that comes with PHP. You should only install this extension in case you need to get a later version of the timezone database than the one that ships with PHP.',
        ),
        'trader'            => array(
            'name' => 'Technical Analysis for Traders',
            'desc' => 'The trader extension is a free open source stock library based on TA-Lib. It\'s dedicated to trading software developers requiring to perform technical analysis of financial market data. Alongside many indicators like ADX, MACD, RSI, Stochastic, TRIX the candlestick pattern recognition and several vector arithmetic and algebraic functions are present.',
        ),
        'translit'          => array(
            'name' => 'Transliterates non-latin character sets to latin',
            'desc' => 'This extension allows you to transliterate text in non-latin characters (such as Chinese, Cyrillic, Greek etc) to latin characters.',
        ),
        'uploadprogress'    => array(
            'name' => 'An extension to track progress of a file upload.',
            'desc' => 'See http://svn.php.net/viewvc/pecl/uploadprogress/trunk/examples/ for a little example.',
        ),
        'uri_template'      => array(
            'name' => 'uri_template extension',
            'desc' => 'Implementation of URI Template(RFC6570) specification for PHP.',
        ),
        'uuid'              => array(
            'name' => 'UUID extension',
            'desc' => 'A wrapper around libuuid from the ext2utils project.',
        ),
        'wddx'              => array(
            'name' => 'WDDX',
            'desc' => 'These functions are intended for work with WDDX.',
        ),
        'weakref'           => array(
            'name' => 'Weak References',
            'desc' => 'Weak references provide a non-intrusive gateway to ephemeral objects. Unlike normal (strong) references, weak references do not prevent the garbage collector from freeing that object. For this reason, an object may be destroyed even though a weak reference to that object still exists. In such conditions, the weak reference seamlessly becomes invalid.',
        ),
        'xcache'            => array(
            'name' => 'XCache',
            'desc' => 'XCache is a fast, stable ​PHP opcode cacher that has been proven and is now running on production servers under high load.',
        ),
        'xdebug'            => array(
            'name' => 'Xdebug',
            'desc' => 'The Xdebug extension helps you debugging your script by providing a lot of valuable debug information.',
        ),
        'xmlreader'         => array(
            'name' => 'XMLReader',
            'desc' => 'The XMLReader extension is an XML Pull parser. The reader acts as a cursor going forward on the document stream and stopping at each node on the way.',
        ),
        'xmlrpc'            => array(
            'name' => 'XML-RPC',
            'desc' => 'These functions can be used to write XML-RPC servers and clients. You can find more information about XML-RPC at » http://www.xmlrpc.com/, and more documentation on this extension and its functions at » http://xmlrpc-epi.sourceforge.net/',
        ),
        'xmlwriter'         => array(
            'name' => 'XMLWriter',
            'desc' => 'This is the XMLWriter extension. It wraps the libxml xmlWriter API. This extension represents a writer that provides a non-cached, forward-only means of generating streams or files containing XML data.',
        ),
        'xrange'            => array(
            'name' => 'Numeric iterator primitives',
            'desc' => 'xrange is a compiled extension that provides numeric iteration primitives to PHP on top of SPL.',
        ),
        'xsl'               => array(
            'name' => 'XSL',
            'desc' => 'The XSL extension implements the XSL standard, performing » XSLT transformations using the » libxslt library',
        ),
        'yaf'               => array(
            'name' => 'Yet Another Framework',
            'desc' => 'The Yet Another Framework (Yaf) extension is a PHP framework that is used to develop web applications.',
        ),
        'zend_guard_loader' => array(
            'name' => 'Zend Guard Loader',
            'desc' => 'Zend Guard Loader is a free application that runs the files encoded using Zend Guard and enhances the overall performance of your PHP applications.',
        ),
        'zip'               => array(
            'name' => 'Zip',
            'desc' => 'This extension enables you to transparently read or write ZIP compressed archives and the files inside them.',
        ),
        'big_int'           => array(
            'name' => 'Big int',
            'desc' => 'Functions from this package are useful for number theory applications. For example, in two-keys cryptography.',
        ),
        'bitset'            => array(
            'name' => 'BITSET library',
            'desc' => 'Bitsets manipulation library',),
        'bloomy'            => array(
            'name' => 'Implementing a Bloom filter',
            'desc' => 'This extension implements a Bloom filter, which is a space-efficient probabilistic data structure that is used to test whether an element is a member of a set.',
        ),
        'coin_acceptor'     => array(
            'name' => 'Interface for serial coin acceptors',
            'desc' => 'This module let you control your local coin acceptor, using a serial connection and the simple management protocol.',
        ),
        'doublemetaphone'   => array(
            'name' => 'Double Metaphone functionality',
            'desc' => 'The Double Metaphone algorithm by Lawrence Philips allows a word to be broken down into its phonemes.',
        ),
        'magicwand'         => array(
            'name' => 'MagickWand',
            'desc' => 'This module enables PHP access to the ImageMagick MagickWand API. Here is a short example that annotates a flower:',
        ),

    );

    /**
     * @var AppPHP
     */
    private $_phpHelper = null;

    /**
     *
     */
    function __construct()
    {
        $this->_phpHelper = new AppPHP();
    }

    /**
     * @param $moduleName
     * @return bool
     */
    public function checkModule($moduleName)
    {
        $moduleName = trim($moduleName);
        return extension_loaded($moduleName);
    }

    /**
     * @param $key
     * @return bool|null
     */
    public function getPHPParam($key)
    {
        return $this->_phpHelper->getParam($key);
    }

    /**
     * @return array
     */
    public function getAllList()
    {
        ksort($this->_allModules);
        return $this->_allModules;
    }

}