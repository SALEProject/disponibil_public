<?php
defined('_JEXEC') or die('Restricted access');

jimport('joomla.form.formfield');
require_once('libraries/joomla/form/fields/combo.php');

class JFormFieldRing extends JFormFieldList{
	protected  $type = 'Ring';
	
	public function getParentInput(){
		$this->id = 'ringSelector';
		$this->onchange = 'buildURL();';
		return $this->getInput();
	}
	
	protected function getOptions() {
		$config = JFactory::getConfig();
		$method = "getRings";
		
		$url = $config->get('webserviceurl').$method;

		$tag = "";
		$lang = JFactory::getLanguage();
		switch ($lang->getTag())
		{
			case 'en-GB': $tag = "GB";
			break;
			case 'ro-RO': $tag = "RO";
			break;
		}
		
		$data = array("SessionId" => "4",
				"CurrentState" => "login",
				"objects" => [ array("Arguments" =>	array("ID_Market" => "3",
						"Language" => $tag ) )]);
		
		$content = json_encode($data);
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
		
		$json_response = curl_exec($curl);
		$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

		curl_close($curl);
		$response = json_decode($json_response, true);
		
		$id = $response['Result']['Columns'][0]['Name'];
		$name = $response['Result']['Columns'][1]['Name'];		
		$rlen = sizeof($response['Result']['Rows']);
		
		$rings = array();
		$rings[0] = JText::_("COM_DISPONIBILMENU_DISPONIBILMENU_LABEL_CHOOSE_RING");
		
		for($i=0; $i<$rlen; $i++)
		{
			$rings[$response['Result']['Rows'][$i][$id]] = $response['Result']['Rows'][$i][$name];
				
		}
		return $rings;
	}
}