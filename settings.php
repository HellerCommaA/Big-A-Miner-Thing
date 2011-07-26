<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>BAMT Settings</title>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />

	<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
	<script type="text/javascript" src="inc/ui.core.min.js"></script>
	<script type="text/javascript" src="inc/ui.sortable.min.js"></script>
	<script type="text/javascript" src="inc/jquery.metadata.js"></script>
	<script type="text/javascript" src="inc/mbTabset.js"></script>
	<script type="text/javascript" src="inc/jquery.jeditable.js"></script>
	<link rel="stylesheet" type="text/css" href="css/mbTabset.css" title="style"  media="screen"/>
	<link rel="stylesheet" type="text/css" href="bamt/status.css" title="style"  media="screen"/>
	<script type="text/javascript">
		$(document).ready(function() {
			$('.edit_area_gpu').editable('setting_gpu.php', { 
				 loadurl   : 'setting_gpu.php',
				 cancel    : 'Cancel',
				 submit    : 'Save',
				 submitdata: '' ,
				 indicator : '<img src="img/indicator.gif">',
				 style   : 'display: inline'
				});
      			$('.edit_area_stg').editable('setting_general.php', {
                                 loadurl   : 'setting_general.php',
                                 type      : 'textarea',
                                 cancel    : 'Cancel',
                                 submit    : 'Save',
                                 submitdata: '' ,
                                 indicator : '<img src="img/indicator.gif">',
                                 style   : 'display: inline'
                                });
			 $('.edit_area_pool').editable('setting_pool.php', {
                                 loadurl   : 'setting_pool.php',
                                 type      : 'textarea',
                                 cancel    : 'Cancel',
                                 submit    : 'Save',
                                 submitdata: '' ,
                                 indicator : '<img src="img/indicator.gif">',
                                 style   : 'display: inline'
                                });
		 });
		
		$(function(){
			$("#tabset1").buildMbTabset({
				stop:function(){if ($("#array").is(":checked")) alert($.mbTabset.mbTabsetArray)},
				sortable:true
			});
			//$("#b").selectMbTab();
		});

	</script>
</head>
<?php

$config = '/etc/bamt/bamt.conf';
$gpucount = 0 ;
$yaml2 = yaml_parse_file($config);
$yam = yaml_emit($yaml2);
$gpuArr = array();
foreach($yaml2 as $k => $v){
	if(preg_match('/^gpu(\d\d?)/',$k,$matches)){
		$gpuArr[] = $matches[1];
		$gpucount++;
	}

}
?>

<body>
<div style="background:#555 ; padding:10px"><span style="color: #ffffff; font-size: 30px; font-family: Courier New, Courier, mono; "> <h1>BAMT Settings</h1></span></div>
<p style="background:white;cursor:pointer" onclick="$('#tabset1').addMbTab({title:'GPU<?php echo $gpuArr[$gpucount-1] + 1; ?>', ajaxContent:'setting_gpu.php',ajaxData:'add=1&gpuNum=<?php echo $gpuArr[$gpucount-1] + 1; ?>'})">Add a GPU</p>
<br/><br/>
<div class="wrapper">
	<div class="tabset" id="tabset1">
	<a id="a" class="tab sel {content:'bamt_settings'}">General Settings</a>	
<?php for($i=0;$i<count($gpuArr);$i++): ?>
	<a id="b" class="tab {content:'<?php echo $gpuArr[$i] ?>' }">GPU<?php echo $gpuArr[$i]; ?></a>
<?php endfor; ?>

 <a id="c" class="tab {content:'control' }">Control</a>
 <a id="d" class="tab {content:'pool' }">Pool</a>
<?php

$count = 0;
foreach($yaml2 as $k => $v){
        if(preg_match('/^gpu/',$k)){
		echo "<div id='$gpuArr[$count]'>";
		echo "<h3>Click on a setting to modify it's value.</h3> ";
		foreach($v as $label => $setting){
                	echo "<div id='$label"."-"."$gpuArr[$count]' class='edit_area_gpu'>";
			echo $label."=".$setting;
			echo "</div>";
		}
		//add a form to delete the GPU
		echo "<form name='modifygpu$gpuArr[$count]' action='setting_gpu.php' method='POST'>";
		echo "<input type='hidden' name='gpudel' value='$gpuArr[$count]'>";
		echo "<BR/>";
		echo "<input type='submit' value='Delete GPU'>";
		echo "</form>";
		echo "</div>";
		
		$count++;
        }//now display settings
	else if(preg_match('/^settings/',$k)){
		echo "<div id='bamt_settings'>";
		foreach($v as $label => $setting){
                        echo "<div id='$label' class='edit_area_stg'>";
                        echo $label."=".$setting;
                        echo "</div>";
                }
		echo "</div>";
	}

}

?>

<div id="control">
<a href="setting_control.php?mining=stop">Stop Mining</a>
|
<a href="setting_control.php?mining=start">Start Mining</a>
</div>

<div id="pool">
<?php 
$pool = "/etc/bamt/pools";
$data = file($pool);

foreach($data as $k => $v){
	echo "<div id='pool-$k' class='edit_area_pool'>";
        echo $v;
        echo "</div>";
}

?>
</div>

</div>
</body>
</html>
