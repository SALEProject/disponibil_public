<?php
defined('_JEXEC') or die('Restricted access');

$df = new disponibilFunctionsF('assetdetails', $this->msg['AssetDetails'], $this->itemsperpage);
//echo'<h3 style="margin-left: 8px;">'.JText::_("COM_DISPONIBILMENU_DISPONIBILMENU_LABEL_ASSET_DETAILS").'</h3>';
$df->renderGridDetails();

$df2 = new disponibilFunctionsF('assetdocuments', $this->msg['AssetDocuments'], $this->itemsperpage);
echo'<h3 style="margin-left: 8px;">'.JText::_("COM_DISPONIBILMENU_DISPONIBILMENU_LABEL_ASSET_DOCUMENTS").'</h3>';
echo'<div class="filpag">';
$df2->renderFilter();
$df2->renderPagination('top');
echo'</div>';
$df2->renderGrid();
$df2->renderPagination('bottom');

$df3 = new disponibilFunctionsF('assetquotations', $this->msg['AssetQuotations'], $this->itemsperpage);
echo'<h3 style="margin-left: 8px; margin-top: 56px;">'.JText::_("COM_DISPONIBILMENU_DISPONIBILMENU_LABEL_ASSET_QUOTATIONS").'</h3>';
echo'<div class="filpag">';
$df3->renderFilter();
$df3->renderPagination('top');
echo'</div>';
$df3->renderGrid();
$df3->renderPagination('bottom');

echo "<br/>";echo "<br/>";echo "<br/>";echo "<br/>";

echo '<div><b><span class="dfields">Numar total vizitatori: </span></b><span class="dfields" style="text-align:left;">'.$this->msg['allTimeVisits'].'</span></div>';
echo '<div><b><span class="dfields">Numar vizitatori unici: </span></b><span class="dfields" style="text-align:left;">'.$this->msg['uniqueVisits'].'</span></div>';