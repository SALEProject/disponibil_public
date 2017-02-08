<?php
defined('_JEXEC') or die;

function parseDate($date){
	$date = substr($date, 0, 19);
	
	$date = str_replace('T', ' ', $date);
	$format = 'Y-m-d H:i:s';
	
	$date = DateTime::createFromFormat($format, $date);
	if($date){
		$date = $date->format('d-m H:i:s');
		
		$month = substr($date, 2, 3);
		$m = '';
		switch($month){
			case '-01': $m = ' Ian';
			break;
			case '-02': $m = ' Feb';
			break;
			case '-03': $m = ' Mar';
			break;
			case '-04': $m = ' Apr';
			break;
			case '-05': $m = ' Mai';
			break;
			case '-06': $m = ' Iun';
			break;
			case '-07': $m = ' Iul';
			break;
			case '-08': $m = ' Aug';
			break;
			case '-09': $m = ' Sep';
			break;
			case '-10': $m = ' Oct';
			break;
			case '-11': $m = ' Noi';
			break;
			case '-12': $m = ' Dec';
			break;
		}
		
		return str_replace($month, $m, $date);
	}
	return false;
}
?>

<div id="main-alert" >
	<p><span class="time"><?php echo parseDate($news['Result']['Rows'][0]['Date']);?></span>
		<?php echo $news['Result']['Rows'][0]["Message"];?>
	</p>
</div>
<div id="alerts-popup" style="display: none;" >
	<ul id="alerts-list">
<?php foreach($news['Result']['Rows'] as $row) {
		?>
 		<li>
			<span class="time"><?php echo parseDate($row['Date']);?></span>
			<span><?php echo $row["Message"]?></span>
		</li>
		<?php } ?>		
	</ul> 
</div>
