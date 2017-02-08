<?php
defined( '_JEXEC' ) or die('Restricted access');
require_once('ringSelector.php');

class disponibilFunctionsF {
	
	private $limit;
	private $type;
	//private $label;
	private $data = array();
	
	public function __construct($type, $result, $lim){
		$this->data = $result;
		$this->limit = $lim;
		$this->type = $type;
		//$this->label = $label;
	}
	
    public function renderGrid()
	{
		$col = 0;
		$col_length = sizeof($this->data['Columns']);
		//echo $col_length;
		echo '<table class="order-table table" id="'.$this->type.'">';
		echo '<thead>';
		echo '<tr>';
		foreach ($this->data['Columns'] as $column)
		{		
				if($column['Name'] == "ID") continue;

				//echo '<th onclick="sortTable(tbody, '.$col++.', asc'.$col.'); asc'.$col.' *= -1;">'.$column['Name'].'</th>';
								
				switch($type = $column['Type'])
				{
					case 'Byte':
						echo '<th class="byteTH" onclick="sortTable(event, '.$col++.', ascByte); ascByte *= -1; ascBool = 1; ascInt = 1; ascStr = 1; ascDbl = 1; ascDate = 1; ascTime = 1;">'.$column['Name'].'</th>';
						break;
					case 'Boolean':
						echo '<th class="booleanTH" onclick="sortTable(event, '.$col++.', ascBool); ascBool *= -1; ascByte = 1; ascInt = 1; ascStr = 1; ascDbl = 1; ascDate = 1; ascTime = 1;">'.$column['Name'].'</th>';
						break;
					case 'Int32':
					 	echo '<th class="int32TH" onclick="sortTable(event, '.$col++.', ascInt); ascInt *= -1; ascByte = 1; ascStr = 1; ascBool = 1; ascDbl = 1; ascDate = 1; ascTime = 1;">'.$column['Name'].'</th>';
						break;
					case 'Double':
						echo '<th class="doubleTH" onclick="sortTable(event, '.$col++.', ascDbl); ascDbl *= -1; ascInt = 1; ascByte = 1; ascStr = 1; ascBool = 1; ascDate = 1; ascTime = 1;">'.$column['Name'].'</th>';
						break;
					case 'String':
						echo '<th class="stringTH" onclick="sortTable(event, '.$col++.', ascStr); ascStr *= -1; ascInt = 1; ascByte = 1; ascBool = 1; ascDbl = 1; ascDate = 1; ascTime = 1;">'.$column['Name'].'</th>';
						break;
					case 'DateTime':
						echo '<th class="dateTimeTH" onclick="sortTable(event, '.$col++.', ascDate); ascDate *= -1; ascInt = 1; ascByte = 1; ascBool = 1; ascDbl = 1; ascStr = 1; ascTime = 1">'.$column['Name'].'</th>';
						break;
					case 'TimeSpan':
						echo '<th class="timeSpanTH" onclick="sortTable(event, '.$col++.', ascTime); ascTime *= -1; ascInt = 1; ascBool = 1; ascByte = 1; ascDbl = 1; ascStr = 1; ascDate = 1;">'.$column['Name'].'</th>';
						break;
					default:
				}

		}
		if($this->type == 'assets' || $this->type == 'rings' || $this->type == 'currentassets')
			echo '<th>'.JText::_('COM_DISPONIBILMENU_DISPONIBILMENU_FIELD_DETAILS').'</th>';
		
		echo '</tr>';
		echo '</thead>';
		
		$tr = 0;
		$i = 0;
		
		$style = "display: table-row;";
		echo '<tbody id="tbody">';
		foreach ($this->data['Rows'] as $row)
		{
			if($tr == $this->limit) $style = 'display: none;';
			
			echo '<tr style="'.$style.'">';
			$date_format = 'Y-m-d H:i:s';
			$time_format = 'H:i:s';
			
			$id = "";
			global $ids;
			
			foreach ($row as $key => $field)
			{
				if($key == "ID"){
					$id = $field;
					$ids[$i++] = $id;
					continue;
				}

					switch ($type = gettype($field))
					{					
						case 'integer':
							echo '<td class="int32TD">'.$field.'</td>';
							break;		
							
						case 'string':
							$date = substr($field, 0, 19);
							$date_field = str_replace('T', ' ', $date);
							$date = DateTime::createFromFormat($date_format, $date_field);
							$time = DateTime::createFromFormat($time_format, $field);
							
							if($date)
							{
								$time = false;
								echo '<td class="dateTimeTD">'.$date->format('d-m-Y H:i:s').'</td>';
								//echo '<td class="dateTimeTD">'.$this->renderDisponibilDate($field).'</td>';
							}
								
							if($time)
								echo '<td class="timeStampTD">'.$time->format('H:i:s').'</td>';
								
	
							if(!$date && !$time)
								echo '<td class="stringTD">'.$field.'</td>';
																	
							break;
							
						case 'boolean':
							if($field == true)
								echo '<td class="booleanTD"><input type="checkbox" checked="true" onclick="return false" ></input></td>';
							else
								echo '<td class="booleanTD"><input type="checkbox" onclick="return false" ></input</td>';
							break;		
							
						case 'double':
							echo '<td class="doubleTD">'.$field.'</td>';
							break;
						
						default:
							 echo '<td class="other"><span>'.$field.'</span></td>';					
					}
			}
			switch($this->type){
				case 'assets':
					echo '<td><a class="details" href="index.php?option=com_disponibilmenu&view=assetdetails&id='.$id.'">'.JText::_('COM_DISPONIBILMENU_DISPONIBILMENU_FIELD_SHOW').'</a></td>';
					break;
				case 'rings':
					echo '<td><a class="details" href="index.php?option=com_disponibilmenu&view=ringdetails&id='.$id.'">'.JText::_('COM_DISPONIBILMENU_DISPONIBILMENU_FIELD_SHOW').'</a></td>';
					break;
				case 'currentassets':
					echo '<td><a class="details" href="index.php?option=com_disponibilmenu&view=assetdetails&id='.$id.'">'.JText::_('COM_DISPONIBILMENU_DISPONIBILMENU_FIELD_SHOW').'</a></td>';
					break;
				default:			
			}
			
			echo '</tr>';
			$tr++;
		}
		echo '</tbody>';
		echo '</table>';
		echo '<div name="limit-hidden" style="display:none;">'.$this->limit.'</div>';
		echo '<div id="columns-hidden" style="display:none;">'.$col_length.'</div>';		
	}
	
	
	public function renderGridDetails()
	{
		$arr_cols = $this->data['Columns'];
		$arr_rows = $this->data['Rows'];
		
		switch($this->type)
		{
			case "assetdetails":
				echo '<form id="details">';
				echo '<div class = "row">';
					echo '<fieldset class="left">';
						echo '<legend>'.JText::_('COM_DISPONIBILMENU_DISPONIBILMENU_LABEL_ASSET_DETAILS').'</legend>';
						echo '<div>';
							echo '<b><span class="dfields">'.JText::_('COM_DISPONIBILMENU_DISPONIBILMENU_LABEL_ASSET_CODE').': </span></b>';
							echo '<span class="dfields" style="text-align:left;">'.$this->renderDisponibilDate($arr_rows[0]['Code']).'</span>';
						echo '</div>';
						echo '<div>';
							echo '<b><span class="dfields">'.JText::_('COM_DISPONIBILMENU_DISPONIBILMENU_LABEL_ASSET_NAME').': </span></b>';
							echo '<span class="dfields" style="text-align:left;">'.$this->renderDisponibilDate($arr_rows[0]['Name']).'</span>';
						echo '</div>';
						echo '<div>';
							echo '<b><span class="dfields">'.JText::_('COM_DISPONIBILMENU_DISPONIBILMENU_LABEL_ASSET_DESCRIPTION').': </span></b>';
							echo '<span class="dfields" style="text-align:left;">'.$this->renderDisponibilDate($arr_rows[0]['Description']).'</span>';
						echo '</div>';
						echo '<div>';
							echo '<b><span class="dfields">'.JText::_('COM_DISPONIBILMENU_DISPONIBILMENU_LABEL_ASSET_INSTRUCTIONS').': </span></b>';
							echo '<span class="dfields" style="text-align:left;">'.$this->renderDisponibilDate($arr_rows[0]['Instructions']).'</span>';
						echo '</div>';
					echo '</fieldset>';
					
					echo '<fieldset class="right">';
						echo '<legend>'.JText::_('COM_DISPONIBILMENU_DISPONIBILMENU_LABEL_ASSET_LOCALIZATION').'</legend>';
						echo '<div>';
							echo '<b><span class="dfields">'.JText::_('COM_DISPONIBILMENU_DISPONIBILMENU_LABEL_ASSET_RING').': </span></b>';
							echo '<span class="dfields" style="text-align:left;">'.$this->renderDisponibilDate($arr_rows[0]['Ring']).'</span>';
						echo '</div>';
						echo '<div>';
							echo '<b><span class="dfields">'.JText::_('COM_DISPONIBILMENU_DISPONIBILMENU_LABEL_ASSET_RINGDESCRIPTION').': </span></b>';
							echo '<span class="dfields" style="text-align:left;">'.$this->renderDisponibilDate($arr_rows[0]['RingDescription']).'</span>';
						echo '</div>';
						echo '<div>';
							echo '<b><span class="dfields">'.JText::_('COM_DISPONIBILMENU_DISPONIBILMENU_LABEL_ASSET_ASSET_TYPE').': </span></b>';
							echo '<span class="dfields" style="text-align:left;">'.$this->renderDisponibilDate($arr_rows[0]['Asset Type']).'</span>';
						echo '</div>';
						echo '<div>';
							echo '<b><span class="dfields">'.JText::_('COM_DISPONIBILMENU_DISPONIBILMENU_LABEL_ASSET_ASSET_TYPE_DESCRIPTION').': </span></b>';
							echo '<span class="dfields" style="text-align:left;">'.$this->renderDisponibilDate($arr_rows[0]['Asset Type Description']).'</span>';
						echo '</div>';
					echo '</fieldset>';
				echo '</div>';
				
				
				echo '<div class = "row">';	
					echo '<fieldset class="left">';
						echo '<legend>'.JText::_('COM_DISPONIBILMENU_DISPONIBILMENU_LABEL_ASSET_INITIATOR').'</legend>';
						echo '<div>';
							echo '<b><span class="dfields">'.JText::_('COM_DISPONIBILMENU_DISPONIBILMENU_LABEL_ASSET_INITIATOR_NAME').': </span></b>';
							echo '<span class="dfields" style="text-align:left;">'.$this->renderDisponibilDate($arr_rows[0]['Initiator']).'</span>';
						echo '</div>';
						echo '<div>';
							echo '<b><span class="dfields">'.JText::_('COM_DISPONIBILMENU_DISPONIBILMENU_LABEL_ASSET_AGENCY').': </span></b>';
							echo '<span class="dfields" style="text-align:left;">'.$this->renderDisponibilDate($arr_rows[0]['Agency']).'</span>';
						echo '</div>';
						echo '<div>';
							echo '<b><span class="dfields">'.JText::_('COM_DISPONIBILMENU_DISPONIBILMENU_LABEL_ASSET_PROCEDURE').': </span></b>';
							echo '<span class="dfields" style="text-align:left;">'.$this->renderDisponibilDate($arr_rows[0]['Procedure']).'</span>';
						echo '</div>';
						echo '<div>';
							echo '<b><span class="dfields">'.JText::_('COM_DISPONIBILMENU_DISPONIBILMENU_LABEL_ASSET_DIRECTION').': </span></b>';
							echo '<span class="dfields" style="text-align:left;">'.$this->renderDisponibilDate($arr_rows[0]['Direction']).'</span>';
						echo '</div>';
					echo '</fieldset>';
					
					echo '<fieldset class="right">';
						echo '<legend>'.JText::_('COM_DISPONIBILMENU_DISPONIBILMENU_LABEL_ASSET_SETTINGS').'</legend>';
						echo '<div>';
							echo '<b><span class="dfields">'.JText::_('COM_DISPONIBILMENU_DISPONIBILMENU_LABEL_ASSET_EXPIRATIONDATE').': </span></b>';
							echo '<span class="dfields" style="text-align:left;">'.$this->renderDisponibilDate($arr_rows[0]['ExpirationDate']).'</span>';
						echo '</div>';
						echo '<div>';
							echo '<b><span class="dfields">'.JText::_('COM_DISPONIBILMENU_DISPONIBILMENU_LABEL_ASSET_CURRENCY').': </span></b>';
							echo '<span class="dfields" style="text-align:left;">'.$this->renderDisponibilDate($arr_rows[0]['Currency']).'</span>';
						echo '</div>';
						echo '<div>';
							echo '<b><span class="dfields">'.JText::_('COM_DISPONIBILMENU_DISPONIBILMENU_LABEL_ASSET_PAYMENTCURRENCY').': </span></b>';
							echo '<span class="dfields" style="text-align:left;">'.$this->renderDisponibilDate($arr_rows[0]['PaymentCurrency']).'</span>';
						echo '</div>';
						echo '<div>';
							echo '<b><span class="dfields">'.JText::_('COM_DISPONIBILMENU_DISPONIBILMENU_LABEL_ASSET_MEASURING_UNIT').': </span></b>';
							echo '<span class="dfields" style="text-align:left;">'.$this->renderDisponibilDate($arr_rows[0]['Measuring Unit']).'</span>';
						echo '</div>';
					echo '</fieldset>';
				echo '</div>';
				
				
				echo '<div class = "row">';	
					echo '<fieldset class="left">';
						echo '<legend>'.JText::_('COM_DISPONIBILMENU_DISPONIBILMENU_LABEL_ASSET_DELIVERY_INFORMATION').'</legend>';
						echo '<div>';
							echo '<b><span class="dfields">'.JText::_('COM_DISPONIBILMENU_DISPONIBILMENU_LABEL_ASSET_DELIVERY_TERM').': </span></b>';
							echo '<span class="dfields" style="text-align:left;">'.$this->renderDisponibilDate($arr_rows[0]['DeliveryTerm']).'</span>';
						echo '</div>';
						echo '<div>';
							echo '<b><span class="dfields">'.JText::_('COM_DISPONIBILMENU_DISPONIBILMENU_LABEL_ASSET_DELIVERY_CONDITION').': </span></b>';
							echo '<span class="dfields" style="text-align:left;">'.$this->renderDisponibilDate($arr_rows[0]['DeliveryConditions']).'</span>';
						echo '</div>';
						echo '<div>';
							echo '<b><span class="dfields">'.JText::_('COM_DISPONIBILMENU_DISPONIBILMENU_LABEL_ASSET_PACKING_METHOD').': </span></b>';
							echo '<span class="dfields" style="text-align:left;">'.$this->renderDisponibilDate($arr_rows[0]['PackingMethod']).'</span>';
						echo '</div>';
						echo '<div>';
							echo '<b><span class="dfields">'.JText::_('COM_DISPONIBILMENU_DISPONIBILMENU_LABEL_ASSET_PAYMENT_METHOD').': </span></b>';
							echo '<span class="dfields" style="text-align:left;">'.$this->renderDisponibilDate($arr_rows[0]['PaymentMethod']).'</span>';
						echo '</div>';
						echo '<div>';
							echo '<b><span class="dfields">'.JText::_('COM_DISPONIBILMENU_DISPONIBILMENU_LABEL_ASSET_CONTRACT_TERM').': </span></b>';
							echo '<span class="dfields" style="text-align:left;">'.$this->renderDisponibilDate($arr_rows[0]['ContractTerm']).'</span>';
						echo '</div>';
						echo '<div>';
							echo '<b><span class="dfields">'.JText::_('COM_DISPONIBILMENU_DISPONIBILMENU_LABEL_ASSET_WARRANTY_METHOD').': </span></b>';
							echo '<span class="dfields" style="text-align:left;">'.$this->renderDisponibilDate($arr_rows[0]['WarrantyMethod']).'</span>';
						echo '</div>';
					echo '</fieldset>';

					
					echo '<fieldset class="right">';
						echo '<legend>'.JText::_('COM_DISPONIBILMENU_DISPONIBILMENU_LABEL_ASSET_QUANTITY_DETAILS').'</legend>';
						echo '<div>';
							echo '<b><span class="dfields">'.JText::_('COM_DISPONIBILMENU_DISPONIBILMENU_LABEL_ASSET_QUANTITY').': </span></b>';
							echo '<span class="dfields" style="text-align:left;">'.$this->renderDisponibilDate($arr_rows[0]['Quantity']).'</span>';
						echo '</div>';
						echo '<div>';
							echo '<b><span class="dfields">'.JText::_('COM_DISPONIBILMENU_DISPONIBILMENU_LABEL_ASSET_PARTIALFLAG').': </span></b>';
							echo '<span class="dfields" style="text-align:left;">'.$this->renderDisponibilDate($arr_rows[0]['PartialFlag']).'</span>';
						echo '</div>';
					echo '</fieldset>';
					
					if( ( (int) $arr_rows[0]['BuyWarrantyFixed'] != 0  && (int) $arr_rows[0]['SellWarrantyFixed'] != 0 ) ||
					( (int) $arr_rows[0]['BuyWarrantyFixed'] != 0  && (int) $arr_rows[0]['SellWarrantyFixed'] != 0 ) ||
					( (int) $arr_rows[0]['BuyWarrantyPercent'] != 0  && (int) $arr_rows[0]['SellWarrantyPercent'] != 0) )
					{
						echo '<fieldset class="right" style="margin-top: 24px;">';
						echo '<legend>'.JText::_('COM_DISPONIBILMENU_DISPONIBILMENU_LABEL_ASSET_WARRANTIES').'</legend>';
						
						echo '<div>';
					    echo '<span class="dfields"></span>';
						echo '<span class="buy-sell-head">'.JText::_('COM_DISPONIBILMENU_DISPONIBILMENU_LABEL_ASSET_ONSELL').'</span>';
						echo '<span class="buy-sell-head">'.JText::_('COM_DISPONIBILMENU_DISPONIBILMENU_LABEL_ASSET_ONBUY').'</span>';
						echo '</div>';
						
						if((int) $arr_rows[0]['BuyWarrantyFixed'] != 0  && (int) $arr_rows[0]['SellWarrantyFixed'] != 0)
						{
							echo '<div>';
							echo '<b><span class="dfields">'.JText::_('COM_DISPONIBILMENU_DISPONIBILMENU_LABEL_ASSET_WARRANTYFIXED').': </span></b>';
							echo '<span  class="buy-sell" style="text-align:left;">'.$this->renderDisponibilDate($arr_rows[0]['BuyWarrantyFixed']).'</span>';
							echo '<span  class="buy-sell" style="text-align:left;">'.$this->renderDisponibilDate($arr_rows[0]['SellWarrantyFixed']).'</span>';
							echo '</div>';
						}
						
						if((int) $arr_rows[0]['BuyWarrantyMU'] != 0  && (int) $arr_rows[0]['SellWarrantyMU'] != 0)
						{
							echo '<div>';
							echo '<b><span class="dfields">'.JText::_('COM_DISPONIBILMENU_DISPONIBILMENU_LABEL_ASSET_WARRANTYMU').': </span></b>';
							echo '<span class="buy-sell" style="text-align:left;">'.$this->renderDisponibilDate($arr_rows[0]['BuyWarrantyMU']).'</span>'; 
							echo '<span class="buy-sell" style="text-align:left;">'.$this->renderDisponibilDate($arr_rows[0]['SellWarrantyMU']).'</span>';
							echo '</div>';
						}
						
						if((int) $arr_rows[0]['BuyWarrantyPercent'] != 0  && (int) $arr_rows[0]['SellWarrantyPercent'] != 0)
						{
							echo '<div>';
							echo '<b><span class="dfields">'.JText::_('COM_DISPONIBILMENU_DISPONIBILMENU_LABEL_ASSET_WARRANTYPercent').': </span></b>';
							echo '<span class="buy-sell" style="text-align:left;">'.$this->renderDisponibilDate($arr_rows[0]['BuyWarrantyPercent']).'</span>';
							echo '<span class="buy-sell" style="text-align:left;">'.$this->renderDisponibilDate($arr_rows[0]['SellWarrantyPercent']).'</span>';
							echo '</div>';		
						}
						
						echo '</fieldset>';
					echo '</div>';
					}
				echo '</div>';
				
				echo '</form>';
			break;

			case "ringdetails":
				echo '<table class="details">';
				echo '<tbody>';
				for($i = 0; $i < sizeof($arr_cols); $i++)
				{
					echo '<tr>';
						echo '<th>'.JText::_('COM_DISPONIBILMENU_DISPONIBILMENU_LABEL_RING_'.str_replace(' ', '_', strtoupper($arr_cols[$i]["Name"]))).':</th>';
						echo '<td>'.$arr_rows[0][$arr_cols[$i]['Name']].'</td>';
					echo '</tr>';
				}
				echo '</tbody>';
				echo '</table>';
			break;
		}
	}

