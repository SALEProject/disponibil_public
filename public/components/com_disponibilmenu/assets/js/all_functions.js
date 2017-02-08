var ascStr, ascInt, ascBool, ascDbl ,ascByte, ascDate, ascTime;
//var tbody, rows, rlen;
var filtered_rows;
var arr_pos;
var current_page, pages, limit;
var assettypes = '';
var ring = '';
var date = '';
var send = '';
var base_url = '';
	
// both window.onload and addEventListener('readystatechange', function()) initialize js
window.onload = function(){
};

document.addEventListener('readystatechange', function() {
	if (document.readyState === 'complete') 
	{
		ascStr = 1,
		ascInt = 1,
		ascBool = 1,
		ascDbl = 1,
		ascByte = 1,
		ascDate = 1,
		ascTime = 1;
		
		current_page = 1;
		limit = document.getElementsByName('limit-hidden')[0].innerHTML;
		
		//tbody = document.getElementById('tbody');
		//rows = tbody.rows;
		
		//rlen = tbody.rows.length;
		filtered_rows = 0;
		
		arr_pos = new Array();
		
		pages = document.getElementById('pages-hidden').innerHTML;
				
		/*		if(rlen >= limit)
			end = current_page * limit;
		else
			end = rlen;*/
		
		//document.getElementsByClassName('page1')[0].className = "page1-current";
		//document.getElementsByClassName('page1')[1].className = "page1-current";
		
/*		var inputs = document.getElementsByTagName('input');
		for(var i = inputs.length; i--;)
		{
			if(inputs[i].className != 'filterTable')
				inputs[i].remove(); 	
		}*/
				
		var pages1 = document.getElementsByClassName('page1');
		for(var i = pages1.length; i--;)
		{
			pages1[i].className = "page1-current";
		}
		
		//var datetimes = document.getElementsByClassName('dateTimeTD');
		//alert(dates.length);
		/*for(var i = 0; i < datetimes.length; i++){
			var datetime = datetimes[i].innerHTML;
			datetime = arangeDate(datetime);
			datetimes[i].innerHTML = datetime;
		}*/
		
		buildURL();
						
		//tableFilter.init();
	}
});

function arangeDate(datetime){
	datetime = datetime.split(" ");
	var date = datetime[0];
	var time = datetime[1];
	
	date = date.split("-");
	//format is DD-MM-YYYY
	datetime = date[2] + '-' + date[1] + '-' + date[0] + ' ' + time;
	return datetime.toString();
}

// table filter for multiple inputs/tables
var tableFilter = (function(Arr){
	var _input;
	
	function _onInputEvent(e){
		_input = e.target;
		
		var tables = document.getElementsByClassName(_input.getAttribute('data-table'));
		Arr.forEach.call(tables, function(table){
			Arr.forEach.call(table.tBodies, function(tbody){
				Arr.forEach.call(tbody.rows, _filter);
			});
		});
	}
	
	function _filter(row){
		var text = row.textContent.toLowerCase(),
			val = _input.value.toLowerCase();
		
		row.style.display = text.indexOf(val) === -1 ? 'none' : 'table-row';
	}
	
	return {
		init: function() {
			var inputs = document.getElementsByClassName('filterTable');
			Arr.forEach.call(inputs, function(input) {
				input.oninput = _onInputEvent;
			});
		}
	};
})(Array.prototype);


