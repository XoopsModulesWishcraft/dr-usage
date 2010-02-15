<?php
//  ------------------------------------------------------------------------ //
//                          XOOPS - Dr. Usage                                //
//                Copyright (c) 2007 chronolabs.org.au                       //
//                  <http://www.chronolabs.org.au/>                          //
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
// ------------------------------------------------------------------------- //
// Author: Simon Roberts (AKA Wishcraft)                                     //
// Site: http://www.chronolabs.org.au                                        //
// Project: The Chrononaut Project                                           //
// ------------------------------------------------------------------------- //

$modversion['name']		    = 'Dr. Usage';
$modversion['version']		= 2.09;
$modversion['author']       = 'Simon Roberts (aka wishcraft)';
$modversion['description']	= 'Usage is a module that allows for users to view hit statistics to your xoops!';
$modversion['credits']		= "Chronolabs";
$modversion['license']		= "GNU see LICENSE";
$modversion['help']		    = "";
$modversion['official']		= 1;
$modversion['image']		= "images/logo.gif";
$modversion['dirname']		= 'usage';

// All tables should not have any prefix!
$modversion['sqlfile']['mysql'] = "sql/usage.sql";

// Tables created by sql file (without prefix!)
$modversion['tables'][0]	= 'usage';
$modversion['tables'][1]	= 'usage_quarantine';
$modversion['tables'][2]	= 'usage_quarantine_stage_a';
$modversion['tables'][3]	= 'usage_quarantine_stage_b';
$modversion['tables'][4]	= 'usage_quarantine_stage_c';
$modversion['tables'][5]	= 'usage_quarantine_stage_d';
$modversion['tables'][6]	= 'usage_quarantine_stage_e';
//$modversion['tables'][1]	= 'rss_content';
//$modversion['tables'][2]	= 'rss_contentheader';

// Admin things
$modversion['hasAdmin']		= 1;
$modversion['adminindex']	= "admin/index.php";
$modversion['adminmenu']	= "admin/menu.php";

// Search
$modversion['hasSearch'] = 0;
$modversion['search']['file'] = "include/search.inc.php";
$modversion['search']['func'] = "content_search";

// Menu
$modversion['hasMain'] = 1;

// Submenu Items

//$modversion['sub'][0]['name'] = 'Add Feed';
//$modversion['sub'][0]['url'] = "addfeed.php";
//$modversion['sub'][1]['name'] = 'New Content';
//$modversion['sub'][1]['url'] = "index.php?pid=new";
//$modversion['sub'][2]['name'] = 'By Category';
//$modversion['sub'][2]['url'] = "bycategory.php";

// Smarty
$modversion['use_smarty'] = 1;

// Templates
$modversion['templates'][1]['file'] = 'usage_index.html';
$modversion['templates'][1]['description'] = 'Usage Index Page';
//$modversion['templates'][2]['file'] = 'statistics_list.htm';
//$modversion['templates'][2]['description'] = 'Statistics List';
//$modversion['templates'][2]['file'] = 'rssnews_list.htm';
//$modversion['templates'][2]['description'] = 'RSS Feed List';
// Blocks

$modversion['blocks'][1]['file'] = "usage_block.php";
$modversion['blocks'][1]['name'] = USAGE_GRAPH_BLOCK;
$modversion['blocks'][1]['description'] = USAGE_GRAPH_BLOCKDESC;
$modversion['blocks'][1]['options'] = "190|230|1";
$modversion['blocks'][1]['edit_func'] = "usage_block_edit";
$modversion['blocks'][1]['show_func'] = "usage_block_display";
$modversion['blocks'][1]['template'] = 'usage_block.html';
/*
$modversion['blocks'][2]['file'] = "ct_sitenavigation.php";
$modversion['blocks'][2]['name'] = _MIC_C_BNAME2;
$modversion['blocks'][2]['description'] = _MIC_C_BNAME2_DESC;
$modversion['blocks'][2]['show_func'] = "site_block_nav";
$modversion['blocks'][2]['template'] = 'ct_site_nav_block.html';

$modversion['blocks'][3]['file'] = "ct_dhtml_sitenavigation.php";
$modversion['blocks'][3]['name'] = _MIC_C_BNAME3;
$modversion['blocks'][3]['description'] = _MIC_C_BNAME3_DESC;
$modversion['blocks'][3]['show_func'] = "site_block_dhtml_nav";
$modversion['blocks'][3]['template'] = 'ct_dhtml_site_nav_block.html';
*/
// Comments
/*$modversion['hasComments'] = 1;
$modversion['comments']['itemName'] = 'id';
$modversion['comments']['pageName'] = 'index.php';
*/
$modversion['config'][1]['name'] = 'graph';
$modversion['config'][1]['title'] = 'USAGE_GRAPH';
$modversion['config'][1]['description'] = 'USAGE_GRAPHDESC';
$modversion['config'][1]['formtype'] = 'select';
$modversion['config'][1]['valuetype'] = 'text';
$modversion['config'][1]['default'] = 'usagegraph-line.php';
$modversion['config'][1]['options'] = array( 'Line Usage Graph' => 'usagegraph-line.php', 'Bar Usage Graph' => 'usagegraph-bar.php', 'Area Fill Usage Graph' => 'usagegraph-fillarea.php');

