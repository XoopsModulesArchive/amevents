<?php
// $Id: validate.php,v 1.8 2006/03/08 22:18:17 andrew Exp $
//  ------------------------------------------------------------------------ //
//  Author: Andrew Mills                                                     //
//  Email:  ajmills@sirium.net                                         //
//	About:  This file is part of the AMEvents module for Xoops v2.           //
//                                                                           //
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
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
//  ------------------------------------------------------------------------ //

include ('../../../include/cp_header.php');
if ( file_exists("../language/".$xoopsConfig['language']."/main.php") ) {
	include "../language/".$xoopsConfig['language']."/main.php";
} else {
	include "../language/english/main.php";
}
include_once('../include/functions.inc.php');
include_once (XOOPS_ROOT_PATH. "/include/xoopscodes.php");
include_once XOOPS_ROOT_PATH."/class/module.errorhandler.php";
$myts =& MyTextSanitizer::getInstance();

#~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~#
if (!isset($_GET['op']) AND !isset($_POST['subop']) AND !isset($_GET['preview'])) {
xoops_cp_header();
amevent_admin_header("", _AM_EVE_NAVBCEVEVAL);
$class = "even";
?>

<br />

<script LANGUAGE="javascript">
<!-- start hiding
function spawn_window(content, spawn, sizing)
{window.open(content, spawn, sizing);}

//-->
</script>

<table border="0" cellspacing="1" style="width: 100%;" class="outer">
  <tr>
    <th colspan="7"><?php echo _AM_AMEVENT_CPTNVALTITLE; ?></th>
  </tr>
  <tr>
    <td class="head" style="text-align: center;"><?php echo _AM_AMEVENT_CPTNID; ?></td>
    <td class="head" style="text-align: center;"><?php echo _AM_AMEVENT_CPTNNAME; ?></td>
    <td class="head" style="text-align: center;"><?php echo _AM_AMEVENT_CPTNSTARTS; ?></td>
    <td class="head" style="text-align: center;"><?php echo _AM_AMEVENT_CPTNTENDS; ?></td>
    <td class="head"></td>
    <td class="head"></td>
    <td class="head"></td>
  </tr>

<?php  
  
	//$sql = ("SELECT * FROM " .$xoopsDB->prefix('amevents_events') . " WHERE event_date_start > NOW() AND event_validated = 0 ORDER BY event_date_start ASC");
	$sql = ("SELECT * FROM " .$xoopsDB->prefix('amevents_events') . " WHERE event_validated = 0 ORDER BY event_date_start ASC");
    $result=$xoopsDB->query($sql);
    
    if ($xoopsDB->getRowsNum($result) > 0) {
		while($myrow = $xoopsDB->fetchArray($result)) {
			//$event['event_id']         = $myrow['id'];
			$event_date_start = $myrow['event_date_start'];
			$event_date_end   = $myrow['event_date_end'];
		
		// set active colour
        if ($event_date_start >= date("Y-m-d")) { $datestatus = "green"; }
        // set expired colour
        if ($event_date_start < date("Y-m-d")) { $datestatus = "red"; }
        // set hidden colour
        //if ($event_showme == 0) { $datestatus = "darkgray"; }
        
        // set end date colours
        // active
        if ($event_date_end >= date("Y-m-d")) { $enddatestatus = "green"; }
        // expired
        if ($event_date_end < date("Y-m-d")) { $enddatestatus = "red"; }
        // hidden
        //if ($event_showme == 0) { $enddatestatus = "darkgray"; }
			
			if ($class == "even") { $class = "odd"; }
				else { $class = "even"; }
?>

<tr>
  <td class="<?php echo $class; ?>" style="text-align: center; width: 25px;"><?php echo $myrow['id']; ?></td>
  <td class="<?php echo $class; ?>"><a href="javascript:spawn_window('preview.php?id=<?php echo $myrow['id']; ?>','preview','scrollbars=yes,height=550,width=600')" onMouseover="window.status='<?php echo _AM_AMEVENT_CPTNPREVIEW; ?>'; return true" onMouseout="window.status=' '; return true"><?php echo $myrow['event_name']; ?></a></td>
  <td class="<?php echo $class; ?>" style="text-align: center; width: 40px; color: <?php echo $datestatus; ?>;"><?php echo formatTimestamp(strtotime($event_date_start), $xoopsModuleConfig['datefrmtadmin']); ?></td>
  <td class="<?php echo $class; ?>" style="text-align: center; width: 40px; color: <?php echo $enddatestatus; ?>;"><?php echo formatTimestamp(strtotime($event_date_end), $xoopsModuleConfig['datefrmtadmin']); ?></td>
  <td class="<?php echo $class; ?>" style="text-align: center; width: 20px;"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?op=val&amp;id=<?php echo $myrow['id']; ?>"   onMouseover="window.status='<?php echo _AM_AMEVENT_CPTNVAL; ?>'; return true"   onMouseout="window.status=' '; return true" title="<?php echo _AM_AMEVENT_CPTNVAL; ?>"><img src="../images/tickg.png" width="16" height="16" alt="<?php echo _AM_AMEVENT_CPTNVAL; ?>" border="0"></a></td>
  <td class="<?php echo $class; ?>" style="text-align: center; width: 20px;"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?op=valed&amp;id=<?php echo $myrow['id']; ?>" onMouseover="window.status='<?php echo _AM_AMEVENT_CPTNVALED; ?>'; return true" onMouseout="window.status=' '; return true" title="<?php echo _AM_AMEVENT_CPTNVALED; ?>"><img src="../images/ticko.png" width="16" height="16" alt="<?php echo _AM_AMEVENT_CPTNVALED; ?>" border="0"></a></td>
  <td class="<?php echo $class; ?>" style="text-align: center; width: 20px;"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?op=del&amp;id=<?php echo $myrow['id']; ?>"   onMouseover="window.status='<?php echo _AM_AMEVENT_CPTNDEL; ?>'; return true"   onMouseout="window.status=' '; return true" title="<?php echo _AM_AMEVENT_CPTNDEL; ?>"><img src="../images/del3.png" width="16" height="16" alt="<?php echo _AM_AMEVENT_CPTNDEL; ?>" border="0"></a></td>
</tr>

<?php 

		} // while
	} // if
	else {
?>
  <tr>
    <td colspan="7" class="even" style="text-align: center;"><?php echo _AM_AMEVENT_CPTNNOVAL; ?></td>
  </tr>
<?php		
	}
	
	
?>  
  <!--
  <tr>
    <td>e</td>
    <td></td>
  </tr>
  -->
</table>



<?php

admin_foot_text(); 
xoops_cp_footer();
} // end if