function filterTable(event){
	var text, i, input, val;
	var navigation_a, navigation_b;	
	var has_filter = false;
	
	//limit = document.getElementByClassName('limit-hidden')[0].innerHTML;

	
	input = event.target;
	val = input.value.toLowerCase();
	
	var table = document.getElementById(input.name);
	tbody = table.tBodies[0];
	rows = tbody.rows;
	rlen = rows.length;
	
	navigation_a = document.getElementsByClassName(input.name + "-navig")[0];
	navigation_b = document.getElementsByClassName(input.name + "-navig")[1];
	navigation_a.innerHTML = '';
	navigation_b.innerHTML = '';
	
	arr_pos = [];
	filtered_rows = 0;
	filtered_pages = 0;

	if(val != '')
	{			
		for(i = 0; i < rlen; i++)
		{
			rows[i].style.display = 'none';
			text = rows[i].textContent.toLowerCase();
						
			if(text.indexOf(val) === -1)
				rows[i].style.display = 'none';
				
			else
			{
				arr_pos[filtered_rows++] = i;
				
				//only display first page
				if(filtered_rows <= limit){ 
					rows[i].style.display = 'table-row';
				}
			}		
		}
		
	    filtered_pages = Math.ceil(filtered_rows/limit);
		current_page = 1;
		end = filtered_rows < limit ? filtered_rows : current_page * limit;
				
		for(var page = 1; page <= filtered_pages; page++)
		{
			navigation_a.innerHTML += '<a name="' + input.name + '-page'+ page +'" class="page' + page + '" onclick="navigate(this.name,' + limit + ',' + page + ',' + filtered_pages + ',' + filtered_rows + ');">'+ page +'</a>';
			navigation_b.innerHTML += '<a name="' + input.name + '-page'+ page +'" class="page' + page + '" onclick="navigate(this.name,' + limit + ',' + page + ',' + filtered_pages + ',' + filtered_rows + ');">'+ page +'</a>';
		}
		
		document.getElementsByClassName(input.name + "-per_page")[0].innerHTML = ((current_page - 1)*limit + 1) + " la " + end + " din " + filtered_rows;
		document.getElementsByClassName(input.name + "-per_page")[1].innerHTML = ((current_page - 1)*limit + 1) + " la " + end + " din " + filtered_rows;	
		
		document.getElementsByName(input.name + '-page' + current_page)[0].className = "page" + current_page + "-current";
		document.getElementsByName(input.name + '-page' + current_page)[1].className = "page" + current_page + "-current";
		
		has_filter = true;
	}
	
	else
	{   
		if(rlen < limit)
			end = rlen;
		else
			end = limit;
		
		for(i = 0; i < rlen; i++)
			rows[i].style.display = "none";
		
		for(i = (current_page-1) * limit; i < end; i++)
			rows[i].style.display = "table-row";
		
		for(var page = 1; page <= pages; page++)
		{
			navigation_a.innerHTML += '<a name="' + input.name + '-page'+ page +'" class="page' + page + '" onclick="navigate(this.name,' + limit + ',' + page + ',' + pages + ',' + filtered_rows + ');">'+ page +'</a>';
			navigation_b.innerHTML += '<a name="' + input.name + '-page'+ page +'" class="page' + page + '" onclick="navigate(this.name,' + limit + ',' + page + ',' + pages + ',' + filtered_rows + ');">'+ page +'</a>';
		
			document.getElementsByName(input.name + '-page'+page)[0].className = "";
			document.getElementsByName(input.name + '-page'+page)[1].className = "";
		}
		
		document.getElementsByClassName(input.name + "-per_page")[0].innerHTML = ((current_page - 1)*limit + 1) + " la " + end + " din " + rlen;
		document.getElementsByClassName(input.name + "-per_page")[1].innerHTML = ((current_page - 1)*limit + 1) + " la " + end + " din " + rlen;
			
		document.getElementsByName(input.name + '-page' + current_page)[0].className = "page" + current_page + "-current";
		document.getElementsByName(input.name + '-page' + current_page)[1].className = "page" + current_page + "-current";
	}
}

function getParentTable(elem)
{
	while(elem)
	{
		elem = elem.parentNode;
		if(elem.tagName.toLowerCase() === 'table')
			return elem;
	}
	return undefined;
}

