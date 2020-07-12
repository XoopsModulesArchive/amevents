<?php
// $Id: submit.php,v 1.7 2006/03/08 22:16:28 andrew Exp $
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

include_once ('header.php');
#include ('include/config.php');
#include_once ('include/functions.inc.php');

#include_once (XOOPS_ROOT_PATH. "/include/xoopscodes.php");
include_once (XOOPS_ROOT_PATH. "/class/module.errorhandler.php");
include_once (XOOPS_ROOT_PATH. "/class/xoopsformloader.php");

$myts =& MyTextSanitizer::getInstance();
$eh = new ErrorHandler; // ErrorHandler object

//
//----------------------------------------------------------------------------//
// regged / logged in code
if($xoopsModuleConfig['loggedin'] == 1) {
	if (empty($xoopsUser)) {
		redirect_header(XOOPS_URL."/user.php", 2, _MD_EVENTLOGGEDIN);
		exit();
	}
}


//
//----------------------------------------------------------------------------//
// User/visitor submit disabled
if(isset($xoopsModuleConfig['allowusersubmit']) && $xoopsModuleConfig['allowusersubmit'] != 1) {
	redirect_header(XOOPS_URL."/modules/amevents/index.php", 2, _MD_EVENTNOTALLOWED);
	exit();
}


