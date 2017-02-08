<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
?>

<?php
$rings = $this->msg['Result']['Rows'];
//var_dump($rows);
$n = '';
$i = 0;

$lang = JFactory::getLanguage();
switch ($lang->getTag())
{
	case 'en-GB': $n = "Name";
	break;
	case 'ro-RO': $n = "Denumire Ring";
	break;
}
	
/*foreach($rows as $row){
	$rings[$i++] = $row[$n];
}*/

//asort($rings);
?>
<table id="all_rings">
<tbody>
<td class="otherRingsTitle">Ringuri</td>
<td class="all_rings">
<?php foreach($rings as $i => $ring){ ?>
	<a style="color:#0AA699" href="index.php?option=com_disponibilmenu&view=ringdetails&id=<?php echo $ring['ID'];?>"><?php echo $ring[$n];?></a>
	<span style="color:#333">|</span>
<?php }?>
</td>
</tbody>
</table>

<?php
/*$df = new disponibilFunctionsF('rings', $this->msg['Result'], $this->itemsperpage);

echo'<div class="filpag">';
$df->renderFilter();
$df->renderPagination('top');
echo'</div>';

$df->renderGrid();

$df->renderPagination('bottom');*/

