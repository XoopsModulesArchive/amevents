<?php
// $Id: index.php,v 1.10 2006/03/31 23:51:13 andrew Exp $
//  ------------------------------------------------------------------------ //
//  Author: Andrew Mills                                                     //
//  Email:  ajmills@the-crescent.net                                         //
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

include ('header.php');
#include ('include/config.php');
#include_once ('include/functions.inc.php');
$myts =& MyTextSanitizer::getInstance();

//if (isset($_GET['cat_id'])) { $cat_id = $_POST['cat_id']; }

################################################################################
#
if (!isset($_GET['id']) && !isset($_GET['v'])) {
	// this page uses smarty template
	// this must be set before including main header.php
	$xoopsOption['template_main'] = 'event_index.html';
	include XOOPS_ROOT_PATH.'/header.php';

	$xoopsTpl->assign('eventlist_caption',    _MD_AMEVENT_CAPLIST);
	$xoopsTpl->assign('eventcol_caption',     _MD_AMEVENT_CAPEVENT);
	$xoopsTpl->assign('datestartcol_caption', _MD_AMEVENT_CAPDATESTRT);
	$xoopsTpl->assign('dateendcol_caption',   _MD_AMEVENT_CAPDATEEND);
	$xoopsTpl->assign('datedurcol_caption',   _MD_AMEVENT_CAPDURATION);

	$class = "even";
	
	//if set to expire at end of day:
	//echo "user tz: " . $xoopsUser->timezone() . "<br />";
	//echo "default tz: " . $xoopsConfig['default_TZ'];

	$currenttime = amformattime(time(), "Y-m-d H:i");
	
	if ($xoopsModuleConfig['noexpire'] != 1) {
		$sqlquery = "event_date_end >= DATE_FORMAT('$currenttime', '%Y-%c-%d %H:%i') AND";
	} else {
		$sqlquery = "";
	}
	
	//$sql = ("SELECT * FROM " .$xoopsDB->prefix('amevents_events') . " WHERE event_date_end >= DATE_FORMAT('$currenttime', '%Y-%c-%d %H:%i') AND event_validated=1 AND event_showme=1 ORDER BY event_date_start ASC");
	$sql = ("SELECT * FROM " .$xoopsDB->prefix('amevents_events') . " WHERE " . $sqlquery . " event_validated=1 AND event_showme=1 ORDER BY event_date_start ASC");
    $result=$xoopsDB->query($sql);

		if ($xoopsDB->getRowsNum($result) > 0) {
			while($myrow = $xoopsDB->fetchArray($result)) {

				$amevent = array();
				$amevent['event_id']         = $myrow['id'];
				$amevent['event_name']       = $myts->displayTarea($myrow['event_name'], 0, 0, 1, 0, 0);
				$amevent['event_date_start']	= formatTimestamp(strtotime($myrow['event_date_start']), $xoopsModuleConfig['datefrmt']);
            
				// We don't want to show anything if there's no end date
				if($myrow['event_date_end'] != "0000-00-00 00:00:00") {
					$amevent['event_date_end']		= formatTimestamp(strtotime($myrow['event_date_end']), $xoopsModuleConfig['datefrmt']);
				}
				#$amevent['event_date_start'] = format_date($myrow['event_date_start'], $xoopsModuleConfig['datefrmt']);
				#$amevent['event_date_end']   = format_date($myrow['event_date_end'], $xoopsModuleConfig['datefrmt']);
				$amevent['event_duration']   = $myrow['event_duration'];
				$amevent['event_country']    = $myrow['event_country'];
            
				if($class == "even") { $class = "odd"; }
				else { $class = "even"; }
				$amevent['event_class'] = $class;

				if (!file_exists(XOOPS_ROOT_PATH ."/modules/amevents/images/flags/". $amevent['event_country'].".gif")) {
					//echo XOOPS_ROOT_PATH . "/modules/amevents/images/flags/" . $amevent['event_country']. ".gif<br>";
					$amevent['event_country'] = "00";
				}
            
				$xoopsTpl->append_by_ref('amevents', $amevent);
				unset($amevent);
			} // end while
		} else {
			$xoopsTpl->assign('noevents',		"1");
			$xoopsTpl->assign('noeventsmsg',	_MD_AMEVENT_NOEVENTMSG);
		}
		
		
} // end if