//
//----------------------------------------------------------------------------//
//
if (!isset($_POST['formdata'])) {
	// this page uses smarty template
	// this must be set before including main header.php
	$xoopsOption['template_main'] = 'event_submit.html';
	include XOOPS_ROOT_PATH.'/header.php';
	

	//$xoopsTpl->assign('eventsubmit_datedet',    _MD_EVENTSUBMIT_DATEDET);
	//$xoopsTpl->assign('eventsubmit_dateenddet', _MD_EVENTSUBMIT_DATEENDDET);
    //$xoopsTpl->assign('eventdatefor_year',      _MD_EVENTDATEFOR_YEAR);
    //$xoopsTpl->assign('eventdatefor_month',     _MD_EVENTDATEFOR_MONTH);
    //$xoopsTpl->assign('eventdatefor_day',       _MD_EVENTDATEFOR_DAY);
    $xoopsTpl->assign('form_title_alert',		_MD_EVEJSERRTITLE);
    $xoopsTpl->assign('form_category_alert',	_MD_EVEJSERRLOCATE);
	
	
    //$subevent = array();
    //$subevent['event_year']     = date("Y"); 
    //$subevent['event_month']    = date("m");
    //$subevent['event_day']      = date("d");
    //$subevent['country_select'] = list_countries();
    
    //$xoopsTpl->append_by_ref('subevents', $subevent);
    //unset($subevent);

// there seems to be some display bug with the calendar, putting in 
// output buffering and using display instead of render seems to
// get around it ("bug" not present in 2.2?)
ob_start();
// dynamic form
$submitform = new XoopsThemeForm(_MD_AMEVENT_FORMTTL, "ameventsform", xoops_getenv('PHP_SELF'), 'post');

// formdata[event_name]
$title = new XoopsFormText(_MD_AMEVENT_EVENTTTL, 'formdata[event_name]', 40, 255, '');
$submitform->addElement($title);
unset($title);


// start date XoopsFormDateTime - XoopsFormTextDateSelect
$startdate = new XoopsFormDateTime('', 'formdata[startdate]', 15, ''); //$startdate);
#$submitform->addElement($startdate);
#$submitform->addElement(new XoopsFormDateTime(_AM_STARTDATE, "start_date", 15, ''), TRUE);
#$submitform->addElement($startdate);
#unset($startdate);

//new XoopsFormLabel('caption', 'value');
$startdatecap = new XoopsFormLabel('', _MD_AMEVENT_DATEFORMAT);

$starttray = new XoopsFormElementTray(_MD_AMEVENT_STARTDATE,'<br />');
$starttray->addElement($startdate);
$starttray->addElement($startdatecap);
$submitform->addElement($starttray);
unset($startdate);
unset($startdatecap);



// _MD_AMEVENT_MULTIDAY
$multidaybox = new XoopsFormCheckBox(_MD_AMEVENT_MULTIDAY, 'formdata[multiday]', ''); // checked value here whether will be checked?
$multidaybox->addOption(1, _MD_AMEVENT_MULTIDAYCAP); // checked value here what will be sent in form?
$submitform->addElement($multidaybox);
unset($multidaybox);


// end date
$enddate = new XoopsFormDateTime('', 'formdata[enddate]', 15, '');
//$submitform->addElement($enddate);
//unset($enddate);
$enddatecap = new XoopsFormLabel('', _MD_AMEVENT_DATEFORMAT);

$endtray = new XoopsFormElementTray(_MD_AMEVENT_ENDDATE,'<br />');
$endtray->addElement($enddate);
$endtray->addElement($enddatecap);
$submitform->addElement($endtray);
unset($enddate);
unset($enddatecap);


// location
$countryselect = new XoopsFormSelect(_MD_AMEVENT_LOCATIONSUB, 'formdata[country]', '', '1', false);
$countryselect->addOption('0', _MD_AMEVENT_SELECTLOC);
	$sql = ("SELECT * FROM " .$xoopsDB->prefix('amevents_country') . " ORDER BY country_name ASC");
	$result=$xoopsDB->query($sql);
	while($myrow = $xoopsDB->fetchArray($result)) {
		$country_code	= $myrow['country_code'];
		$country_name	= $myrow['country_name'];
		
		$countryselect->addOption($country_code, $country_name);	
	} 
$submitform->addElement($countryselect);
unset($countryselect);

// URL
$eventurl = new XoopsFormText(_MD_AMEVENT_URLSUB, 'formdata[url]', 40, 255, 'http://');
$submitform->addElement($eventurl);
unset($eventurl);

// Details
#$default_ed = new XoopsFormDhtmlTextArea(_MD_AMEVENT_DETAILSSUB, 'formdata[description]', '', '20', '40');
$eventeditor = amevents_getwysiwygform(_MD_AMEVENT_DETAILSSUB, 'formdata[description]', '', '100%', '450px', '25', '38', 'user');	


// Loads XOOPS' default editor
#if ($xoopsModuleConfig['articleeditadmin'] == "0") {
#	$eventeditor = $default_ed;
#} // default

$submitform->addElement($eventeditor);
unset($eventeditor);
#unset($default_ed);
// end description

// Document formatting options.
// Allow html
$htmlbox = new XoopsFormCheckBox("", 'formdata[html]', 1); // checked value here whether will be checked?
$htmlbox->addOption(1, _MD_AMEVENT_OPTHTML); // checked value here what will be sent in form?

//
// Allow auto formatting (line break conversion).
$brbox = new XoopsFormCheckBox("", 'formdata[br]', 1); // checked value here whether will be checked?
$brbox->addOption(1, _MD_AMEVENT_OPTBR); // checked value here what will be sent in form?

//
// Enable/disable smilies.
$smileybox = new XoopsFormCheckBox("", 'formdata[smiley]', 1); // checked value here whether will be checked?
$smileybox->addOption(1, _MD_AMEVENT_OPTSMLY); // checked value here what will be sent in form?

//
// Enable/disable xoops codes.
$xcodebox = new XoopsFormCheckBox("", 'formdata[xcode]', 1); // checked value here whether will be checked?
$xcodebox->addOption(1, _MD_AMEVENT_OPTXCODE); // checked value here what will be sent in form?

//
// Enable/disable xoops images.
$imgcodebox = new XoopsFormCheckBox("", 'formdata[image]', 1); // checked value here whether will be checked?
$imgcodebox->addOption(1, _MD_AMEVENT_OPTXIMAGE); // checked value here what will be sent in form?

// Add display options to form.
$optionstray = new XoopsFormElementTray('','<br />');
$optionstray->addElement($htmlbox);
$optionstray->addElement($brbox);
$optionstray->addElement($smileybox);
$optionstray->addElement($xcodebox);
$optionstray->addElement($imgcodebox);
$submitform->addElement($optionstray);
unset($htmlbox);
unset($smileybox);
unset($xcodebox);
unset($imgcodebox);
unset($nobrbox);


//
// Submit
//
// new XoopsFormButton('Button Caption', 'button_id', 'Button-Text', 'submit'));
$button_sub = new XoopsFormButton('', 'but_save', _MD_AMEVENT_BUTTONSAVE, 'submit');
$button_sub->setExtra('onclick="return checkfields();"');
$button_can = new XoopsFormButton('', 'but_reset', _MD_AMEVENT_BUTTONRST, 'reset');
//$button_pre = new XoopsFormButton('', 'but_preview', _AM_ART_FRMBTTNPRVW, 'submit');
//$button_pre->setExtra('onclick="return checkfields();"');
//$button_pre->setExtra("preview='1'");

$tray = new XoopsFormElementTray('');
$tray->addElement($button_sub);
$tray->addElement($button_can);
//$tray->addElement($button_pre);
$submitform->addElement($tray);


#$theForm = $submitform->render();
 $submitform->display();
 $form = ob_get_contents();
ob_end_clean();
#echo $form;
$xoopsTpl->assign('submitform',	$form);
#$xoopsTpl->assign('submitform',	$submitform->render());
unset($submitform);    
        

} // end if



