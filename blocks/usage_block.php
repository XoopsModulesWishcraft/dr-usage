<?


	function usage_block_display($options)
	{
		$config_handler =& xoops_gethandler('config');
		$module_handler =& xoops_gethandler('module');
		$xoopsModule =& $module_handler->getByDirname('usage');
		$xoopsModuleConfig =& $config_handler->getConfigsByCat(0, $xoopsModule->getVar('mid'));
		require(XOOPS_ROOT_PATH.'/modules/usage/class/usage.php');	
		$usage = new Usage($options[2]);
		$block['graph'][] = array("graph" => XOOPS_URL."/modules/usage/graph/".$xoopsModuleConfig['graph']."?xsize=".$options[0]."&ysize=".$options[1]."", "integrity" => $usage->Complete_Integrity());
		return $block;
	}
	
	function usage_block_edit($options)
	{
		$form = "Width:&nbsp;";
		$form .= "<input type='text' name='options[]' value='" . $options[0] . "' />&nbsp;Width of Graph<br/>";
		$form .= "Height:&nbsp;";	
		$form .= "<input type='text' name='options[]' value='" . $options[1] . "' />&nbsp;Height of Graph<br/>";
		if ($options[2]==1){
			$form .= "Log:&nbsp;";	
			$form .= "<input checked='checked' type='checkbox' name='options[]' value='1' />&nbsp;Log with the block";
		} else {
			$form .= "Log:&nbsp;";	
			$form .= "<input type='checkbox' name='options[]' value='1' />&nbsp;Log with the block";
		}
		return $form;
	}
?>