################################################################################
#
if (isset($_GET['id'])) {
	$id = $_GET['id'];
	//echo $cat_id;

	$xoopsOption['template_main'] = 'event_item.html';
	include XOOPS_ROOT_PATH.'/header.php';

	$xoopsTpl->assign('posted',		_MD_AMEVENT_POSTED);
	$xoopsTpl->assign('postedby',	_MD_AMEVENT_POSTEDBY);
	$xoopsTpl->assign('postedon',	_MD_AMEVENT_POSTEDON);
    $xoopsTpl->assign('eventtitle_caption',		_MD_AMEVENT_TITLE);
    $xoopsTpl->assign('eventstart_caption',		_MD_AMEVENT_DATESTART);
    $xoopsTpl->assign('eventend_caption',		_MD_AMEVENT_DATEEND);
    $xoopsTpl->assign('eventdur_caption',		_MD_AMEVENT_DURATION);
    $xoopsTpl->assign('eventloc_caption',		_MD_AMEVENT_LOCATION);
    $xoopsTpl->assign('eventurl_caption',		_MD_AMEVENT_URL);
    $xoopsTpl->assign('eventdetails_caption',	_MD_AMEVENT_DETAILS);
    $xoopsTpl->assign('index_link_text',	_MD_AMEVENT_INDEXLINKTXT);
	$xoopsTpl->assign('print_art_link',		_MD_AMEVENT_PRINTVERSION);
	$xoopsTpl->assign('adminurledit',		_MD_AMEVENT_ADMINURLED);
	$xoopsTpl->assign('adminurldel',		_MD_AMEVENT_ADMINURLDEL);
	$xoopsTpl->assign('adminurlprint',		_MD_AMEVENT_EML2FRIEND);
	

	$sql = ("SELECT * FROM " .$xoopsDB->prefix('amevents_events') . " WHERE id='$id' AND event_validated=1 AND event_showme=1");
	#$sql = ("SELECT * FROM " .$xoopsDB->prefix('amevents_events') . " ORDER BY event_date_start ASC");
    $result=$xoopsDB->query($sql);
        while($myrow = $xoopsDB->fetchArray($result)) {
		
            $amevent = array();
            $amevent['event_id']          = $myrow['id'];
            $amevent['event_name']        = $myts->displayTarea($myrow['event_name'], 0, 0, 1, 0, 0);
            $amevent['event_date_start']	= formatTimestamp(strtotime($myrow['event_date_start']), $xoopsModuleConfig['datefrmtmain']);
            if($myrow['event_date_end'] != "0000-00-00 00:00:00") {
            	$amevent['event_date_end']		= formatTimestamp(strtotime($myrow['event_date_end']), $xoopsModuleConfig['datefrmtmain']);
        	}
            #$amevent['event_date_start']  = format_date($myrow['event_date_start'], $xoopsModuleConfig['datefrmtmain']);
            #$amevent['event_date_end']    = format_date($myrow['event_date_end'], $xoopsModuleConfig['datefrmtmain']);
            $amevent['event_duration']    = $myrow['event_duration'];
            $amevent['event_description'] = $myts->displayTarea($myrow['event_description'], $myrow['event_html'], $myrow['event_smiley'], $myrow['event_xcode'], $myrow['event_image'], $myrow['event_br']);
            $amevent['event_url']         = $myrow['event_url'];
            $amevent['event_country']     = country($myrow['event_country']);
            
            //grab user info - event_uid
			$amevent['event_uid']		= $myrow['uid'];
			$amevent['event_uname']		= XoopsUser::getUnameFromId($myrow['uid'],0); // later add realname option - http://www.xoops.org/misc/api/kernel/XoopsUser.html#getUnameFromId
            
            // add custom title to page title - "<{$xoops_pagetitle}>" - titleaspagetitle
			if ($xoopsModuleConfig['titleaspagetitle'] == 1) {
				$xoopsTpl->assign('xoops_pagetitle', $xoopsModule->getVar('name').' - '.$amevent['event_name']); // module name - article title
			}
			if ($xoopsModuleConfig['titleaspagetitle'] == 2) {
				$xoopsTpl->assign('xoops_pagetitle', $amevent['event_name'].' - '.$xoopsModule->getVar('name')); // article title -  module name
			}
			
			// admin link
			if ($xoopsUser AND $xoopsUser->isAdmin($xoopsModule->mid())) {
	   			$xoopsTpl->assign('isadmin', "1");
			}
			
			// grab module dir name
			$xoopsTpl->assign('mod_dir', $xoopsModule->getVar('dirname'));
			
			// see if printable page is set
			$xoopsTpl->assign('printversion', $xoopsModuleConfig['allowprintversion']);
			
			// see if e-mail to friend feature is set
			$xoopsTpl->assign('emailtofriend', $xoopsModuleConfig['allowemailtofriend']);
            
		$xoopsTpl->append_by_ref('amevents', $amevent);
		unset($amevent);
        } // end while

} // end if