################################################################################
#
if (isset($_POST['formdata'])) {
	$formdata = $_POST['formdata'];

	//echo "<pre>";
	//print_r($formdata);
	//var_dump($formdata);
	//echo "</pre>";
	
	#echo "start ".$formdata['startdate']."<br >";
	
	


    // grab stuff
    $event_name			= $formdata['event_name'];
	$startdate		= $formdata['startdate'];
    $enddate			= $formdata['enddate'];
    #$year				= $formdata['year'];
    #$month				= $formdata['month'];
    #$day				= $formdata['day'];
    #$multiday			= $formdata['multiday'];
    #$yearend			= $formdata['yearend'];
    #$monthend			= $formdata['monthend'];
    #$dayend			= $formdata['dayend'];
    $event_country		= $formdata['country'];
    $event_url			= $formdata['url'];
    $event_description	= $formdata['description'];

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
    
    //$event_start = preg_replace('\/', '-', $event_start);
    #echo $event_start;
    
    // temporary code, will change later
    $datesstart = explode("-", $startdate['date']);
    	$month	= $datesstart['1'];
    	$day	= $datesstart['2'];
    	$year	= $datesstart['0'];
    	
    $datesend = explode("-", $enddate['date']);
    	$monthend	= $datesend['1'];
    	$dayend		= $datesend['2'];
    	$yearend	= $datesend['0'];
    //
    
    if (isset($formdata['multiday'])) { 
        #$multiday = $formdata['multiday']; 
        // automagically find duration of event
        $unixstart = mktime(0, 0, 0, $month, $day, $year);
        $unixend   = mktime(0, 0, 0, $monthend, $dayend, $yearend);
        $unixduration = $unixend - $unixstart;
        $event_duration = $unixduration / 60 / 60 / 24 + 1;
    } else {
        $event_duration = "1";
    }
    
    // get userid
    if (empty($xoopsUser)) {
		$event_uid = 0;
	} else {
		$event_uid = $xoopsUser->getVar('uid');
	}
    
	/*
    // format dates for entry into doodah
    $event_date_start = $year . "-" . $month . "-" . $day . " " . $startdate['time'];
    // prevent year being set to 2000 when no end date set
    if (isset($formdata['multiday'])) { 
    	$event_date_end = $yearend . "-" . $monthend . "-" . $dayend . " " . $enddate['time'];
    	//$event_date_end = $event_end . " 00:00:00";
	} else {
		$event_date_end = event_date_start;
		//$event_date_end = " ";
	}*/

	// format dates for entry into doodah
	$event_date_start = date("Y-m-d H:i:s", strtotime($startdate['date']) + $startdate['time']);
	// prevent year being set to 2000 when no end date set
	if (isset($formdata['multiday'])) { 
		$event_date_end = date("Y-m-d H:i:s", strtotime($enddate['date']) + $enddate['time']);
	} else {
		//$event_date_end = $event_date_start;
		// If not multiday event and/or only one, fake time so event expires at
		// end of day.
		$event_date_end = $startdate['date'] . " 23:59:59";
	}
	
	// autosubmit
	// Auto submit settings.
	if(isset($xoopsModuleConfig['autosubmit']) && $xoopsModuleConfig['autosubmit'] == 1) {
		$event_validated = 1;
		$event_showme = 1;
	} else {
		$event_validated = 0;
		$event_showme = 1;
	}
	
	
	$xoopsOption['template_main'] = 'event_submitted.html';
	include XOOPS_ROOT_PATH.'/header.php';

	#$xoopsTpl->assign('eventsubmit_datedet', _MD_EVENTSUBMIT_DATEDET);

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
	'$event_validated', 
	'$event_showme',
	'$event_uid',
	'$event_html',
	'$event_smiley',
	'$event_xcode',
	'$event_image',
	'$event_br'
	)";
	
    // FIX me - fix the entry failure message thingy
	$xoopsDB->query($sql) or $eh->show("0013");
    if ($newid == 0) {
        $newid = $xoopsDB->getInsertId();
        #$newid = mysql_insert_id();
    }
		##if ($xoopsDB->query($sql)) {
        if ($xoopsDB->getAffectedRows($sql)) {
	        // Notification doodah.
    		//include_once XOOPS_ROOT_PATH . '/include/notification_constants.php';

    		// we want different notifications and message for auto submit, etc.    		
	        if(isset($xoopsModuleConfig['autosubmit']) && $xoopsModuleConfig['autosubmit'] != 1) {
				$extra_tags = array();
				$extra_tags['AMEVENT_TITLE'] = $event_name;
				$extra_tags['AMEVENT_URL']   = XOOPS_URL . "/modules/" . $xoopsModule->getVar('dirname') . "/index.php?id=" . $newid;
				$notification_handler =& xoops_gethandler('notification');
				$notification_handler->triggerEvent('admin', 0, 'new_eventadmin', $extra_tags);
				// We don't want users notified if the event has yet to be validated.
				//$notification_handler->triggerEvent('global', 0, 'new_eventuser', $extra_tags);

				$xoopsTpl->assign('eventsubmitted_msg',	_MD_EVENTUSERENTERED);
				$xoopsTpl->assign('eventsubmitted_msgex',	_MD_EVENTUSERENTEREDEX);
			} 
			else {
				$extra_tags = array();
				$extra_tags['AMEVENT_TITLE'] = $event_name;
				$extra_tags['AMEVENT_URL']   = XOOPS_URL . "/modules/" . $xoopsModule->getVar('dirname') . "/index.php?id=" . $newid;
				$notification_handler =& xoops_gethandler('notification');
				$notification_handler->triggerEvent('admin', 0, 'new_eventadmin_auto', $extra_tags);
				$notification_handler->triggerEvent('global', 0, 'new_eventuser', $extra_tags);
				
				$xoopsTpl->assign('eventsubmitted_msg',	_MD_EVENTUSERENTERED);
				$xoopsTpl->assign('eventsubmitted_msgex',	_MD_EVENTUSERENTEREDEXA);
			}

		} else {
			#redirect_header("articles.php", 2, _MD_DBNOTUPDATED);
			#echo "not entered";
			$xoopsTpl->assign('eventsubmitted_msg',	_MD_EVENTUSERENTERFAIL);
			$xoopsTpl->assign('eventsubmitted_msgex',	_MD_EVENTUSERENTERFAILEX);
		}	
	
} // end if

/*
event
year
month
day
multiday
yearend
monthend
dayend
country
url
details
*/

include XOOPS_ROOT_PATH.'/footer.php';
?>