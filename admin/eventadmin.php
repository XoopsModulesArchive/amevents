<?php
// $Id: eventadmin.php,v 1.7 2006/03/08 22:18:17 andrew Exp $
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

include_once ('../../../include/cp_header.php');
if ( file_exists("../language/".$xoopsConfig['language']."/main.php") ) {
	include "../language/".$xoopsConfig['language']."/main.php";
} else {
	include "../language/english/main.php";
}
include_once('../include/functions.inc.php');
include_once (XOOPS_ROOT_PATH. "/include/xoopscodes.php");
include_once (XOOPS_ROOT_PATH."/class/module.errorhandler.php");
include_once (XOOPS_ROOT_PATH. "/class/xoopsformloader.php");
$myts =& MyTextSanitizer::getInstance(); // MyTextSanitizer object

#==============================================================================#
# list
if (!isset($_GET['op']) AND !isset($_POST['op'])) {
xoops_cp_header();
amevent_admin_header("", _AM_EVE_NAVBCEVEADDED);
    
    // set class var
    $class = "even";
    
    // get number events stuff
    $numevents = number_events();
    
    // Set show event types
    if (!isset($_GET['show'])) { $showeventsql = "WHERE event_validated=1"; $evecolour = 0; }
    if (isset($_GET['show']) && $_GET['show'] == "all") { $showeventsql = " WHERE event_validated=1"; $evecolour = 0; }
    if (isset($_GET['show']) && $_GET['show'] == "act") { $showeventsql = "WHERE event_date_start >= NOW() AND event_validated=1"; $evecolour = 1; }
    if (isset($_GET['show']) && $_GET['show'] == "end") { $showeventsql = "WHERE event_date_start < NOW() AND event_validated=1"; $evecolour = 2; }
     
    
    $sql = ("SELECT * FROM " . $xoopsDB->prefix("amevents_events") . " " . $showeventsql . " ORDER BY event_date_start DESC");
    $result=$xoopsDB->query($sql);
    
?>
<script LANGUAGE="javascript">
<!-- start hiding
function spawn_window(content, spawn, sizing)
{window.open(content, spawn, sizing);}
//-->
</script>

<br />

<table border="0" cellpadding="0" cellspacing="1" style="width: 100%;" class="outer">
  <tr>
    <th colspan="6"><?php echo _AM_AMEVENT_CPTNTITLE; ?></th>
  </tr>
  <tr>
    <td colspan="6" class="head">
      <span style="color: <? if($evecolour == 0) { echo "red"; } else { echo "black"; } ?>;"><?php echo $numevents['all']; ?></span> 
      <a href="<?php echo $_SERVER['PHP_SELF']; ?>?show=all"><?php echo _AM_AMEVENT_CPTNEVENTS; ?></a> 
      | 
      <span style="color: <? if($evecolour == 1) { echo "red"; } else { echo "black"; } ?>;"><?php echo $numevents['active']; ?></span> 
      <a href="<?php echo $_SERVER['PHP_SELF']; ?>?show=act"><?php echo _AM_AMEVENT_CPTNACTIVE; ?></a>
      | 
      <span style="color: <? if($evecolour == 2) { echo "red"; } else { echo "black"; } ?>;"><?php echo $numevents['expired']; ?></span> 
      <a href="<?php echo $_SERVER['PHP_SELF'];?>?show=end"><?php echo _AM_AMEVENT_CPTNENDS; ?></a>
      &nbsp;&nbsp;&nbsp;&nbsp;
      <?php echo _AM_AMEVENT_CPTNDATE; ?>:  <?php echo date("D, d F Y"); ?>
    </td>
  </tr>
  <tr>
    <td class="head" style="width: 25px; text-align: center;"><?php echo _AM_AMEVENT_CPTNID; ?></td>
    <td class="head" style="text-align: center;"><?php echo _AM_AMEVENT_CPTNNAME; ?></td>
    <td class="head" style="text-align: center;"><?php echo _AM_AMEVENT_CPTNSTARTS; ?></td>
    <td class="head" style="text-align: center;"><?php echo _AM_AMEVENT_CPTNTENDS; ?></td>
    <td class="head" style="text-align: center; width: 20px;">&nbsp;</td>
    <td class="head" style="text-align: center; width: 20px;">&nbsp;</td>
  </tr>
  
<?php
    if ($xoopsDB->getRowsNum($result) > 0) {
      while($myrow = $xoopsDB->fetchArray($result)) {
        $id               = $myrow['id'];
        $event_name       = $myrow['event_name'];
        $event_date_start = $myrow['event_date_start'];
        $event_date_end   = $myrow['event_date_end'];
        $event_showme     = $myrow['event_showme'];
        
        if ($class == "even") { $class = "odd"; }
        else { $class = "even"; }
        
        // set active colour
        if ($event_date_start >= date("Y-m-d H:i")) { $datestatus = "green"; }
        // set expired colour
        if ($event_date_start < date("Y-m-d H:i")) { $datestatus = "red"; }
        // set hidden colour
        if ($event_showme == 0) { $datestatus = "darkgray"; }
        
        // set end date colours
        // active
        if ($event_date_end >= date("Y-m-d H:i")) { $enddatestatus = "green"; }
        // expired
        if ($event_date_end < date("Y-m-d H:i")) { $enddatestatus = "red"; }
        // hidden
        if ($event_showme == 0) { $enddatestatus = "darkgray"; }
        
?>
  <tr>
    <td class="<?php echo $class; ?>" style="width: 25px; text-align: center;"><?php echo $id; ?></td>
    <td class="<?php echo $class; ?>"><a href="javascript:spawn_window('preview.php?id=<?php echo $id; ?>','thingy','scrollbars=yes,height=550,width=600')"><?php echo $event_name; ?></a></td>
    <td class="<?php echo $class; ?>" style="text-align: center; color: <?php echo $datestatus; ?>;"><?php echo formatTimestamp(strtotime($event_date_start), $xoopsModuleConfig['datefrmtadmin']); ?></td>
    <td class="<?php echo $class; ?>" style="text-align: center; color: <?php echo $enddatestatus; ?>;"><?php echo formatTimestamp(strtotime($event_date_end), $xoopsModuleConfig['datefrmtadmin']); ?></td>
    <td class="<?php echo $class; ?>" style="text-align: center; width: 20px;"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?op=edit&amp;id=<?php echo $id; ?>" title="<?php echo _AM_AMEVENT_CPTNEDIT; ?>"><img src="../images/edit3.png" width="16" height="16" alt="<?php echo _AM_AMEVENT_CPTNEDIT; ?>" border="0"></a></td>
    <td class="<?php echo $class; ?>" style="text-align: center; width: 20px;"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?op=del&amp;id=<?php echo $id; ?>" title="<?php echo _AM_AMEVENT_CPTNDEL; ?>"><img src="../images/del3.png" width="16" height="16" alt="<?php echo _AM_AMEVENT_CPTNDEL; ?>" border="0"></a></td>
  </tr>

<?php
        } // end while
    } // end if
?>
</table>
<?php   
admin_foot_text();
xoops_cp_footer();    
} //

