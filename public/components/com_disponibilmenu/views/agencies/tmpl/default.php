<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

$df = new disponibilFunctionsF('agencies', $this->msg['Result'], $this->itemsperpage);

/*echo'<div id="filpag">';
$df->renderFilter();
$df->renderPagination('top');
echo'</div>';

$df->renderGrid();

$df->renderPagination('bottom');*/

$df->renderNotes();