#~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~#

if (isset($_GET['op']) OR isset($_POST['op']) AND !isset($_GET['preview'])) {
xoops_cp_header();
	if (isset($_GET['id'])) { $id = $_GET['id']; }

	## Validate and show
	if ($_GET['op'] == "val") {
	//xoops_cp_header();
		$sql = ("UPDATE ".$xoopsDB->prefix("amevents_events")." SET event_validated=1 WHERE id=$id");
		#$result=$xoopsDB->query($sql);

		// Note: add notify (event validated)
		if ($xoopsDB->queryF($sql)) {
		//if ($xoopsDB->getAffectedRows($sql)) {
				$eventdetails = event_details($id);
				//global $xoopsModule;
				$extratags = array();
				//$extratags['AMEVENT_TITLE'] = $eventdetails['event_name'];
				$extratags['AMEVENT_URL']   = XOOPS_URL . "/modules/" . $xoopsModule->getVar('dirname') . "/index.php?id=" . $eventdetails['event_name'];
				$notification_handler =& xoops_gethandler('notification');
				$notification_handler->triggerEvent('global', 0, 'new_eventuser', $extratags);
			redirect_header("validate.php", 2, _AM_AMEVENT_CONF_VAL);
			//echo "entered";
		} else {
			redirect_header("validate.php", 2, _AM_AMEVENT_CONF_VALFAIL);
			//echo "not entered";
		}
	//xoops_cp_footer();	
	} // if
	
	## Validate and do not show
	if ($_GET['op'] == "valed") {
	//xoops_cp_header();
		$sql = ("UPDATE ".$xoopsDB->prefix("amevents_events")." SET event_validated=1, event_showme=0 WHERE id=$id");
		#$result=$xoopsDB->query($sql);

		// Note: add notify (event validated)
		if ($xoopsDB->queryF($sql)) {
			redirect_header("validate.php", 2, _AM_AMEVENT_CONF_VAL);
			//echo "entered";
		} else {
			redirect_header("validate.php", 2, _AM_AMEVENT_CONF_VALFAIL);
			//echo "not entered";
		}
	//xoops_cp_footer();	
	} // if

	
		
	## Delete event confirm
	if ($_GET['op'] == "del") {
	//xoops_cp_header();
	
		#echo "delete stuff";
		xoops_confirm(array('op' => 'del', 'id' => $id, 'subop' => 'delok'), 'validate.php', _AM_EVE_CONF_VALDELSURE);			
		
	//xoops_cp_footer();			
	}
	## Actually delete.
	if (isset($_POST['subop'])) {
	//xoops_cp_header();
		if (isset($_POST['id'])) { $id = $_POST['id']; }
		
		$sql = sprintf("DELETE FROM %s WHERE id = %u", $xoopsDB->prefix("amevents_events"), $id);
			if ($xoopsDB->queryF($sql)) {
				// delete comments for the article being deleted
				#xoops_comment_delete($xoopsModule->getVar('mid'), $id);
				// delete notifications for deleted article
				#xoops_notification_deletebyitem($xoopsModule->getVar('mid'), 'global', $id);
				redirect_header("validate.php", 1, _AM_EVE_CONF_VALDEL);
				#echo "yuss, deleted";	
			} else {
				redirect_header("validate.php", 1, _AM_EVE_CONF_VALDELFAIL);
				#echo "not deleted";
			}  // end else
		
	//xoops_cp_footer();	
	} // if
} // end




?>
