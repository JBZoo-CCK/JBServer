<?php

$helper = new AppOverview();
$la = $helper->getLoadAvg();
$uptimeData = $helper->getServerUptime();
$memory = $helper->getMemoryData();

?>
<h1><a href="<?php echo App::getRootUrl(); ?>"><?php echo $_SERVER['HTTP_HOST']; ?></a></h1>

<p><strong>Полное имя сервера:</strong> <em><?php echo phpUname(); ?></em></p>
<p>&nbsp;</p>

<?php if (!empty($la)) : ?>
    <p>
        <strong>Текущая загрузка системы (load average):</strong>
        <span title="За 1 минуту"
              class="label label-<?php echo $la[0]['state']; ?>"><?php echo $la[0]['value']; ?></span> /
        <span title="За 5 минут"
              class="label label-<?php echo $la[1]['state']; ?>"><?php echo $la[1]['value']; ?></span> /
        <span title="За 15 минут"
              class="label label-<?php echo $la[2]['state']; ?>"><?php echo $la[2]['value']; ?></span>
    </p>
    <p>&nbsp;</p>
<?php endif; ?>

<div class="row">
    <div class="col-md-12">
        <h4>Программное обеспечение сервера</h4>

        <?php echo AppWidget::renderTable(array('rows' => array(
            array('Operation system', phpUname('s') . " " . phpUname('r') . " " . phpUname('v')),
            array('Architecture', phpUname('m')),
            array('Apache', $helper->getApacheVersion()),
            array('PHP', $helper->getPHPVersion() . ' ( ' . php_sapi_name() . ' )'),
            array('MySQL', $helper->getMySQLVersion()),
            array('Zend Engine', $helper->getZendEngineVersion()),
        )));?>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <h4>Время работы сервера (uptime)</h4>
        <?php echo AppWidget::renderTable(array('rows' => array(
            array('Server uptime', $helper->secToHuman($uptimeData['uptime'])),
            array('Server spent idle', $helper->secToHuman($uptimeData['idle']) . ' ' . $uptimeData['percent']),
            array('Server (Last restart)', $helper->getServerRestartDate()),
            array('MySQL uptime', $helper->secToHuman($helper->getMySQLUptime())),
            array('MySQL (Last restart)', $helper->getMysqlRestartDate())
        ))); ?>

        <h4>Память сервера</h4>
        <?php echo AppWidget::renderTable(array('rows' => array(
            array('Общая память сервера', $memory['total']),
            array('Доступная память сервера', $memory['avail']),
            array('Свободно на диске', $helper->getFreeDiskSpace()),
        )));?>
    </div>

    <div class="col-md-6">
        <h4>Разное</h4>
        <?php echo AppWidget::renderTable(array(
            'rows' => array(
                array('Server time', date(DATE_RFC822, time())),
                array('Hostname', phpUname('n')),
                array('Server IP', gethostbyname(phpUname('n'))),
                array('Username', get_current_user() . " ( uid: " . getmyuid() . ", gid: " . getmygid() . ' )'),
                array('Curent Path', '<code>' . getcwd() . '</code>'),
                array('Server Type', $_SERVER['SERVER_SOFTWARE']),
                array('Server Admin', $_SERVER['SERVER_ADMIN']),
                array('Server Signature', strip_tags($_SERVER['SERVER_SIGNATURE'])),
                array('Server Protocol', $_SERVER['SERVER_PROTOCOL']),
                array('Server Mode', $_SERVER['GATEWAY_INTERFACE']),
            )
        ));
        ?>
    </div>
</div>
