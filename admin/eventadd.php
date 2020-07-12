<?php
// $Id: eventadd.php,v 1.6 2006/03/08 22:18:17 andrew Exp $
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
	include ("../language/".$xoopsConfig['language']."/main.php");
} else {
	include ("../language/english/main.php");
}
include_once ("../include/functions.inc.php");
include_once (XOOPS_ROOT_PATH. "/include/xoopscodes.php");
include_once (XOOPS_ROOT_PATH. "/class/module.errorhandler.php");
include_once (XOOPS_ROOT_PATH. "/class/xoopsformloader.php");
$myts =& MyTextSanitizer::getInstance(); // MyTextSanitizer object

#~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~#
if (!isset($_POST['op'])) {
xoops_cp_header();
//amevent_admin_header("", "<a href=\"". XOOPS_URL ."/modules/". $xoopsModule->getVar('dirname') ."/admin/index.php\">". _AM_EVE_NAVINDEX ."</a> &raquo; ". _AM_EVE_NAVBCEVEADD ."");
amevent_admin_header("", _AM_EVE_NAVBCEVEADD);

echo "<br />";

// We need to set the title in the included form (either edit or add).
$formtitle = _AM_EVENTADD;
$formfunc = "add";

// include edit/add form thingy. Aren't my comments good? No? Oh well...
include_once('form.inc.php');

admin_foot_text(); 
xoops_cp_footer();
} // end if

#~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~#

if (isset($_POST['op']) && $_POST['op'] == "add") {
xoops_cp_header();

if (isset($_POST['formdata'])) { $formdata = $_POST['formdata']; }

#echo "<pre>";
#print_r($formdata);
#var_dump($formdata);
#echo "</pre>";

	$event_name 		= $myts->addSlashes($formdata['event_name']);
	$startdate			= $formdata['startdate'];
    $enddate			= $formdata['enddate'];
	//$year				= $formdata['year'];
    //$month				= $formdata['month'];
    //$day				= $formdata['day'];
    //$yearend			= $formdata['yearend'];
    //$monthend			= $formdata['monthend'];
    //$dayend				= $formdata['dayend'];
    $event_country		= $formdata['country'];
    $event_url			= $formdata['url'];
    $event_uid			= $formdata['uid'];
    $event_description	= $myts->addSlashes($formdata['description']);
    #$event_show		= $formdata['showme']; // checkbox, thingy for doodah
    
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
        
	if (isset($formdata['multiday'])) { 
        #$multiday = $formdata['multiday']; 
        // automagically find duration of event
        $unixstart = strtotime($startdate['date']);
        $unixend = strtotime($enddate['date']);
        $unixduration = $unixend - $unixstart;
        $event_duration = $unixduration / 60 / 60 / 24 +1;

    } else {
        $event_duration = "1";
    }
    
    // get userid
    #$event_uid = $xoopsUser->getVar('uid');
	
    // format dates for entry into doodah
    $event_date_start = date("Y-m-d H:i:s", strtotime($startdate['date']) + $startdate['time']);
    // prevent year being set to 2000 when no end date set
    if (isset($formdata['multiday'])) { 
    	$event_date_end = date("Y-m-d H:i:s", strtotime($enddate['date']) + $enddate['time']);
	} else {
		// If not multiday event and/or only one, fake time so event expires at
		// end of day.
		$event_date_end = $startdate['date'] . " 23:59:59";
	}

    if (isset($formdata['showme'])) { $event_showme = "1"; }
    	else { $event_showme = "0"; }
    

	$newid = $xoopsDB->genId($xoopsDB->prefix("amevents_events")."_id_seq");
	$sql = "INSERT INTO ".$xoopsDB->prefix("amevents_events")." VALUES (
	'$newid', 
	'$event_name', 
	'$event_date_start', 
	'$event_date_end', 
	'$event_url', 
	'$event_description', 
	'$event_duration', 
	'$event_country', 
	1, 
	'$event_showme',
	'$event_uid',
	'$event_html',
	'$event_smiley',
	'$event_xcode',
	'$event_image',
	'$event_br'
	)";

	
	$xoopsDB->query($sql) or $eh->show("0013");
    if ($newid == 0) {
        $newid = $xoopsDB->getInsertId();
        #$newid = mysql_insert_id();
    }
		##if ($xoopsDB->query($sql)) {
        if ($xoopsDB->getAffectedRows($sql)) {
    		// Notification doodah.
    		if ($event_showme == "1") {
	    		global $xoopsModule;
				$extratags = array();
				$extratags['AMEVENT_TITLE'] = $event_name;
				$extratags['AMEVENT_URL']   = XOOPS_URL . "/modules/" . $xoopsModule->getVar('dirname') . "/index.php?id=" . $newid;
				$notification_handler =& xoops_gethandler('notification');
				$notification_handler->triggerEvent('global', 0, 'new_eventuser', $extratags);
			}
			redirect_header("eventadd.php", 2, _AM_EVE_CONF_ADDED);
			//echo "entered";
		} else {
			redirect_header("eventadd.php", 2, _AM_EVE_CONF_FAILED);
			#echo "not entered";
		}
	
//admin_foot_text(); 
xoops_cp_footer();
} // end if



?>
