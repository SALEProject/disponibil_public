<?php
defined('_JEXEC') or die('Restricted access');

// import joomla controller library
jimport('joomla.application.component.controller');
jimport('joomla.html.pagination');

if(!class_exists('disponibilFunctionsF'))require('helpers/disponibilfunctionsf.php');

$document = JFactory::getDocument();

$document->addScript(JUri::base(true) .'/components/com_disponibilmenu/assets/js/all_functions.js');
$document->addScript(JUri::base(true) .'/components/com_disponibilmenu/assets/js/date.js');
$document->addScript(JUri::base(true) .'/components/com_disponibilmenu/assets/js/dateRangePicker/jquery.min.js');
$document->addScript(JUri::base(true) .'/components/com_disponibilmenu/assets/js/dateRangePicker/moment.js');
$document->addScript(JUri::base(true) .'/components/com_disponibilmenu/assets/js/dateRangePicker/daterangepicker.js');
$document->addScript(JUri::base(true) .'/components/com_disponibilmenu/assets/js/dateRangePicker/initdatepicker.js');

$document->addStyleSheet('http://netdna.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css');
//$document->addStyleSheet(JUri::base(true) .'/media/jui/css/bootstrap.min.css');
$document->addStyleSheet(JUri::base(true) .'/components/com_disponibilmenu/assets/css/daterangepicker-bs3.css');

$controller = JControllerLegacy::getInstance("DisponibilMenu");

// Perform the Request task
$input = JFactory::getApplication()->input;
$controller->execute($input->getCmd('task'));

// Redirect if set by the controller
$controller->redirect();

?>