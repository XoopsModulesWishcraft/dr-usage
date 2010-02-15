<?

	require('../../mainfile.php');

	global $xoopsModuleConfig, $xoopsModule;
	
	if ($xoopsModuleConfig['htaccess']!=0)
	{
		if (strpos(' '.$_SERVER['REQUEST_URI'],"modules/")){
			header( "HTTP/1.1 301 Moved Permanently" ); 
			header( "Location: ".XOOPS_URL."/usage/");
		}	
	}
	error_reporting(0);
	
	if ( file_exists("language/".$xoopsConfig['language']."/modinfo.php") ) {
		include("language/".$xoopsConfig['language']."/modinfo.php");
	} else {
		include("language/english/modinfo.php");
	}
	require('class/usage.php');	
	$usage = new Usage();
	include(XOOPS_ROOT_PATH.'/header.php');
	
	switch($_REQUEST['pid']){
	
	
	default:
		$xoopsOption['template_main'] = 'usage_index.html';	
		
		$xoopsTpl->assign( 'integrity',$usage->System_Integrity());
		$xoopsTpl->assign( 'complete_integrity',$usage->Complete_Integrity());
		$xoopsTpl->assign( 'quarantine_integrity',$usage->Quarantine_System_Integrity(true, 'usage_quarantine'));
		$xoopsTpl->assign( 'quarantine_integrity_a',$usage->Quarantine_System_Integrity(true, 'usage_quarantine_stage_a'));
		$xoopsTpl->assign( 'quarantine_integrity_b',$usage->Quarantine_System_Integrity(true, 'usage_quarantine_stage_b'));
		$xoopsTpl->assign( 'quarantine_integrity_c',$usage->Quarantine_System_Integrity(true, 'usage_quarantine_stage_c'));
		$xoopsTpl->assign( 'quarantine_integrity_d',$usage->Quarantine_System_Integrity(true, 'usage_quarantine_stage_d'));
		$xoopsTpl->assign( 'quarantine_integrity_e',$usage->Quarantine_System_Integrity(true, 'usage_quarantine_stage_e'));
		$xoopsTpl->assign( 'complete_quarantine_integrity',$usage->Complete_Quarantine_Integrity());
		
		$xoopsTpl->assign( 'graph',$xoopsModuleConfig['graph']);
		$xoopsTpl->assign( 'xsize',$xoopsModuleConfig['xsize']);
		$xoopsTpl->assign( 'ysize',$xoopsModuleConfig['ysize']);
		$xoopsTpl->assign( 'xsize_b',$xoopsModuleConfig['xsize_b']);
		$xoopsTpl->assign( 'ysize_b',$xoopsModuleConfig['ysize_b']);		
		$xoopsTpl->assign( 'moddir',XOOPS_URL.'/modules/'.$xoopsModule->dirname());

	}

include(XOOPS_ROOT_PATH.'/footer.php');

?>