<?
error_reporting(E_ALL);
if (!defined('XOOPS_ROOT_PATH')) {
	exit();
}
if (!class_exists("Usage")){

	class Usage extends XoopsObject
	{
	
		var $codes;
		
		function Usage($log = true) 
		{
			
			if ($log == true)
			{
				global $xoopsDB, $xoopsUser;

				$config_handler =& xoops_gethandler('config');
				$module_handler =& xoops_gethandler('module');
				$xoopsModule =& $module_handler->getByDirname('usage');
				$xoopsModuleConfig =& $config_handler->getConfigsByCat(0, $xoopsModule->getVar('mid'));

				if (!isset($xoopsModuleConfig['weeks_kept']))
					$xoopsModuleConfig['weeks_kept'] = 6;

				if (!isset($xoopsModuleConfig['percentile_threshhold']))
					$xoopsModuleConfig['percentile_threshhold'] = 94;
					
				if (!isset($xoopsModuleConfig['quarantine_kept']))
					$xoopsModuleConfig['quarantine_kept'] = 12;
													
					
				$sql = "INSERT INTO ".$xoopsDB->prefix('usage')." (`hostname`, `ip`, `suffix`, `country`, `date`, `hour`, `minute`, `second`, `month`, `day`, `seed`, `requesturl`, `uid`, `sessionid`) VALUES (";
				$gbh = explode(".",gethostbyaddr($_SERVER['REMOTE_ADDR']));
				if (strlen($gbh[sizeof($gbh)-2])<5)
					$suffix = $gbh[sizeof($gbh)-2];
				if (strlen($gbh[sizeof($gbh)-1])<3&&!is_numeric($gbh[sizeof($gbh)-1]))
				{
					$country = $gbh[sizeof($gbh)-1];
				} elseif (strlen($gbh[sizeof($gbh)-1])==3&&!is_numeric($gbh[sizeof($gbh)-1])) {
					$country = 'us';
					$suffix = $gbh[sizeof($gbh)-1];
				} else {
					$country = "ip";
					$suffix = "unkn";
				}
				if (is_object($xoopsUser))
				{
					$uid = $xoopsUser->getVar('uid');
				}
				srand(time);
				$frand = mt_rand();
				$sql .= "'". gethostbyaddr($_SERVER['REMOTE_ADDR'])."','".$_SERVER['REMOTE_ADDR']."',";
				$sql .= "'$suffix','$country','".time()."','".date("G")."','".date("i")."','".date("s")."','".date("m")."','".date("d")."','".$frand."','".$_SERVER['HTTP_HOST'].':'.$_SERVER['REMOTE_PORT'].$_SERVER['REQUEST_URI'].":".$_SERVER['REQUEST_URI']."','$uid','".session_id()."')";
				@$xoopsDB->queryF($sql);
				
				$frad = $xoopsDB->getInsertId();
				
				$sql = "UPDATE ".$xoopsDB->prefix('usage')." set `checksum` = sha1(concat(`hostname`, `ip`, `suffix`, `country`, `date`, `hour`, `minute`, `second`, `month`, `day`, `seed`, `requesturl`, `uid`, `sessionid`)) Where `ip` = '".$_SERVER['REMOTE_ADDR']."' and `seed` = '$frand'";
				@$xoopsDB->queryF($sql);
				
				$sql = "DELETE FROM ".$xoopsDB->prefix('usage')." where `date` < ".(time() - (3600*7*$xoopsModuleConfig['weeks_kept']));
				@$xoopsDB->queryF($sql);
			
				$sys_integrity = $this->System_Integrity(false);
				if ($sys_integrity*100<100)
				{
					$sql = "SELECT count(*) as rc ".$xoopsDB->prefix('usage_quarantine')." where integrity > '$sys_integrity'";
					list($rc) = $xoopsDB->fetchRow($xoopsDB->queryF($sql));

					$sql = "SELECT count(*) as ttl_rc ".$xoopsDB->prefix('usage_quarantine')."";
					list($ttl_rc) = $xoopsDB->fetchRow($xoopsDB->queryF($sql));
					if (($rc>0&&$ttl_rc>0)||$ttl_rc==0)
					{
						
						$frad = $this->Record_Quarantine('quarantine', $sys_integrity, $frad, $suffix, $country, $uid, 'Q'.mt_rand(10,99), $xoopsModuleConfig);
						
					}
				}
			}
			if (is_array($quarantine))
			{
				@$this->codes=$quarantine;
			}
		}
		
		function Clean_Quarantine($xoopsModuleConfig, $stages)
		{
			$sql = "DELETE FROM ".$xoopsDB->prefix('usage_quarantine')." where `integrity` > '".$xoopsModuleConfig['percentile_threshhold']."' and `date` < ".(time() - (3600*7*($xoopsModuleConfig['quarantine_kept'])));
			@$xoopsDB->queryF($sql);
				
			global $xoopsDB, $xoopsUser;
			foreach ($stages as $stage)
			{
				$sql = "DELETE FROM ".$xoopsDB->prefix('usage_quarantine_stage_'.$stage)." where `integrity` > '".$xoopsModuleConfig['percentile_threshhold']."' and `date` < ".(time() - (3600*7*($xoopsModuleConfig['quarantine_kept'])));
				@$xoopsDB->queryF($sql);
			}
		}
		
		function Record_Quarantine($table='quarantine', $sys_integrity, $frad, $suffix, $country, $uid, $stage, $xoopsModuleConfig)
		{


			global $xoopsDB, $xoopsUser;
			
			@$this->Clean_Quarantine($xoopsModuleConfig, array('a','b','c','d','e'));
			
			$sql = "SELECT count(*) as rc ".$xoopsDB->prefix('usage_'.$table)." where integrity > '$sys_integrity'";
			list($rc) = $xoopsDB->fetchRow($xoopsDB->queryF($sql));
			
			$sql = "SELECT count(*) as ttl_rc ".$xoopsDB->prefix('usage_'.$table)."";
			list($ttl_rc) = $xoopsDB->fetchRow($xoopsDB->queryF($sql));
			if (($rc>0&&$ttl_rc>0)||$ttl_rc==0)
			{

				$sql = "INSERT INTO ".$xoopsDB->prefix('usage_'.$table)." (`hostname`, `ip`, `frad`, `suffix`, `country`, `date`, `hour`, `minute`, `second`, `month`, `day`, `seed`, `requesturl`, `uid`, `sessionid`, `integrity`, `stage`) VALUES (";
				srand(time);
				$frand = mt_rand();
				$sql .= "'". gethostbyaddr($_SERVER['REMOTE_ADDR'])."','".$_SERVER['REMOTE_ADDR']."','$frad',";
				$sql .= "'$suffix','$country','".time()."','".date("G")."','".date("i")."','".date("s")."','".date("m")."','".date("d")."','".$frand."','".$_SERVER['HTTP_HOST'].':'.$_SERVER['REMOTE_PORT'].$_SERVER['REQUEST_URI']."','$uid','".session_id()."','$sys_integrity', '$stage')";
				@$xoopsDB->queryF($sql);
				$frad = $xoopsDB->getInsertId();
							
				$sql = "UPDATE ".$xoopsDB->prefix('usage_'.$table)." set `checksum` = sha1(concat(`hostname`, `ip`, `frad`, `suffix`, `country`, `date`, `hour`, `minute`, `second`, `month`, `day`, `seed`, `requesturl`, `uid`, `sessionid`,`integrity`,`stage`)) Where `ip` = '".$_SERVER['REMOTE_ADDR']."' and `seed` = '$frand'";
				@$xoopsDB->queryF($sql);
				@$this->Check_Quarantine_Stages($xoopsModuleConfig, array('', '_stage_a','_stage_b','_stage_c','_stage_d','_stage_e'));
				return $frad;
			}
			
			@$this->Check_Quarantine_Stages($xoopsModuleConfig, array('', '_stage_a','_stage_b','_stage_c','_stage_d','_stage_e'));
		}

		function Check_Quarantine_Stages($xoopsModuleConfig, $stages)
		{	
			global $xoopsDB, $xoopsUser;
			foreach ($stages as $key => $stage)
			{

				$sys_integrity = $this->Quarantine_System_Integrity($xoopsModuleConfig, false, 'usage_quarantine'.$stage);
				if ($sys_integrity*100<100)
				{
					$sql = "SELECT count(*) as rc ".$xoopsDB->prefix('usage_quarantine'.$stage)." where integrity > '$sys_integrity'";
					list($rc) = $xoopsDB->fetchRow($xoopsDB->queryF($sql));

					$sql = "SELECT count(*) as ttl_rc ".$xoopsDB->prefix('usage_quarantine'.$stage)."";
					list($ttl_rc) = $xoopsDB->fetchRow($xoopsDB->queryF($sql));
					
					if (($rc>0&&$ttl_rc>0)||$ttl_rc==0)
					{
						$ttl_cyc=$ttl_cyc+($sys_integrity*100);
						$ttl++;
						if (sizeof($stages)<$key+1)
						{
							$fradb = $this->Record_Quarantine('quarantine'.$stages[$key+1], $sys_integrity, $fradb, $suffix, $country, $uid, $key.':'.substr($stage,strlen($stage)-1,1), $xoopsModuleConfig);				
							
						} else {
							
						}
					}
				}
			}
			
			return array('integrity' => ($ttl_cyc / $ttl));
		}
		
		function System_Integrity($type = true, $table = 'usage')
		{
			global $xoopsDB, $xoopsUser;
			$sql[0] = "select count(*) as `match` from ".$xoopsDB->prefix($table)." where sha1(concat(`hostname`, `ip`, `suffix`, `country`, `date`, `hour`, `minute`, `second`, `month`, `day`, `seed`, `requesturl`, `uid`, `sessionid`)) = `checksum`";
			$sql[1] = "select count(*) as `total` from ".$xoopsDB->prefix($table)." where 2=2";
			list($match) =	$xoopsDB->fetchRow($xoopsDB->queryF($sql[0]));		
			list($total) =	$xoopsDB->fetchRow($xoopsDB->queryF($sql[1]));				
			if ($type==true)
			{
				return floor((($match+1)/($total+1))*100)."%";
			} else {
				return ((($match+1)/($total+1)));
			}
		}
		
		function Quarantine_System_Integrity($type = true, $table = 'usage_quarantine')
		{
			global $xoopsDB, $xoopsUser;
			$sql[0] = "select count(*) as `match` from ".$xoopsDB->prefix($table)." where sha1(concat(`hostname`, `ip`, `frad`, `suffix`, `country`, `date`, `hour`, `minute`, `second`, `month`, `day`, `seed`, `requesturl`, `uid`, `sessionid`,`integrity`,`stage`)) = `checksum`";
			$sql[1] = "select count(*) as `total` from ".$xoopsDB->prefix($table)." where 2=2";
			list($match) =	$xoopsDB->fetchRow($xoopsDB->queryF($sql[0]));		
			list($total) =	$xoopsDB->fetchRow($xoopsDB->queryF($sql[1]));				
			if ($type==true)
			{
				return floor((($match+1)/($total+1))*100)."%";
			} else {
				return ((($match+1)/($total+1)));
			}
		}
		
		function Complete_Integrity($type = true)
		{
			$stages = array("","_stage_a","_stage_b","_stage_c","_stage_d","_stage_e");
			foreach ($stages as $stage)
				{
					$usage_integrity = $usage_integrity + $this->Quarantine_System_Integrity(false, 'usage_quarantine'.$stage);
				}
			$usage_integrity = $usage_integrity + $this->System_Integrity(false);
			
			if ($type==true)
			{
				return floor((($usage_integrity)/(sizeof($stages)+1))*100)."%";
			} else {
				return ((($match+1)/($total+1)));
			}
		}

		function Complete_Quarantine_Integrity($type = true)
		{
			$stages = array("","_stage_a","_stage_b","_stage_c","_stage_d","_stage_e");
			foreach ($stages as $stage)
				{
					$usage_integrity = $usage_integrity + $this->Quarantine_System_Integrity(false, 'usage_quarantine'.$stage);
				}
		
			if ($type==true)
			{
				return floor((($usage_integrity)/(sizeof($stages)))*100)."%";
			} else {
				return ((($match+1)/($total+1)));
			}
		}

	}
}
?>