	public function renderNotes(){
		//ini_set('pcre.backtrack_limit', 2000000);
		//ini_set('pcre.recursion_limit', 2000000);
		$td = 0;
		echo '<div class="tbl_notes">';
		//echo '<tbody>';
		foreach($this->data['Rows'] as $row){
			//if($td % 3 == 0) echo '<div class="notes_row">';
			//echo '<td class="outer">';
			echo '<div><table class="tbl_note">';
			echo '<tbody>';
			foreach($row as $key => $field){
				if($key == "ID") continue;
				echo '<tr>';
					//if($key == "Name" || $key == "Denumire") $key = "";
					if($key != "Nume Agentie"){
					    echo '<td><span><b>'.$key.'</b></span></td>';
					    echo '<td><span class="'.$key.'">'.str_replace(";", ", ", $field).'</span></td>';
				        }
					else
					    echo '<td class="tbl_name" colspan="2"><span class="'.$key.'">'.str_replace(";", ", ", $field).'</span></td>';
					
					//echo '</span>';
					//echo '<td style="float: left">'.$field.'</td>';
				echo '</tr>';
			}
			/*foreach($row as $key => $field){
				if($key == "ID") continue;
				echo '<div>';
					//if($key == "Name" || $key == "Denumire") $key = "";
					echo '<span><b>'.$key.'</b></span>';
					if($key != "") echo ':';
					echo '<span>'.$field;
					echo '</span>';
					//echo '<td style="float: left">'.$field.'</td>';
				echo '</div>';
			}*/
			echo '</tbody>';
			echo '</table></div>';
			//echo '</tr>';
			$td++;
			//if($td % 3 == 0) echo '</div>';
		
		}
		//echo '</tbody>';
		echo '</div>';
	}
	