function sortTable(event, col, asc){
	var arr = new Array(),
		i, j;

	input = event.target;
	table = getParentTable(input);
	tbody = table.tBodies[0];
	rows = tbody.rows;
	rlen = rows.length;
	
	if(arr_pos.length > 0)
	{ 
		
		for(i = 0; i < arr_pos.length; i++)
		{
			cells = rows[arr_pos[i]].cells;
			clen = cells.length;
			arr[i] = new Array();
			for(j = 0; j < clen; j++)
				arr[i][j] = cells[j].innerHTML;
		}
		
		var type = getColType(arr, col);
		
		if(type == 'number')
		{
			arr.sort(function (a, b) {
				return (a[col] - b[col]) > 0 ? asc : -1 * asc;
			});
		}
		else if(type == 'string')
		{
			arr.sort(function (a, b) {
				return (a[col] == b[col]) ? 0 : ((a[col] > b[col]) ? asc : -1 * asc);
			});
		}	
		else if(type == 'datetime'){
			
			for(var i = 0; i < arr_pos.length; i++){
				arr[i][col] = parseDateString(arr[i][col]);
			}
			
			arr.sort(function (a, b) {
				return (a[col] == b[col] ? 0 : (a[col] > b[col] ? asc : -1 * asc));
			});
			
			for(var i = 0; i < arr_pos.length; i++){
				arr[i][col] = parseDateString(arr[i][col]);
			}
		}
		
		j = 0;
		for(i = 0; i < arr_pos.length; i++){
	        rows[arr_pos[i]].innerHTML = "<td>" + arr[j++].join("</td><td>") + "</td>";
	    }
	}
	
	else
	{ 
		for(i = 0; i < rlen; i++)
		{
			cells = rows[i].cells;
			clen = cells.length;
			arr[i] = new Array();
			for(j = 0; j < clen; j++)
				arr[i][j] = cells[j].innerHTML;	
		}
		
		var type = getColType(arr, col);
		
		if(type == 'number')
		{
			arr.sort(function (a, b) {
				return (a[col] - b[col]) > 0 ? asc : -1 * asc;
			});
		}
		else if(type == 'string')
		{
			arr.sort(function (a, b) {
				return (a[col] == b[col]) ? 0 : ((a[col] > b[col]) ? asc : -1 * asc);
			});
		}	
		else if(type == 'datetime'){
			
			//inverse the date string 
			for(var i = 0; i < rlen; i++){
				arr[i][col] = parseDateString(arr[i][col]);
			}
			
			arr.sort(function (a, b) {
				return (a[col] == b[col] ? 0 : (a[col] > b[col] ? asc : -1 * asc));
			});
			
			for(var i = 0; i < rlen; i++){
				arr[i][col] = parseDateString(arr[i][col]);
			}
		}
				
		j = 0;
		for(i = 0; i < rlen; i++){
	        rows[i].innerHTML = "<td>" + arr[j++].join("</td><td>") + "</td>";
	    }
	}
}

function parseDateString(input)
{
	input = input.split(' ');
	var parts = input[0].match(/(\d+)/g);
	return parts[2] + '-' + parts[1] + '-' + parts[0] + ' ' + input[1];
}

function parseDate(input) {
	var parts = input.match(/(\d+)/g);
	return new Date(parts[2], parts[1]-1, parts[0]);
}

function getColType(array, col){
	var type = 'string';
	var cell = array[0][col];
	var date = cell.split(' ');
	
	if(!isNaN(cell)) 
		type = 'number';
	
	//valid for either DD/MM/YYYY or DD-MM-YYYY
	if(date[0].match(/^(0?[1-9]|[12][0-9]|3[01])[\/\-](0?[1-9]|1[012])[\/\-]\d{4}$/))					
		type = 'datetime';
		
	return type;
}

function navigate(name, lim, page, pgs, filtered_rows){
	var i;
	name = name.slice(0, name.indexOf("-"));
	table = document.getElementById(name);
	tbody = table.tBodies[0];
	rows = tbody.rows;
	rlen = rows.length;
	
	//limit = lim;
	current_page = page;
	end = page * lim;
		
	if(arr_pos.length > 0)
	{ 	
		if(page == pgs)
			end = arr_pos.length;
		
		for(i = 0; i < rlen; i++)
			rows[i].style.display = "none";
		
		for(i = (page-1) * limit; i < end; i++)
		{
			rows[arr_pos[i]].style.display = "table-row";
		}
		
		document.getElementsByClassName(name + "-per_page")[0].innerHTML = ((current_page - 1)*limit + 1) + " la " + end + " din " + arr_pos.length;
		document.getElementsByClassName(name + "-per_page")[1].innerHTML = ((current_page - 1)*limit + 1) + " la " + end + " din " + arr_pos.length;
	}
		
	else
	{
		if(page == pgs)
			end = rlen;
		
		for(i = 0; i < rlen; i++)
			rows[i].style.display = "none";
		
		for(i = (page-1) * limit; i < end; i++)
		{
			rows[i].style.display = "table-row";
		}
				
		document.getElementsByClassName(name +"-per_page")[0].innerHTML = ((current_page - 1)*limit + 1) + " la " + end + " din " + rlen;
		document.getElementsByClassName(name + "-per_page")[1].innerHTML = ((current_page - 1)*limit + 1) + " la " + end + " din " + rlen;
	}
	
	for(i = 1; i <= pgs; i++)
	{
		document.getElementsByName(name + "-page" + i)[0].className = "page" + i;
		document.getElementsByName(name + "-page" + i)[1].className = "page" + i;
	}

	document.getElementsByName(name + "-page" +page)[0].className = "page" + page + "-current";
	document.getElementsByName(name + "-page" +page)[1].className = "page" + page + "-current";	
}


