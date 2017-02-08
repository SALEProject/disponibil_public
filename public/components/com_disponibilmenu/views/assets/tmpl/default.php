<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

//var_dump($this->msg['Result']);
$df = new disponibilFunctionsF('assets', $this->msg['Result'], $this->itemsperpage);

echo'<div class="filpag">';
$df->renderFilter();
$df->renderPagination('top');
echo'</div>';

$df->renderArchive();

if(isset($_GET['send']))
	callback();

function callback(){
	echo '<script>alert("Yusss")</script>';
}

$df->renderGrid();

$df->renderPagination('bottom');

//echo'<span style="display: block;" id="webservurl">'.$this->url.'</span>';




