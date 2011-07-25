<?php
if(isset($_GET['mining'])){

	switch($_GET['mining']){
	
		case 'stop':
				$output = shell_exec("sudo /usr/sbin/stop_mining");
				//echo "<pre>$output</pre>";
				break;
		case 'start':
				$output = shell_exec("sudo /usr/sbin/start_mining");
                                break;



	}


}


?>
