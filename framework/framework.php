<?php
//$iscacheconfig ��������˾��ǻ��棬������Ͳ�ʹ�û���
$config["frameworkpath"]=dirname(__FILE__)."/";
if(isset($iscacheconfig)&&$projectenv=='product'&&file_exists($config["frameworkpath"]."cache/".$config["webprojectname"]."config.cache.php"))
{
  $config=array_merge(include($config["frameworkpath"]."cache/".$config["webprojectname"]."config.cache.php"),$config);
  $isreadconfig=true;
}
if(!isset($isreadconfig)){
	include($config["frameworkpath"]."config/inc.ini.php");
	if(file_exists($config["webprojectpath"]."config/precore.ini.php"))
	{
	  require_once $config["webprojectpath"]."config/precore.ini.php";
	}
}
if($projectenv=='product'&&file_exists($config["frameworkpath"]."cache/core.cache.php"))
{
  require_once $config["frameworkpath"]."cache/core.cache.php";
}else{
 if($projectenv=='product')
 {
	//$corecontent=substr(php_strip_whitespace($config["frameworkpath"]."core/base.class.php"),0,-2);
	$corecontent=substr(php_strip_whitespace($config["frameworkpath"]."core/model.php"),0,-2);
	$corecontent.=substr(php_strip_whitespace($config["frameworkpath"]."core/function.php"),5,-2);
	$corecontent.=substr(php_strip_whitespace($config["frameworkpath"]."core/router.php"),5,-2);
	$corecontent.=substr(php_strip_whitespace($config["frameworkpath"]."core/view.php"),5,-2);
	$corecontent.=substr(php_strip_whitespace($config["frameworkpath"]."core/controller.php"),5);
	file_put_contents($config["frameworkpath"]."cache/core.cache.php",$corecontent);
	unset($corecontent);
	require_once $config["frameworkpath"]."cache/core.cache.php";
 }else{
	//include($config["frameworkpath"]."core/base.class.php");
	include($config["frameworkpath"]."core/model.php");
	include($config["frameworkpath"]."core/function.php");
	include($config["frameworkpath"]."core/router.php");
	include($config["frameworkpath"]."core/view.php");
	include($config["frameworkpath"]."core/controller.php");
 }
}
if(!isset($isreadconfig)&&file_exists($config["webprojectpath"]."config/aftercore.ini.php"))
{
  require_once $config["webprojectpath"]."config/aftercore.ini.php";
}
    if(isset($iscacheconfig))
	if($projectenv=='product')
	{
	  if(!file_exists($config["frameworkpath"]."cache/".$config["webprojectname"]."config.cache.php"))
	   file_put_contents($config["frameworkpath"]."cache/".$config["webprojectname"]."config.cache.php","<?php return ".var_export($config,TRUE)."; ?>");
	}else{
	   if(file_exists($config["frameworkpath"]."cache/".$config["webprojectname"]."config.cache.php"))
	   unlink($config["frameworkpath"]."cache/".$config["webprojectname"]."config.cache.php");
	}
//���ֻ��ʹ�����ݿ�������ôע���������Ϳ�����
$dispaths=C("router")->setMaps($config["routermaps"])->start();
$view=C("view");
$router=R($dispaths->controller);
if (method_exists($router,$dispaths->action)) {
     call_user_func(array($router,$dispaths->action));
	 $view->display(R($dispaths->controller)->view($dispaths->action));
}
?>