#==============================================================================#
# edit event - fill form with event data, etc.
if (isset($_GET['op']) && $_GET['op'] == "edit") {
xoops_cp_header();
amevent_admin_header("", _AM_EVE_NAVBCEVEED);

echo "<br />";

if (isset($_GET['id'])) { $id = $_GET['id']; }
else { $id = "0"; }

    $sql = ("SELECT * FROM " . $xoopsDB->prefix("amevents_events") . " WHERE id =$id LIMIT 1");
    $result=$xoopsDB->query($sql);
    
        if ($xoopsDB->getRowsNum($result) > 0) {
            while($myrow = $xoopsDB->fetchArray($result)) {
                
                $data['id']                = $myrow['id'];
                $data['event_name']			= $myts->htmlSpecialChars($myrow['event_name']);
                $data['event_date_start']	= $myrow['event_date_start'];
                $data['event_date_end']		= $myrow['event_date_end'];
                $data['event_url']			= $myts->htmlSpecialChars($myrow['event_url']);
                $data['event_description']	= $myts->htmlSpecialChars($myrow['event_description']);
                $data['event_duration']		= $myrow['event_duration'];
                $data['event_country']		= $myrow['event_country'];
                #$data['event_validated']	= $myrow['event_validated'];
                $data['event_showme']		= $myrow['event_showme'];
                $event_uid		= $myrow['uid'];
                $event_html		= $myrow['event_html'];
                $event_smiley	= $myrow['event_smiley'];
                $event_xcode	= $myrow['event_xcode'];
                $event_image	= $myrow['event_image'];
                $event_br		= $myrow['event_br'];

            } // end while
        } // end if

// We need to set the title in the included form (either edit or add).
$formtitle = _AM_EVENTEDIT;
$formfunc = "edit";

// include edit/add form thingy. Aren't my comments good? No? Oh well...
include_once('form.inc.php');
?>

<?php
admin_foot_text();  
xoops_cp_footer();    
} // end if

