<?php
defined('_JEXEC') or die;
// Include the syndicate functions only once
require_once dirname(__FILE__) . '/helper.php';

$top = htmlspecialchars($params->get('top'));
$right = htmlspecialchars($params->get('right'));

$data = modDisponibilMainHelper::getMain($params);
require JModuleHelper::getLayoutPath('mod_disponibilmain');