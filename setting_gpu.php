<?php

$config = '/etc/bamt/bamt.conf';

/* TODO: CONVERT THIS INTO A SWITCH STATEMENT*/

//add a new GPU from the settings page
if (isset($_POST['add'])){

	$arr = yaml_parse_file($config);
	//generate a default array to create the new GPU
	$gpuNum = $_POST['gpuNum'];
	/* TODO: revise this, just a quick dirty default solution */ 
	$arr["gpu".$gpuNum]['disabled'] = 1;
	$arr["gpu".$gpuNum]['core_speed'] = 900;
	$arr["gpu".$gpuNum]['mem_speed'] = 300;
	$arr["gpu".$gpuNum]['fan_speed'] = 100;
	$arr["gpu".$gpuNum]['kernel'] = 'phatk';
	$arr["gpu".$gpuNum]['kernel_params'] = "BFI_INT VECTORS FASTLOOP=false AGGRESSION=11";
	$arr["gpu".$gpuNum]['pool_file'] = '/etc/bamt/pools';	
	$arr["gpu".$gpuNum]['pool_timeout'] = 120;
	$arr["gpu".$gpuNum]['monitor_temp_lo'] = 45;
	$arr["gpu".$gpuNum]['monitor_temp_hi'] = 80;
	$arr["gpu".$gpuNum]['monitor_load_lo'] = 80;
	$arr["gpu".$gpuNum]['monitor_hash_lo'] = 125;
	$arr["gpu".$gpuNum]['monitor_shares_lo'] = 1;
	
	//save the default 
	/*	
	print "<pre>";
	print_r($arr);
	print "</pre>";
	*/

	if(file_put_contents($config,yaml_emit($arr))){
        	//echo "GPU successfully added, reload page to modify!";
                //echo "$setting=".$_POST['value'];

        }
        else{
                //echo "Failed to modify setting!";
        }

}

//delete the GPU
//TODO: revise this to jquery so there ill be no need for a header
if(isset($_POST['gpudel'])){
	$gpuNum = $_POST['gpudel'];
	$arr = yaml_parse_file($config);
	unset($arr['gpu'.$gpuNum]);

	if(file_put_contents($config,yaml_emit($arr))){
		header("Location: settings.php");
        }
        else{
                echo "Failed to modify setting!";
        }
}
//display information on the settings page
if(isset($_GET['id'])){
	$boom = explode("-",$_GET['id']);
	$setting = $boom[0];
	$gpu = $boom[1];
	$yaml2 = yaml_parse_file($config);
	//file_put_contents("/etc/bamt/bamt.conf",$yaml);
	//$yam = yaml_emit($yaml2['gpu'.$gpu]);
	foreach($yaml2["gpu$gpu"] as $k => $v){
		if($k == $setting){
			echo $v;
		}
	}
	//remove pesky yaml characters
	//$yam = str_replace("---\n","",$yam);
	//$yam = str_replace("...\n","",$yam);
	//echo $yam;
}


//do a save into the bamt conf and display the changed setting so no refresh is required
if(isset($_POST['value'])){
	$data = yaml_parse_file($config);
	$boom = explode("-",$_POST['id']);
        $setting = $boom[0];
        $gpu = $boom[1];
	/*
	echo "<pre>";
	print_r($data);
	echo "</pre>";
	*/
	$data["gpu".$gpu][$setting] = $_POST['value'];

	$doneData = yaml_emit($data);
	//remove the YAML 1.1 crap
	$doneData = str_replace("---","",$doneData);
        $doneData = str_replace("...","",$doneData);
	if(file_put_contents($config,$doneData)){
	//	echo "File successfully modified!";
		echo "$setting=".$_POST['value'];

	}
	else{
		echo "Failed to modify setting!";
	}

}

?>