$modversion['config'][2]['name'] = 'xsize';
$modversion['config'][2]['title'] = 'USAGE_GRAPH_XSIZE';
$modversion['config'][2]['description'] = 'USAGE_GRAPH_XSIZEDESC';
$modversion['config'][2]['formtype'] = 'text';
$modversion['config'][2]['valuetype'] = 'int';
$modversion['config'][2]['default'] = '450';

$modversion['config'][3]['name'] = 'ysize';
$modversion['config'][3]['title'] = 'USAGE_GRAPH_YSIZE';
$modversion['config'][3]['description'] = 'USAGE_GRAPH_YSIZEDESC';
$modversion['config'][3]['formtype'] = 'text';
$modversion['config'][3]['valuetype'] = 'int';
$modversion['config'][3]['default'] = '350';

$modversion['config'][4]['name'] = 'xsize_b';
$modversion['config'][4]['title'] = 'USAGE_GRAPH_XSIZEB';
$modversion['config'][4]['description'] = 'USAGE_GRAPH_XSIZEBDESC';
$modversion['config'][4]['formtype'] = 'text';
$modversion['config'][4]['valuetype'] = 'int';
$modversion['config'][4]['default'] = '300';

$modversion['config'][5]['name'] = 'ysize_b';
$modversion['config'][5]['title'] = 'USAGE_GRAPH_YSIZEB';
$modversion['config'][5]['description'] = 'USAGE_GRAPH_YSIZEBDESC';
$modversion['config'][5]['formtype'] = 'text';
$modversion['config'][5]['valuetype'] = 'int';
$modversion['config'][5]['default'] = '250';

$modversion['config'][6]['name'] = 'ticks_shown';
$modversion['config'][6]['title'] = 'USAGE_GRAPH_TICKS';
$modversion['config'][6]['description'] = 'USAGE_GRAPH_TICKSDESC';
$modversion['config'][6]['formtype'] = 'select';
$modversion['config'][6]['valuetype'] = 'int';
$modversion['config'][6]['default'] = '10';
$modversion['config'][6]['options'] = array('5 Hours' => 5, '6 Hours' => 6,'7 Hours' => 7,'8 Hours' => 8,'9 Hours' => 9,'10 Hours' => 10,'11 Hours' => 5,'12 Hours' => 5,'13 Hours' => 5,'15 Hours' => 15,'19 Hours' => 19,'24 Hours' => 24);

$modversion['config'][7]['name'] = 'weeks_kept';
$modversion['config'][7]['title'] = 'USAGE_GRAPH_WEEKS';
$modversion['config'][7]['description'] = 'USAGE_GRAPH_WEEKSDESC';
$modversion['config'][7]['formtype'] = 'select';
$modversion['config'][7]['valuetype'] = 'int';
$modversion['config'][7]['default'] = '6';
$modversion['config'][7]['options'] = array('2 Weeks' => '2', '4 Weeks' => '4', '6 Weeks' => '6', '8 Weeks' => '8', '10 Weeks' => '10', '12 Weeks' => '12', '14 Weeks' => '14', '16 Weeks' => '16', '18 Weeks' => '18', '20 Weeks' => '20');

$modversion['config'][8]['name'] = 'percentile_threshhold';
$modversion['config'][8]['title'] = 'USAGE_PERCENT_THRESH';
$modversion['config'][8]['description'] = 'USAGE_PERCENT_THRESHDESC';
$modversion['config'][8]['formtype'] = 'text';
$modversion['config'][8]['valuetype'] = 'int';
$modversion['config'][8]['default'] = '97';

$modversion['config'][9]['name'] = 'quarantine_kept';
$modversion['config'][9]['title'] = 'USAGE_QUARANTINE_WEEKS';
$modversion['config'][9]['description'] = 'USAGE_QUARANTINE_WEEKSDESC';
$modversion['config'][9]['formtype'] = 'select';
$modversion['config'][9]['valuetype'] = 'int';
$modversion['config'][9]['default'] = '12';
$modversion['config'][9]['options'] = array('2 Weeks' => '2', '4 Weeks' => '4', '6 Weeks' => '6', '8 Weeks' => '8', '10 Weeks' => '10', '12 Weeks' => '12', '14 Weeks' => '14', '16 Weeks' => '16', '18 Weeks' => '18', '20 Weeks' => '20');

$modversion['config'][10]['name'] = 'htaccess';
$modversion['config'][10]['title'] = 'USAGE_HTACCESS';
$modversion['config'][10]['description'] = 'USAGE_HTACCESSDESC';
$modversion['config'][10]['formtype'] = 'yesno';
$modversion['config'][10]['valuetype'] = 'int';
$modversion['config'][10]['default'] = '0';
?>
