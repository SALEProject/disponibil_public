<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla view library
jimport('joomla.application.component.view');

class DisponibilMenuViewAssetdetails extends JViewLegacy{
	
	function display($tpl = null)
	{
		$input = JFactory::getApplication()->input;
		$id = $input->get('id');
		
		$config = JFactory::getConfig();
		$method = "getAssetDetails";
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
				"objects" => [ array("Arguments" =>	array("ID_Asset" => $id,
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
		$this->msg['AssetDetails'] = $response['Result'];
		
		
		$method = "getAssetDocuments";
		$url = $config->get('webserviceurl').$method;
		
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
		$this->msg['AssetDocuments'] = $response['Result'];
		
		
		$method = "getAssetQuotations";
		$url = $config->get('webserviceurl').$method;
		
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
		
		$date = date('Y-m-d H-i-s');
		$ip = $_SERVER['REMOTE_ADDR'];
		
		$db = JFactory::getDbo();
		$query = "INSERT INTO `jo_statistics`
				(`id_asset`, `datetime`, `ip`) 
				VALUES
				($id, '$date', '$ip')";
		
		$db->setQuery($query);
		$db->execute();
		
		$query = "SELECT COUNT(*) FROM `jo_statistics`
				WHERE `id_asset` = '$id' ";
		$db->setQuery($query);
		$alltimevisits = $db->loadResult();
		
		$query = "SELECT COUNT( DISTINCT `ip` ) FROM `jo_statistics`
				WHERE `id_asset` = '$id' ";
		$db->setQuery($query);
		$uniqueVisits = $db->loadResult();
				
			
		//Assign data to the view
		$this->msg['AssetQuotations'] = $response['Result'];
		$this->msg['allTimeVisits'] = $alltimevisits;
		$this->msg['uniqueVisits'] = $uniqueVisits;
		
		$method = "getAssetSessionHistory";
		$url = $config->get('webserviceurl').$method;
		
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
		$this->msg['AssetSessionHistory'] = $response['Result'];
		
		//Display the view
		parent::display($tpl);
	}
}