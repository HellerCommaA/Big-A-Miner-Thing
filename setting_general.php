<?php

$config = '/etc/bamt/bamt.conf';

if(isset($_GET['id'])){
	$data = yaml_parse_file($config);
        $setting = $_GET['id'];

        //file_put_contents("/etc/bamt/bamt.conf",$yaml);
        //$yam = yaml_emit($yaml2['gpu'.$gpu]);
        foreach($data["settings"] as $k => $v){
                if($k == $setting){
                        echo $v;
                }
        }
        //remove pesky yaml characters
        //$yam = str_replace("---\n","",$yam);
        //$yam = str_replace("...\n","",$yam);
        //echo $yam;
}

//do a save
if(isset($_POST['value'])){
        $data = yaml_parse_file($config);
        $setting = $_POST['id'];
        $value = $_POST['value'];
        /*
        echo "<pre>";
        print_r($data);
        echo "</pre>";
        */
        $data["settings"][$setting] = $value;
        //$test = yaml_parse($_POST['value']);
        //$data[$gpuID] = array_replace($data[$gpuID],$test);
        //emit to file
        //$wee = yaml_emit($test);
        //now write the file
	
	$data = yaml_emit($data);
	//remove the first four characters, due to some YAML perl issues
	$data = str_replace("---","",$data);
	$data = str_replace("...","",$data);
        if(file_put_contents($config,$data)){
        //      echo "File successfully modified!";
                echo "$setting=".$value;

        }
        else{
                echo "Failed to modify setting!";
        }

}

?>
