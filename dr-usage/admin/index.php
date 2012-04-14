<? 
include ("../../../mainfile.php");
$module_handler =& xoops_gethandler('module');
$xoopsModule =& $module_handler->getByDirname('usage');
header('Location: '.$_REQUEST['REQUEST_URI'].'/modules/system/admin.php?fct=preferences&op=showmod&mod='.$xoopsModule->getVar('mid')); ?>