#==============================================================================#
# delete confirm
if ((isset($_GET['op']) && $_GET['op'] == "del") OR (isset($_POST['op']) && $_POST['op'] == "del")) {
xoops_cp_header();

	// go to confirm page
	#if (!isset($_POST['subop'])) {
	if ($_GET['op'] == "del") {
		#xoops_cp_header();
		if (isset($_GET['id'])) { $id = $_GET['id']; }
		xoops_confirm(array('op' => 'del', 'id' => $id, 'subop' => 'delok'), 'eventadmin.php', _AM_EVE_CONF_CONFIRMDEL);
		#xoops_cp_footer();
	} // end

	// actual delete code	
	if (isset($_POST['subop'])) {
		if (isset($_POST['id'])) { $id = $_POST['id']; }
		#echo "deleted";
		
		$sql = sprintf("DELETE FROM %s WHERE id = %u", $xoopsDB->prefix("amevents_events"), $id);
	                
			if ($xoopsDB->queryF($sql)) {
				// delete comments for the article being deleted
				xoops_comment_delete($xoopsModule->getVar('mid'), $id);
				// delete notifications for deleted article
				#xoops_notification_deletebyitem($xoopsModule->getVar('mid'), 'global', $art_id);
				#xoops_notification_deletebyitem($xoopsModule->getVar('mid'), 'admin', $id);
				redirect_header("eventadmin.php", 1, _AM_EVE_CONF_DELETED);
				//echo "yuss, deleted";
			} else {
				redirect_header("eventadmin.php", 1, _AM_EVE_CONF_NOTDELETED);
				#echo "not deleted";
			}  // end else

	} // end if 
    
xoops_cp_footer();    
} // end if
#==============================================================================#
# submit edited doodah
if ((isset($_POST['op']) && $_POST['op'] == "edit") AND ($_POST['op'] != "del")) {
xoops_cp_header();

if (isset($_POST['formdata'])) { $formdata = $_POST['formdata']; }
//echo "<pre>";
//print_r($formdata);
//var_dump($formdata);
//echo "</pre>";

	$id					= $formdata['id'];
	$event_name 		= $myts->addSlashes($formdata['event_name']);
    $startdate			= $formdata['startdate'];
    $enddate			= $formdata['enddate'];
    $event_country		= $formdata['country'];
    $event_url			= $formdata['url'];
    $event_uid			= $formdata['uid'];
    $event_description	= $myts->addSlashes($formdata['description']);
    $event_showme		= $formdata['showme']; // checkbox, thingy for doodah

    if (isset($formdata['html'])) { $event_html = "1"; } 
    	else { $event_html = "0"; }
	if (isset($formdata['br'])) { $event_br = "1"; } 
		else { $event_br = "0"; }
	if (isset($formdata['smiley'])) { $event_smiley = "1"; } 
		else { $event_smiley = "0"; }
	if (isset($formdata['xcode'])) { $event_xcode = "1"; } 
		else { $event_xcode = "0"; }
	if (isset($formdata['image'])) { $event_image = "1"; } 
		else { $event_image = "0"; }
	

    // if more than one day, find length of event in whole days
    if (isset($formdata['multiday'])) { 
	    #$var_name = strtotime($var_name['date']) + $var_name['time'];
        #$multiday = $formdata['multiday']; 
        // automagically find duration of event
        //$unixstart = mktime(0, 0, 0, $month, $day, $year);
        $unixstart = strtotime($startdate['date']);// + $startdate['time'];
        //$unixend   = mktime(0, 0, 0, $monthend, $dayend, $yearend);
        $unixend = strtotime($enddate['date']);// + $enddate['time'];
        $unixduration = $unixend - $unixstart;
        $event_duration = $unixduration / 60 / 60 / 24 +1;
		//echo $event_duration;
    } else {
        $event_duration = "1";
    }
    
    // get userid
    #$event_uid = $xoopsUser->getVar('uid');
	
    // format dates for entry into doodah
    //$event_date_start = $year . "-" . $month . "-" . $day . " 00:00:00";
    $event_date_start = date("Y-m-d H:i:s", strtotime($startdate['date']) + $startdate['time']);
    //echo "(".$event_date_start.")";
    // prevent year being set to 2000 when no end date set
    if (isset($formdata['multiday'])) { 
    	//$event_date_end = $yearend . "-" . $monthend . "-" . $dayend . " 00:00:00";
    	$event_date_end = date("Y-m-d H:i:s", strtotime($enddate['date']) + $enddate['time']);
    	//echo "(".$event_date_end.")";
	} else {
		// If not multiday event and/or only one, fake time so event expires at
		// end of day.
		$event_date_end = $startdate['date'] . " 23:59:59";
	}

    if (isset($formdata['showme'])) { $event_showme = "1"; }
    	else { $event_showme = "0"; }


	$sql = ("UPDATE ".$xoopsDB->prefix("amevents_events").
	" SET 
	id					= '$id',
	event_name			= '$event_name', 
	event_date_start	= '$event_date_start', 
	event_date_end		= '$event_date_end', 
	event_url			= '$event_url', 
	event_description	= '$event_description', 
	event_duration		= '$event_duration', 
	event_country		= '$event_country', 
	event_validated		= 1, 
	event_showme		= '$event_showme',
	uid					= '$event_uid',
	event_html			= '$event_html',
	event_smiley		= '$event_smiley',
	event_xcode			= '$event_xcode',
	event_image			= '$event_image',
	event_br			= '$event_br'
	WHERE id=$id");	


	$result=$xoopsDB->query($sql);

	if ($xoopsDB->query($sql)) {
			if ($event_showme == "1") {
				$extratags = array();
				$extratags['AMEVENT_TITLE'] = $event_name;
				$extratags['AMEVENT_URL']   = XOOPS_URL . "/modules/" . $xoopsModule->getVar('dirname') . "/index.php?id=" . $id;
				$notification_handler =& xoops_gethandler('notification');
				$notification_handler->triggerEvent('global', 0, 'new_eventuser', $extratags);
			}
			redirect_header("eventadmin.php", 2, _AM_EVE_CONF_UPDATED);
			//echo "entered";
		} else {
			redirect_header("eventadmin.php", 2, _AM_EVE_CONF_UPDATEDFAIL);
			//echo "not entered";
		}


		
xoops_cp_footer();
} // end if




?>