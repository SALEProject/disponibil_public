<?php
defined('_JEXEC') or die('Restricted access');

$df = new disponibilFunctionsF('assetdetails', $this->msg['AssetDetails'], $this->itemsperpage);
//echo'<h3 style="margin-left: 8px;">'.JText::_("COM_DISPONIBILMENU_DISPONIBILMENU_LABEL_ASSET_DETAILS").'</h3>';
$df->renderGridDetails();

$df = new disponibilFunctionsF('assetdocuments', $this->msg['AssetDocuments'], $this->itemsperpage);
echo'<h3 style="margin-left: 8px;">'.JText::_("COM_DISPONIBILMENU_DISPONIBILMENU_LABEL_ASSET_DOCUMENTS").'</h3>';
echo'<div class="filpag">';
$df->renderFilter();
$df->renderPagination('top');
echo'</div>';
$df->renderGrid();
$df->renderPagination('bottom');

$df = new disponibilFunctionsF('assethistory', $this->msg['AssetSessionHistory'], $this->itemsperpage);
echo'<h3 style="margin-left: 8px; margin-top: 56px;">'.JText::_("COM_DISPONIBILMENU_DISPONIBILMENU_LABEL_ASSET_HISTORY").'</h3>';
echo'<div class="filpag">';
$df->renderFilter();
$df->renderPagination('top');
echo'</div>';
$df->renderGrid();
$df->renderPagination('bottom');

$df = new disponibilFunctionsF('assetquotations', $this->msg['AssetQuotations'], $this->itemsperpage);
echo'<h3 style="margin-left: 8px; margin-top: 56px;">'.JText::_("COM_DISPONIBILMENU_DISPONIBILMENU_LABEL_ASSET_QUOTATIONS").'</h3>';
echo'<div class="filpag">';
$df->renderFilter();
$df->renderPagination('top');
echo'</div>';
$df->renderGrid();
$df->renderPagination('bottom');

$style = '';
if(JFactory::getLanguage()->getTag() === 'en-GB')
	$style = 'max-width: 116px';
else
	$style = 'max-width: 156px';

echo "<br/>";echo "<br/>";echo "<br/>";echo "<br/>";

echo '<div style="'.$style.'">
		<b><span class="dfields">'. JText::_('COM_DISPONIBILMENU_DISPONIBILMENU_LABEL_ASSET_TOTAL_GUESTS') .'</span></b>
		<span class="dfields" style="float:right; color: rgb(10, 166, 153);">'.$this->msg['allTimeVisits'].'</span>
	  </div>';
echo '<div style="'.$style.'">
		<b><span class="dfields">'. JText::_('COM_DISPONIBILMENU_DISPONIBILMENU_LABEL_ASSET_UNIQUE_GUESTS') .'</span></b>
		<span class="dfields" style="float:right; color: rgb(10, 166, 153);">'.$this->msg['uniqueVisits'].'</span>
	</div>';

