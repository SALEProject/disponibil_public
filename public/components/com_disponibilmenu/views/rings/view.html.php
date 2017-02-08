<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla view library
jimport('joomla.application.component.view');

class DisponibilMenuViewRings extends JViewLegacy
{
	// Overwriting JView display method
	function display($tpl = null)
	{
		$config = JFactory::getConfig();
		$method = "getRings";
		$url = $config->get('webserviceurl').$method;
		$this->itemsperpage = $config->get('itemsperpage');
		
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
		
		/*if ( $status != 201 ) {
		 die("Error: call to URL $url failed with status $status, response $json_response, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
		} */
		
		curl_close($curl);
		$response = json_decode($json_response, true);
			
		//Assign data to the view
		$this->msg = $response;
		
		//Display the view
		parent::display($tpl);
	}
}