################################################################################
#
if (isset($_GET['v'])) {

if (isset($_GET['y'])) { $year	= $_GET['y']; }
if (isset($_GET['m'])) { $month	= $_GET['m']; }
if (isset($_GET['d'])) { $day	= $_GET['d']; }

$sqldate = $year . "-" . $month . "-" . $day;
//echo $sqldate;
	
	// this page uses smarty template
	// this must be set before including main header.php
	$xoopsOption['template_main'] = 'event_indexday.html';
	include XOOPS_ROOT_PATH.'/header.php';

	$xoopsTpl->assign('index_link_text', _MD_AMEVENT_INDEXLINKTXT);
	
	$xoopsTpl->assign('eventlist_caption',    _MD_AMEVENT_CAPLIST);
	$xoopsTpl->assign('eventcol_caption',     _MD_AMEVENT_CAPEVENT);
	$xoopsTpl->assign('datestartcol_caption', _MD_AMEVENT_CAPDATESTRT);
	$xoopsTpl->assign('dateendcol_caption',   _MD_AMEVENT_CAPDATEEND);
	$xoopsTpl->assign('datedurcol_caption',   _MD_AMEVENT_CAPDURATION);
	
	$class = "even";
	
	#$todaysdate = date("Y-m-d");
	
	// mktime(hours, mins, secs, month, day, year));
	$sqlStart = date("Y-m-d 23:59:59", mktime(0, 0, 0, $month, $day-1, $year));
	$sqlEnd   = date("Y-m-d 00:00:00", mktime(0, 0, 0, $month, $day+1, $year));
	
	//echo "start: " . $sqlStart .", End: " . $sqlEnd;
		
	#$sql = ("SELECT * FROM " .$xoopsDB->prefix('amevents_events') . " WHERE event_date_start >= $todaysdate AND event_validated=1 AND event_showme=1 ORDER BY event_date_start ASC");
	#$sql = ("SELECT * FROM " .$xoopsDB->prefix('amevents_events') . " WHERE event_date_start = '$sqldate' AND event_validated=1 AND event_showme=1 ORDER BY event_date_start ASC");
	#$sql = ("SELECT * FROM " .$xoopsDB->prefix('amevents_events') . " WHERE event_date_start = DATE_FORMAT('$sqldate', '%Y-%c-%d') AND event_validated='1' AND event_showme='1' ORDER BY event_date_start ASC");
	$sql = ("SELECT * FROM " .$xoopsDB->prefix('amevents_events') . " WHERE event_date_start > '$sqlStart' AND event_date_start < '$sqlEnd' AND event_validated='1' AND event_showme='1' ORDER BY event_date_start ASC");
    $result=$xoopsDB->query($sql);
        while($myrow = $xoopsDB->fetchArray($result)) {
		
            $amevent = array();
            $amevent['event_id']         = $myrow['id'];
            $amevent['event_name']       = $myts->displayTarea($myrow['event_name'], 0, 0, 1, 0, 0);
            $amevent['event_date_start']	= formatTimestamp(strtotime($myrow['event_date_start']), $xoopsModuleConfig['datefrmt']);
            if($myrow['event_date_end'] != "0000-00-00 00:00:00") {
            	$amevent['event_date_end']		= formatTimestamp(strtotime($myrow['event_date_end']), $xoopsModuleConfig['datefrmt']);
        	}
            #$amevent['event_date_start'] = format_date($myrow['event_date_start'], $xoopsModuleConfig['datefrmt']);
            #$amevent['event_date_end']   = format_date($myrow['event_date_end'], $xoopsModuleConfig['datefrmt']);
            $amevent['event_duration']   = $myrow['event_duration'];
            $amevent['event_country']    = $myrow['event_country'];
            
            if($class == "even") { $class = "odd"; }
            else { $class = "even"; }
            $amevent['event_class'] = $class;
            
            if (!file_exists(XOOPS_ROOT_PATH ."/modules/amevents/images/flags/". $amevent['event_country'].".gif")) {
				//echo XOOPS_ROOT_PATH . "/modules/amevents/images/flags/" . $amevent['event_country']. ".gif<br>";
				$amevent['event_country'] = "00";
			}

		$xoopsTpl->append_by_ref('amevents', $amevent);
		unset($amevent);
        } // end while
        #unset($category);
} // end if

################################################################################
#


###########
include XOOPS_ROOT_PATH.'/include/comment_view.php';
include XOOPS_ROOT_PATH.'/footer.php';
?>