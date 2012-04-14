<?php
include ("../../../mainfile.php");
include (XOOPS_ROOT_PATH."/Frameworks/graphs/graphfactory.php");

global $xoopsModuleConfig, $xoopsDB;
if (!isset($_GET['quarantine']))
{
	$sql = "select `country`, count(*) as NUM from ".$xoopsDB->prefix("usage")." where 3=3 group by `country` order by NUM limit 13";
} else {
	$sql = "select `country`, count(*) as NUM from ".$xoopsDB->prefix("usage_quarantine")." where 3=3 group by `country` order by NUM limit 13";
}
$ret = $xoopsDB->queryF($sql);
//echo $sql;
$data_b = array();
$legend_b = array();
while (list($country, $num) = $xoopsDB->fetchRow($ret))
{
	$data_b[] = $num;
	$legend_b[] = $country;
}
$data['Y0']['data'] = $data_b;
$data['Y0']['type'] = _X_GRAPH_TYPE_F;
$data['Y0']['options'] = array("SetLegends" => $legend_b);

$options= array("SetShadow" => 0, "SetScale" => "lin");
$margin = array(35,35,35,35);
$title = array("Set" =>"Top 13 Country Usage", "SetColor" =>"green");
$legend =array("Pos" => array(0.07,0.47,"left","center"));

$xsize = isset($_GET['xsize']) ? $_GET['xsize'] : $xoopsModuleConfig['xsize'];
$ysize = isset($_GET['ysize']) ? $_GET['ysize'] : $xoopsModuleConfig['ysize'];

// Display the graph
GraphFactory::GetGraph($data, $xsize, $ysize, $title, $margin, $options, $somewhere, $scale, $else, $legend, $wildcardsettings);
?>