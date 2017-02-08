<?php 
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla view library
jimport('joomla.application.component.view');

class DisponibilMenuViewAssets extends JViewLegacy{
	// Overwriting JViewLegacy display method
	function display($tpl = null)
	{
		$config = JFactory::getConfig();
		$method = "getAssets";
		$this->url = $config->get('webserviceurl').$method;
		$this->itemsperpage = $config->get('itemsperpage');
		
		$ring_id = -1;
		$date_start = '';
		$date_end = '';
		$format = 'd-m-Y';
		
		if(isset($_GET['id_ring']) && $_GET['id_ring'] != -1)
			$ring_id = $_GET['id_ring'];
		
		if(isset($_GET['date_start']) && isset($_GET['date_end']))
		{
			$date_start = $_GET['date_start'];
			$date_end = $_GET['date_end'];
			
			$date_start = DateTime::createFromFormat($format, $date_start);
			$date_start = $date_start->format('Y-m-d');
			
			$date_end = DateTime::createFromFormat($format, $date_end);
			$date_end = $date_end->format('Y-m-d');
		}
		/*else
		{
			$date = getdate(date("U"));
			$date_start = $date['mday'].'-'.($date['mon'] - 1).'-'.$date['year'];
			$date_end = $date['mday'].'-'.$date['mon'].'-'.$date['year'];
		}*/
		

		
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
					  									  "ID_Ring" => (int) $ring_id,
					  									  "Date_Start" => $date_start,
					  									  "Date_End" => $date_end)
					  								/*array("ID_Market" => "3",
					  									  "anystatus" => true,
					  									   "all" => true) */
					  						) 
					  			    
					  ]);
		
		$content = json_encode($data);
				
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $this->url);
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
		$this->msg = $response;
		
		//Display the view
		parent::display($tpl);
	}
}

// No direct access to this file
/*defined('_JEXEC') or die('Restricted access');

// import Joomla view library
jimport('joomla.application.component.view');

class DisponibilMenuViewDisponibilMenu extends JViewLegacy{
	// Overwriting JView display method
	function display($tpl = null)
	{
		$url = "http://192.168.21.107:51368/BRMRead.svc/select/Rings/getAssets";

		$data = array("SessionId" => "4",
				"CurrentState" => "login",
				"objects" => [ array("Arguments" =>
						array("ID_Market" => "3",
								"anystatus" => true,
								"all" => true)
				)
				]
		);
		$content = json_encode($data);
		echo "Content: ".$content;
		
		$options = array(
				'http' => array(
						'method'  => 'POST',
						'content' => $content,
						'header'=>  "Content-Type: application/json\r\n" .
						"Accept: application/json\r\n"
				)
		);

		$context  = stream_context_create($options);
		$result = file_get_contents( $url, false, $context );
		$response = json_decode( $result );
			
		//Assign data to the view
		$this->msg = $result;

		//Display the view
		parent::display($tpl);
	}

}*/