<?php
//if script in module directory
//chdir('../../../../../');
DEFINE('SYNCH_START', 1);
DEFINE('SYNCH_TOTAL', 1000);
DEFINE('SYNCH_STEP', 20);
DEFINE('SYNCH_LOG_FILE', 'script_for_synch_orders.log');

if(!empty($_POST)) {
	$messages = '';
	$synch_start	= !empty($_POST['start']) ? $_POST['start'] : SYNCH_START;
	$synch_stop	= !empty($_POST['stop']) ? $_POST['stop'] : SYNCH_TOTAL;
	$synch_log_file	= !empty($_POST['log_file']) ? $_POST['log_file'] : SYNCH_LOG_FILE;

//var_dump($synch_start, $synch_stop, $synch_log_file); die;
	
	$max_execution_time = 3600;
	ini_set('max_execution_time', $max_execution_time);
	set_time_limit($max_execution_time);
	ignore_user_abort(true);
	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	try {
		require_once 'app/Mage.php';
		if (!Mage::isInstalled()) {
			throw new Exception("Application is not installed yet, please complete install wizard first.");
		}

		$_SERVER['SCRIPT_NAME'] = str_replace(basename(__FILE__), 'index.php', $_SERVER['SCRIPT_NAME']);
		$_SERVER['SCRIPT_FILENAME'] = str_replace(basename(__FILE__), 'index.php', $_SERVER['SCRIPT_FILENAME']);

		Mage::app('admin')->setUseSessionInUrl(false);

		$module = Mage::getModel('sugarcrm/connection');
		if(!$module instanceof Belitsoft_Sugarcrm_Model_Connection) {
			throw new Exception("Bridge is not installed yet.");
		}

		file_put_contents($synch_log_file, "Started - ".date('Y-m-d H:i:s')."\n"."First ID: {$synch_start}; Last ID: {$synch_stop}\n\n", FILE_APPEND | LOCK_EX);
		$echo = $module->synchAllOrders($synch_start, $synch_stop);
		$to_file = '';
		if(!empty($echo)) {
			foreach($echo as $oper=>$ids) {
				$to_file .= "$oper \n";
				$to_file .= 'IDs: '.implode(', ', $ids)."\n";
				$to_file .= 'Total: '.count($ids)."\n";
			}
		} else {
			$to_file .= "There are no orders for synch.\n";
		}

		file_put_contents($synch_log_file, $to_file, FILE_APPEND | LOCK_EX);
		
		$messages .= "First ID: {$synch_start}; Last ID: {$synch_stop}<br />";
		$messages .= nl2br($to_file);

		file_put_contents($synch_log_file, "Finished - ".date('Y-m-d H:i:s')."\n\n\n", FILE_APPEND | LOCK_EX);
		
	} catch (Exception $e) {
		file_put_contents($synch_log_file, print_r($e, true), FILE_APPEND | LOCK_EX);
		$messages .= "<p class=\"error\">".$e->getMessage()."</p>";
		//Mage::printException($e);
	}
	
	echo $messages;
	
	exit();
}
?><html>
	<head>
	<script>
	var handlerPath = '<?php echo basename(__FILE__); ?>';
	var started;	
	var startId = 0;
	var stopId = 0;
	var maxId = 0;
	var syncStep = 0;
	var logFile = '';	
	var syncDots = 1;	
	var stepNum = 0;	
	var processInterval;
	var startTime = 0;
	var elapsedTime = 0;
	
	
	function process() {
		if(!started) {
			document.getElementById('processVisialization').innerHTML = 'Synchronization (100%)';
			syncDots = 0;
			clearInterval(processInterval);
			return true;
		}
		
		syncDots++;
		document.getElementById('processVisialization').innerHTML = 'Synchronization (approximate time left: ' + approximateTimeLeft() + ') [' + procent() + '%] ' + Array(syncDots+1).join('.');
		if(syncDots >= 10) {
			syncDots = 0;
		}
	}
	
	function procent() {
		return Math.round((100 / getStepsNumber()) * stepNum);
	}
	
	function approximateTimeLeft() {
		if(!elapsedTime || stepNum < 1) {
			return '---' 
		}
		
		var stepTime = elapsedTime / stepNum;
		var remainingSteps = getStepsNumber() - stepNum;
		
		var remainingTime = stepTime * remainingSteps;
		
		var secRemainingTime = Math.round(remainingTime/1000);
		
		var returnTime;
		if(secRemainingTime < 60) {
			returnTime = secRemainingTime + 's';
		} else if(secRemainingTime < (60*60)) {
			returnTime = Math.round(secRemainingTime / 60) + 'm';
		} else if(secRemainingTime < (60*60*24)) {
			var hours = Math.floor(secRemainingTime/(60*60));
			var minutes = Math.round((secRemainingTime - hours*60*60) / 60);
			
			returnTime = hours + 'h ' + minutes + 'm';
		} else {
			var days = Math.floor(secRemainingTime/(60*60*24));
			var hours = Math.floor((secRemainingTime - days*60*60*24) / (60*60));
			var minutes = Math.round((secRemainingTime - days*60*60*24 - hours*60*60) / 60);
			
			returnTime = days + 'd ' + hours + 'h ' + minutes + 'm';			
		}
		
		return returnTime;
	}
	
	function getStepsNumber() {
		return Math.ceil((maxId+1-startId)/syncStep);
	}
	
	function getAjaxRequest() {
		var xmlHttp;
		
		try {
			xmlHttp = new XMLHttpRequest();
		} catch(e) {
			var XMLHttpVersions = new Array("MSXML2.XMLHTTP.6.0",
										  "MSXML2.XMLHTTP.5.0",
										  "MSXML2.XMLHTTP.4.0",
										  "MSXML2.XMLHTTP.3.0",
										  "MSXML2.XMLHTTP",
										  "Microsoft.XMLHTTP");
			for (var i=0; i< XmlHttpVersions.length && !xmlHttp; i++) {
				try	{
					xmlHttp = new ActiveXObject(XmlHttpVersions[i]);
				} catch(e) {}
			}
		}
		
		return xmlHttp;
	}

	function sendAjaxRequest(start, stop) {
		if(!started) {
			return true;
		}
		
		var request = getAjaxRequest();
		
		if (request) {
			var parameters = 'start=' + start + '&stop=' + stop + '&log_file=' + logFile;			
			
			request.open("POST", handlerPath, true);
			
			request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			/*request.setRequestHeader("Content-length", parameters.length);
			request.setRequestHeader("Connection", "close");*/
			
			request.onreadystatechange = function() { step(request, start, stop); };			
			
			request.send(parameters);
			
		} else {
			document.getElementById('messagesArea').innerHTML = "Ajax is not supported by your browser" + '<hr />' + document.getElementById('messagesArea').innerHTML;
		}
	}
	
	function step(request, start, stop) {
		if((request.readyState == 4 || request.readyState == 'complete')) {
			if(request.status == 200) {
				response = request.responseText;
					
				document.getElementById('messagesArea').innerHTML = response + '<hr />' + document.getElementById('messagesArea').innerHTML;
				
				start = stop + 1;
				stop += syncStep; 
				
				if(start > maxId) {
					startStopSynch();
				}
				
				sendAjaxRequest(start, stop);
			}
			
			stepNum++;
			
			elapsedTime = new Date().getTime() - startTime;
		}
	}

	function startStopSynch() {		
		if(document.getElementById('synch_button').value == 'Start') {
			startId = parseInt(document.getElementById('synch_start').value);
			syncStep = parseInt(document.getElementById('synch_step').value);
			maxId = parseInt(document.getElementById('synch_total').value);
			logFile = document.getElementById('synch_log_file').value;
			stopId = maxId;
			
			if(!startId || !maxId || startId < 0 || maxId == 0 || startId > maxId) {
				alert('Check "Min order ID" and "Max order ID" fields');
				return;
			}
			
			if(!syncStep || syncStep == 0) {
				alert('Enter the right "Step" value');
				return;
			}
			
			document.getElementById('synch_button').value = 'Cancel';
			document.getElementById('messagesArea').innerHTML = '';
			document.getElementById('synchProcessArea').style.display = 'block';
			
			started = true;
		} else {
			document.getElementById('synch_button').value = 'Start';
			stepNum = 0;
			started = false;
		}
		
		document.getElementById('synch_start').readOnly = !document.getElementById('synch_start').readOnly;
		document.getElementById('synch_total').readOnly = !document.getElementById('synch_total').readOnly;
		document.getElementById('synch_step').readOnly = !document.getElementById('synch_step').readOnly;
		document.getElementById('synch_log_file').readOnly = !document.getElementById('synch_log_file').readOnly;
		
		
		if(started) {			
			processInterval = setInterval(process, 800);
			process();
				
			startTime = new Date().getTime();
			
			sendAjaxRequest(startId, startId+syncStep);
		}
		
		return true;
	}
	</script>
	</head>
	<body>
		<style>
		td.label{background: none repeat scroll 0 0 #AAAAAA; color: white;}
		.messages{color:green;}
		.error{color:red;}
		</style>
		
		<form action="<?php echo basename(__FILE__); ?>" method="POST" name="synch_form">
			<table width="100%" border="0">
			<tr>
				<td align="right" width="150" class="label"><label for="synch_start">Min order ID:</label></td>
				<td align="left"><input type="text" name="synch_start" id="synch_start" value="<?php echo (!empty($_POST['synch_start']) ? $_POST['synch_start'] : SYNCH_START); ?>" style="width:100px" /></td>
			</tr>
			<tr>
				<td align="right" class="label"><label for="synch_total">Max order ID:</label></td>
				<td align="left"><input type="text" name="synch_total" id="synch_total" value="<?php echo (!empty($_POST['synch_total']) ? $_POST['synch_total'] : SYNCH_TOTAL); ?>" style="width:100px" /></td>
			</tr>
			<tr>
				<td align="right" class="label"><label for="synch_step">Step:</label></td>
				<td align="left"><input type="text" name="synch_step" id="synch_step" value="<?php echo (!empty($_POST['synch_step']) ? $_POST['synch_step'] : SYNCH_STEP); ?>" style="width:100px" /></td>
			</tr>
			<tr>
				<td align="right" class="label"><label for="synch_log_file">Log file name:</label></td>
				<td align="left"><input type="text" name="synch_log_file" id="synch_log_file" value="<?php echo (!empty($_POST['synch_log_file']) ? $_POST['synch_log_file'] : SYNCH_LOG_FILE); ?>" style="width:500px" /></td>
			</tr>
			<tr>
				<td align="right"></td>
				<td align="left"><input type="button" name="synch_button" id="synch_button" value="Start" onclick="startStopSynch()" /></td>
			</tr>
			</table>
		</form>
		
		
		<div id="synchProcessArea" style="display:none;">
		<div id="processVisialization">Synchronization (approximate time left: ---) [0%] .</div>
		<label for="messagesArea" style="vertical-align: top;">Sync process:</label>
		<div style="width: 50%; height:500px; border: 1px solid #aaa; overflow: auto;" id="messagesArea" readonly="true"></div>
		</div>
	
	</body>
</html>