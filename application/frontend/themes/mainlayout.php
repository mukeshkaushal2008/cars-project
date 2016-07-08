<!DOCTYPE html>
<!--[if lt IE 7]><html class="no-js lt-ie9 lt-ie8 lt-ie7"><![endif]-->
<!--[if IE 7]><html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]><html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html lang="en" class="no-js">
<!--<![endif]-->
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge"><![endif]-->
<title><?php echo $master_title; ?>
<?php
	$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
	$this->output->set_header("Pragma: no-cache");
?>
</title>
<?php include("main_head.php"); ?>
<script>
$(window).bind("pageshow", function(event) {
    if (event.originalEvent.persisted) {
        window.location.reload() 
    }
});
</script>
</head>

<?php
$controllername = $this->router->class;
$method = $this->router->method; 

foreach ($this->_ci_view_paths as $key => $val) {
	$view_path = $key;
}
?>
<body class="index">
<?php include("main_header.php"); ?>

<?php if (isset($master_body) && $master_body != "") { ?>
<?php include($view_path . $controllername . "/" . $master_body . ".php"); ?>
<?php } ?>
<?php include('main_footer.php');?>

</body>
</html>
<?php
if ($this->config->item("process") == "yes") {
    $this->output->enable_profiler(TRUE);
}
?>
