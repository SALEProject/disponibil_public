<?php
defined('_JEXEC') or die;
// Include the syndicate functions only once
require_once dirname(__FILE__) . '/helper.php';

$news = modDisponibilNewsHelper::getNews($params);
require JModuleHelper::getLayoutPath('mod_disponibilnews');

