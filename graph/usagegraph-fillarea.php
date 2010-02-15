<?php
include ("../../../mainfile.php");
include (XOOPS_ROOT_PATH."/Frameworks/graphs/graphfactory.php");

global $xoopsDB, $xoopsModule;
$module_handler =& xoops_gethandler('module');
$xoopsModule =& $module_handler->getByDirname('usage');
$xoopsModuleConfig =& $config_handler->getConfigsByCat(0, $xoopsModule->getVar('mid'));

$sql = "select distinct `ip`, `hour` from ".$xoopsDB->prefix("usage")." where date > ".(time()-($xoopsModuleConfig['ticks_shown']*3600))." order by `hour`";
$ret = $xoopsDB->queryF($sql);
//echo $sql;
$data_b = array();
$i=-1;
$stl_data = array();
while (list($ip, $hour) = $xoopsDB->fetchRow($ret))
{
	if ($thishour != $hour)
	{
		$i++;
		$stl_data[] = $hour;
	}
	$thishour = $hour;
	$data_b[$i]++;
}
if (sizeof($data_b)==1){
	$data_b[$i+1]=0;
}
//print_r($data);
//exit;
$data['Y0']['data'] = $data_b;
$data['Y0']['type'] = _X_GRAPH_TYPE_G;
$data['Y0']['options'] = array("SetLegend" =>"Hourly Usage", "SetFillColor" => "green");

$sql = "select count(*) as NUM from ".$xoopsDB->prefix("usage")." where date > ".(time()-($xoopsModuleConfig['ticks_shown']*3600))." group by `hour`";
$ret = $xoopsDB->queryF($sql);
$data_b=array();
while (list($num) = $xoopsDB->fetchRow($ret))
{
	$data_b[] = $num;
}
if (sizeof($data_b)==1){
	$data_b[]=0;
}
$data['Y1']['data'] = $data_b;
$data['Y1']['type'] = _X_GRAPH_TYPE_G;
$data['Y1']['options'] = array("SetLegend" =>"Hourly Clicks", "SetFillColor" => "red");
$data['Y1']['addtype'] = "Add";

$legend =array("Pos" => array(0.12,0.78,"right","center"));
$xaxis = array('title' => array("Set" =>"Visits"));
$yaxis = array('SetWeight'=>2,'SetColor' => "blue", 'title' => array("Set" =>"Recent Hours"));
$y2axis = array('SetColor' => "orange");
$ygrid = array("Show" => array(true,true));
$xgrid = array("Show" => array(true,false));
// Create the graph. These two calls are always required
$options= array("SetScale" => "textlin");
$margin = array(25,25,25,25);
$data['AccLinePlot'] = array("Y0","Y1");

$xsize = isset($_GET['xsize']) ? $_GET['xsize'] : $xoopsModuleConfig['xsize'];
$ysize = isset($_GET['ysize']) ? $_GET['ysize'] : $xoopsModuleConfig['ysize'];

// Display the graph
GraphFactory::GetGraph($data, $xsize, $ysize, $title, $margin, $options, array('x' => $xaxis, 'y' => $yaxis, 'y2' => $y2axis), $scale, array('x' => $xgrid, 'y' => $ygrid), $legend, $wildcardsettings);
?>