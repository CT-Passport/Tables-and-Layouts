<?php
/**
 * lwspMIservice
 * @author Ivan Komlev <ivankomlev@gmail.com>
 * @link http://joomlaboat.com
 * @GNU General Public License
 **/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

function ESCustom_people($row_new, $row_old)
{
    /*
    $db = JFactory::getDBO();
    $query = 'UPDATE #__customtables_table_people SET es_isemployee=(select count(id) from #__customtables_table_companyemployees where es_person=#__customtables_table_people.id)>0';
    
    $db->setQuery($query);
    $db->execute();

    if (isset($row_new['id']) and (int)$row_new['published'] == 1) {
        updateFieldValues($row_new, 'firstname');
        updateFieldValues($row_new, 'middlename');
        updateFieldValues($row_new, 'lastname');
    }
    */
}

function updateFieldValues(&$row_new, $fieldprefix)
{
    $db = JFactory::getDBO();
    $sets = [];

    if ($row_new['es_' . $fieldprefix . 'russubj'] != '' and ($row_new['es_' . $fieldprefix . 'rusgen'] == '' or $row_new['es_' . $fieldprefix . 'rusdat'] == '' or $row_new['es_' . $fieldprefix . 'rusabl'] == ''
            or $row_new['es_' . $fieldprefix . 'rusaccus'] == '' or $row_new['es_' . $fieldprefix . 'rusprep'] == '')) {
        $url = "https://htmlweb.ru/json/service/inflect/?inflect=" . urlencode($row_new['es_' . $fieldprefix . 'russubj']) . '&letter_case=ucfirst';

        $json = file_get_contents($url);

        $j = json_decode($json);
        $w = $j->items;

        if ($row_new['es_' . $fieldprefix . 'rusgen'] == '') //родительный
            $sets[] = 'es_' . $fieldprefix . 'rusgen=' . $db->quote($w[1]);

        if ($row_new['es_' . $fieldprefix . 'rusdat'] == '') //дательный
            $sets[] = 'es_' . $fieldprefix . 'rusdat=' . $db->quote($w[2]);

        if ($row_new['es_' . $fieldprefix . 'rusaccus'] == '') //винительный
            $sets[] = 'es_' . $fieldprefix . 'rusaccus=' . $db->quote($w[3]);

        if ($row_new['es_' . $fieldprefix . 'rusabl'] == '') //творительный
            $sets[] = 'es_' . $fieldprefix . 'rusabl=' . $db->quote($w[4]);

        if ($row_new['es_' . $fieldprefix . 'rusprep'] == '') //предложный
            $sets[] = 'es_' . $fieldprefix . 'rusprep=' . $db->quote($w[5]);

        $query = 'UPDATE #__customtables_table_people SET ' . implode(',', $sets) . ' WHERE id = ' . (int)$row_new['id'];
        $db->setQuery($query);
        $db->execute();
    }
}