<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla view library
jimport('joomla.application.component.view');

class DisponibilMenuViewRingdetails extends JViewLegacy{
	
	function display($tpl = null)
	{
		$input = JFactory::getApplication()->input;
		$id = $input->get('id');
		
		$config = JFactory::getConfig();
		$method = "getRingDetails";
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
				"objects" => [ array("Arguments" =>	array("ID_Ring" => $id,
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
		$this->msg['RingDetails'] = $response['Result'];		
		
		$method = "getAssetTypes";
		$url = $config->get('webserviceurl').$method;
		
		$content = json_encode($data);
		
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
		
		$json_response = curl_exec($curl);
		$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		
		/*if ( $status != 200 ) {
			die("Error: call to URL $url failed with status $status, response $json_response, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
		}*/
		
		curl_close($curl);
		$response = json_decode($json_response, true);
			
		//Assign data to the view
		$this->msg['AssetTypes'] = $response['Result'];
		
		$method = "getAssets";
		$url = $config->get('webserviceurl').$method;
		
		$ring_id = -1;
		
		if(isset($_GET['id']))
			$ring_id = $_GET['id'];
		
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
				"objects" => [ array("Arguments" => array("ID_Market" => "3",
						"Language" => $tag,
						"ID_Ring" => (int) $ring_id
						)
				)
		
				]);
		
		$content = json_encode($data);
		
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
		
		$json_response = curl_exec($curl);
		
		$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		
		if ( $status != 200 ) {
			die("Error: call to URL $url failed with status $status, response $json_response, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
		}
		
		curl_close($curl);
		
		$response = json_decode($json_response, true);
			
		//Assign data to the view
		$this->msg['CurrentAssets'] = $response['Result'];
		
		//Display the view
		parent::display($tpl);
		
	}
}