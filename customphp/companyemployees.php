<?php
/**
 * lwspMIservice
 * @author Ivan Komlev <ivankomlev@gmail.com>
 * @link http://joomlaboat.com
 * @GNU General Public License
 **/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

function ESCustom_companyemployees($row_new, $row_old)
{
    $db = JFactory::getDBO();
    $query = 'UPDATE #__customtables_table_people SET es_ismigrant='.(int)$row_new['es_ismigrant']
		.' WHERE id='.(int)$row_new['es_person'];
//(select count(id) from #__customtables_table_companyemployees WHERE es_person=#__customtables_table_people.id)>0';
    $db->setQuery($query);
    $db->execute();
}