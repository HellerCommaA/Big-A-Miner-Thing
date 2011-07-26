<?php
$pool = "/etc/bamt/pools";

//display the line
if(isset($_GET['id'])){
	$data = file($pool);	
	$boom = explode("-",$_GET['id']);
	$line = $boom[1];
	echo trim($data[$line]);
	

}

//save the line
if(isset($_POST['value'])){
	$data = file($pool);
	$boom = explode("-",$_POST['id']);
        $line = $boom[1];	
	$newVal = $_POST['value'];
	$data[$line] = $newVal."\n";
	if(file_put_contents($pool,$data)){
		echo $newVal;
	}
	else{
		echo "Failed to modify pool file";
	}

}
?>