function toggleArchive(x){
	if(x.checked)
	{
		/*document.getElementById('ringS').style.display = "block";
		document.getElementById('datepickerwell').style.display = "block";
		document.getElementById('send').style.display = "block";*/
		document.getElementById('hiddenfields').style.display = "block";
		document.getElementById('hiddenfields').style.marginBottom= "12px";
		//document.getElementsByClassName('table')[0].style.top = "32px";
		//document.getElementById('bottom').style.top = "32px";
	}
	else
	{
		/*document.getElementById('ringS').style.display = "none";
		document.getElementById('datepickerwell').style.display = "none";
		document.getElementById('send').style.display = "none";*/
		document.getElementById('hiddenfields').style.display = "none";
		document.getElementById('hiddenfields').style.marginBottom= "0px";

		//document.getElementsByClassName('table')[0].style.top = "0px";
		//document.getElementById('bottom').style.top = "0px";
	}
}

function callback(){
	var r = document.getElementById('ringSelector');
	var s = r.options[r.selectedIndex].text;
	var d = document.getElementById('reservation').value;
	var url = document.getElementById('webservurl').innerHTML;
	
	var xmlHttp = null;
	
	if(window.XMLHttpRequest)
		xmlHttp = new XMLHttpRequest();

	else if(window.ActiveXObject)
		xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
	
	if(xmlHttp == null)
	{
		alert ("Your browser does not support Ajax");
		return false;
	}
	
	var data = '{' +
			   ' "SessionId": "4", ' +
			   ' "CurrentState": "login", ' +
			   ' "objects": ' +
			   '[' +
					'{' +
						' "Arguments": ' +
						'{' +
						' "ID_Market": 3, ' +
						' "ID_Ring": ' +
						' "date": ' +
						'}' +
					 '}' +
				']' +
				'}';
	
	xmlHttp.onreadystatechange = stateChanged;
	xmlHttp.open("POST", url, true);
	//xmlHttp.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
	xmlHttp.send(data);
	//alert("xmlHttp.readyState: " + xmlHttp.readyState);
	
	function stateChanged()
	{
		if(xmlHttp.readyState < 4)
			document.getElementById('loading').innerHTML = xmlHttp.readyState;
		
		else if (xmlHttp.readyState === 4 || xmlHttp.readyState == 'complete')
		{
			document.getElementById('loading').innerHTML = xmlHttp.status;
			if(xmlHttp.status == 200)
			{
				document.getElementById("loading").innerHTML = JSON.parse(xmlHttp.responseText);
				alert(JSON.parse(xmlHttp.responseText));
			}
			//alert(JSON.parse(xmlHttp.responseText));
		}
	}	
}

function buildURL(){
	var r = '';
	if(document.getElementById('ringSelector') != null)
	{
		var r_id = '';
		
		r = document.getElementById('ringSelector');
		
		if(r != null){
			if(r.selectedIndex == -1) r.selectedIndex = 0; //hack for Chrome and IE
			r_id = r[r.selectedIndex].value;
		}
		if(r_id == 0) r_id = -1;
		var d = document.getElementById('reservation').value;
		arr = d.split(" ");
		date_start = arr[0].trim();
		date_end = arr[2].trim();
			
		ring = '&id_ring=' + r_id;
	    date = '&date_start=' + date_start + '&date_end=' + date_end;
	    
	    send = '';
	    base_url = document.getElementById('base_url').href;
	    send = base_url += ring += date;
	    document.getElementById('send').href = send;
	}
}