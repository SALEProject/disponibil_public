<?php
defined('_JEXEC') or die('Restricted access');

$df = new disponibilFunctionsF('ringdetails', $this->msg['RingDetails'], $this->itemsperpage);
echo'<legend>'.JText::_("COM_DISPONIBILMENU_DISPONIBILMENU_LABEL_RING_DETAILS").'</legend>';
$df->renderGridDetails();


$df3 = new disponibilFunctionsF('currentassets', $this->msg['CurrentAssets'], $this->itemsperpage);
echo'<h3 style="margin-left: 8px;">'.JText::_("COM_DISPONIBILMENU_DISPONIBILMENU_LABEL_CURRENT_ASSETS").'</h3>';
echo'<div class="filpag">';
$df3->renderFilter();
//$df3->renderPagination('top');
echo'</div>';

$df3->renderGrid();

$df3->renderPagination('bottom');


$df2 = new disponibilFunctionsF('assettypes', $this->msg['AssetTypes'], $this->itemsperpage);
echo'<h3 style="margin-left: 8px;  margin-top: 56px;">'.JText::_("COM_DISPONIBILMENU_DISPONIBILMENU_LABEL_AVAILABLE_ASSETS").'</h3>';
echo'<div class="filpag">';
$df2->renderFilter();
//$df2->renderPagination('top');
echo'</div>';

$df2->renderGrid();

$df2->renderPagination('bottom');
