<?php

echo '<div class="quotations-container">';
echo '<legend>'.JText::_("COM_DISPONIBILMENU_DISPONIBILMENU_LABEL_TODAYS_QUOTATIONS").'</legend>';

if(!empty($data['Result']['Rows'][0]))
{
	echo '<table>';
	echo '<thead>';
	echo '<tr>';
	
	foreach($data['Result']['Rows'][0] as $k => $v){
		if($k == 'Date') continue;
		echo '<th align="left" style="">'.$k.'</th>';
	}
	echo '</tr>';
	echo '</thead>';
	
	echo '<tbody>';
	foreach($data['Result']['Rows'] as $row)
	{
		echo '<tr>';
		foreach($row as $k => $v)
		{
			if($k == "Date") continue;
	    	echo '<td align="left" style="" >'.$v.'</td>';
		}
		echo '</tr>';
	}
	echo '</tbody>';
	echo '</table>';
}
echo '</div>';