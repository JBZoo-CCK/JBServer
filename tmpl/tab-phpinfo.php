<?php

function renderPHPInfoTable($key = -1)
{
    ob_start();
    phpinfo($key);
    $phpInfo = ob_get_contents();
    ob_end_clean();

    preg_match_all('#<body[^>]*>(.*)</body>#siU', $phpInfo, $output);

    $output = preg_replace('#<table[^>]*>#', '<table class="table table-striped table-hover">', $output[1][0]);
    $output = preg_replace('#(\w),(\w)#', '\1, \2', $output);
    $output = preg_replace('#<hr />#', '', $output);
    $output = str_replace('<div class="center">', '', $output);
    $output = preg_replace('#<tr class="h">(.*)<\/tr>#', '<thead><tr class="h">$1</tr></thead><tbody>', $output);
    $output = str_replace('</table>', '</tbody></table>', $output);
    $output = str_replace('</div>', '', $output);
    return $output;
}

$tabs = array(
    'general'       => 'General',
    'configuration' => 'Configuration',
    'modules'       => 'Modules',
    'environment'   => 'Environment',
    'variables'     => 'Variables',
);

$bodyList = $headerList = array();
foreach ($tabs as $tabKey => $tabName) {
    $groupId      = constant('INFO_' . strtoupper($tabKey));
    $headerList[] = '<li><a data-toggle="tab" href="#tab-phpinfo-' . $tabKey . '">' . $tabName . '</a></li>';
    $bodyList[]   = '<div class="tab-pane" id="tab-phpinfo-' . $tabKey . '">' . renderPHPInfoTable($groupId) . '</div>';
}

?>

<p>&nbsp;</p>
<ul class="nav nav-tabs" id="tabs-phpinfo">
    <?php echo implode("\n ", $headerList); ?>
</ul>
<div class="tab-content">
    <?php echo implode("\n ", $bodyList); ?>
</div>
