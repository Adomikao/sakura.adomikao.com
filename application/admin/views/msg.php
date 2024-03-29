<?php 
if (!isset($title)) {
	$title="提示！";
}

include_once 'inc_header.php';

if (!!function_exists('site_url') and !function_exists('to_url')) {
	//正则表达式里面有一个横杠[\w-]+而服务器线上是PHP7.1，而本地是PHP7.3。使用PHPpreg_quote转义试一下，结果发现，是输出\-。再测试PHP7.1，果然也是，但奇怪的是，PHP7.1并没有报这个错误。
	function to_url($str){
		return (bool) (!preg_match('/^(http:\/\/)?(https:\/\/)?([\w\d\-]+\.)+[\w\-]+(\/[\d\w\-.\/?%&=]*)?$/' , $str)) ? site_url($str) : $str;
	}
}

if (!function_exists('to_url')) {
	function to_url($str){
		 return (bool) (!preg_match('/^(http:\/\/)?(https:\/\/)?([\w\d\-]+\.)+[\w\-]+(\/[\d\w\-.\/?%&=]*)?$/' , $str)) ? site_url($str) : $str;
	}
}

?>

<div style='width: 50%;margin: 0 auto;margin-top: 20%;height: 150px;'>
	<div class='alert <?php echo $status ? "alert-success":"alert-error" ?>'>
	<?php echo $msg; ?>
<br/> 
	<span id='showbox'>3</span> 秒后自动转向...
	</div>

	<?php 
	if (trim($this->input->get('back_url',true))){
		$back_url = $this->input->get('back_url',true);
	}else{
		$back_url = to_url($this->router->class.'/index/');
	}
	// 编辑和修改	
	if (isset($id)) {
	switch($this->router->method){
		case 'create':
	?>
	<div class='btn-group'>
		<a class='btn' href="<?php echo to_url($this->router->class.'/edit/'.$id);?>" target="_self"> 编辑该条信息 </a>
		<a class='btn btn-info' href="<?php echo $back_url;?>" target="_self"> 回到列表页 </a>
		<a class='btn' href="<?php echo to_url($this->router->class.'/create/');?>" target="_self"> 继续添加 </a>
	</div>
	<?php 
			break;
		case 'edit':
	?>
	<div class='btn-group'>
		<a class='btn' href="<?php echo to_url($this->router->class.'/edit/'.$id);?>" target="_self"> 继续编辑该条信息 </a>
		<a class='btn btn-info' href="<?php echo $back_url;?>" target="_self"> 回到列表页 </a>
	</div>
	<?php
			break;
		default:
	?>
		<a class='btn btn-info' href="<?php echo to_url($this->router->class.'/index/');?>" target="_self"> 返回 </a>
	<?php 
	} // end switch
	}else{
	?>
		<a class='btn btn-info' href="<?php echo $back_url;?>" target="_self"> 返回 </a>
	<?php } ?>


</div>

<script type="text/javascript" charset="utf-8">
var timeout = 3;
function show() {
	var showbox = $("#showbox");
	showbox.html(timeout);
	timeout--;
	if (timeout == 0) {
		window.opener = null;
		window.location.href = "<?php echo $back_url;?>";
	}
	else {
		setTimeout("show()", 1000);
	}
}
<?php if (defined('ENVIRONMENT') and ENVIRONMENT == "production" ): ?>
show();
<?php endif ?>
</script>
<?php include 'inc_footer.php'; ?>
