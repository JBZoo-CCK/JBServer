<?php

defined('P_ROOT') or die('Restricted access');

/**
 * Class AppWidget
 */
class AppWidget
{
    /**
     * Render table by data
     * @param array $tableData
     * @return string
     */
    static function renderTable(array $tableData)
    {
        $tableData = new AppData($tableData);

        $rows   = $tableData->get('rows', array());
        $params = new AppData($tableData->get('params', array()));

        $wrap = $params->get('wrap');

        $html = array();

        $html[] = '<table class="table table-hover">';
        foreach ($rows as $row) {
            $html[] = '<tr>';
            foreach ($row as $i => $cell) {

                if ($i == 0) {
                    $html[] = '<th style="width:200px;">' . $cell . '</th>';

                } else {

                    if ($wrap) {
                        $cell = '<' . $wrap . '>' . $cell . '</' . $wrap . '>';
                    }

                    $html[] = '<td>' . $cell . '</td>';
                }
            }

            $html[] = '</tr>';
        }

        $html[] = '</table>';

        return implode("\n ", $html);

    }

}