	public function renderPagination($position)
	{
		$rows = sizeof($this->data['Rows']);
		$pages = ceil($rows/$this->limit);
		$filtered_rows = 0;
		$start = 1;
		$end = $rows < $this->limit ? $rows : $this->limit;
		echo '<div id="'.$position.'" class="pagination"> <!-- <span style="float: left; margin-right: 4px;">De la </span> -->';
		echo '<div class="'.$this->type.'-per_page" style="float: left; border-right: 1px solid #CECECE; padding-right: 16px;">'.JText::sprintf("COM_DISPONIBILMENU_DISPONIBILMENU_LABEL_PAGINATION", $start, $end, $rows).'</div>';
		echo '<div class="'.$this->type.'-navig" style="float: right; margin-left: 16px;">';
		for($page = 1; $page <= $pages; $page++)
			echo '<a name="'.$this->type.'-page'.$page.'" class="page'.$page.'" title="" onclick="navigate(this.name, '.$this->limit.','.$page.','.$pages.','.$filtered_rows.');">'.$page.'</a>';
		echo '</div>';
		echo '</div>';
		echo '<div id="pages-hidden" style="display:none;">'.$pages.'</div>';	
	}
	
	public function renderFilter(){
		if(isset($_GET['id_ring']))
			$checked = 'checked';
		else
			$checked = '';
		
		echo '<label class="filterT">'.JText::_("COM_DISPONIBILMENU_DISPONIBILMENU_LABEL_FILTER").'<input type="search" name="'.$this->type.'" data-table="order-table" id="" class="filterTable" type="text" oninput="filterTable(event);"></label>';
		
		if($this->type == 'assets')
			echo '<label class="viewA">'.JText::_("COM_DISPONIBILMENU_DISPONIBILMENU_LABEL_ARHIVE").'<input id="viewArhive" type="checkbox" '.$checked.' onchange="toggleArchive(this);"></label>';
	}
	

	
	public function renderArchive(){
		$rings = JFormHelper::loadFieldType('Ring', false);
		$ringsInput = $rings->getParentInput();
		$day = $this->zeroFill(getdate()[mday]);
		$month = $this->zeroFill(getdate()[mon]);
		$last_month = $this->zeroFill(getdate()[mon] - 1);
		$year = getDate()[year];
		$value = '';
				
		if(isset($_GET['date_start']) && isset($_GET['date_end']))
			$value = $_GET['date_start'].' - '.$_GET['date_end'];
		else
			$value = $day.'-'.$last_month.'-'.$year.' - '.$day.'-'.$month.'-'.$year;
		
		if(isset($_GET['id_ring']))
			$style = "display: block; margin-bottom: 12px;" ;
		else
			$style= "display: none;";
		
		echo '<div id="hiddenfields" style="'.$style.'">';
			echo '<label id="ringS" class="ringS">'.JText::_("COM_DISPONIBILMENU_DISPONIBILMENU_LABEL_RING_SELECTOR").$ringsInput.'</label>';
			echo '<div id="datepickerwell"><label>'.JText::_("COM_DISPONIBILMENU_DISPONIBILMENU_LABEL_DATE_SELECTOR").'</label>';
	        echo '<form class="form-horizontal">
	                 <fieldset>
	                    <div class="datepickercontrols">
	                       <span class="add-on input-group-addon">
								<i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
							</span>
							<input type="text" id="reservation" class="form-control" onchange="buildURL();" value="'.$value.'" /> 
	                     </div>
	                 </fieldset>
	               </form>
	            </div>';
	        
	        echo '<script type="text/javascript">';
	        echo '	document.getElementById("ringSelector").value = "'.$_GET['id_ring'].'"';
	        echo '</script>';
	        
	        //echo '<input id="send" type="submit" value="Send!" onclick="callback();"></input>';
	       echo '<a id="send" href="">'.JText::_("COM_DISPONIBILMENU_DISPONIBILMENU_LABEL_SEND").'</a>';
	       echo '<a id="base_url" href="index.php?option=com_disponibilmenu&view='.$this->type.'" style="display:none"></a>';
	        echo '<div id="loading"></div>';
	     echo '</div>';
	}
	

	public function zeroFill($n)
	{
		return ($n < 10 ? '0' : '') .$n;
	}
	
	private function renderDisponibilDate($d){
		$date = substr($d, 0, 19);
	
		$date = str_replace('T', ' ', $date);
		$format = 'Y-m-d H:i:s';
	
		$date = DateTime::createFromFormat($format, $date);
		
		if($date)
			$date = $date->format('d-m-Y H:i:s');
	
		$month = substr($date, 2, 3);
		$m = '';
		switch($month){
			case '-01': $m = ' Ian';
			break;
			case '-02': $m = ' Feb';
			break;
			case '-03': $m = ' Mar';
			break;
			case '-04': $m = ' Apr';
			break;
			case '-05': $m = ' Mai';
			break;
			case '-06': $m = ' Iun';
			break;
			case '-07': $m = ' Iul';
			break;
			case '-08': $m = ' Aug';
			break;
			case '-09': $m = ' Sep';
			break;
			case '-10': $m = ' Oct';
			break;
			case '-11': $m = ' Noi';
			break;
			case '-12': $m = ' Dec';
			break;
		}
	
		if($date)
			return str_replace($month, $m, $date);
		else
			return $d;
	}
		
} 

