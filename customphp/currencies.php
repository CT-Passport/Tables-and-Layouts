<?php
/**
 * lwspMIservice
 * @author Ivan Komlev <ivankomlev@gmail.com>
 * @link http://joomlaboat.com
 * @GNU General Public License
 **/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

function ESCustom_currencies($row_new,$row_old)
{
	if(isset($row_new['id']) and (int)$row_new['listing_published']==1)
	{
		$db = JFactory::getDBO();
		
		if($row_new['es_namerussubj']!='' and ($row_new['es_namerusgen'] == '' or $row_new['es_namerusdat'] == '' or $row_new['es_namerusabl'] == ''
			or $row_new['es_namerusaccus'] == '' or $row_new['es_namerusprep'] == ''))
		{
			
			$url = "https://htmlweb.ru/json/service/inflect/?inflect=".urlencode($row_new['es_namerussubj']).'&letter_case=ucfirst';
	
			$json = file_get_contents($url);
			
			$j = json_decode($json);
			$w = $j->items;
		
			$sets = [];
			if($row_new['es_namerusgen'] == '') //родительный
				$sets[]='es_namerusgen='.$db->quote($w[1]);
			
			if($row_new['es_namerusdat'] == '') //дательный
				$sets[]='es_namerusdat='.$db->quote($w[2]);
				
			if($row_new['es_namerusaccus'] == '') //винительный
				$sets[]='es_namerusaccus='.$db->quote($w[3]);
				
			if($row_new['es_namerusabl'] == '') //творительный
				$sets[]='es_namerusabl='.$db->quote($w[4]);
				
			if($row_new['es_namerusprep'] == '') //предложный
				$sets[]='es_namerusprep='.$db->quote($w[5]);
			
			$query = 'UPDATE #__customtables_table_currencies SET '.implode(',',$sets).' WHERE id = '.(int)$row_new['id'];
			
			$db->setQuery( $query );
			$db->execute();
		} 
	}
}
