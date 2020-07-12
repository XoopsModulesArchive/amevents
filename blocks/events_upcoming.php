<?php
// $Id: events_upcoming.php,v 1.4 2006/03/31 23:52:54 andrew Exp $
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
// ------------------------------------------------------------------------- //
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

include_once(XOOPS_ROOT_PATH . "/modules/amevents/include/functions.inc.php");
//include ('../header.php');

function events_upcoming_show($options) {
    global $xoopsDB, $xoopsModule, $xoopsUser, $xoopsModuleConfig;
    $myts =& MyTextSanitizer::getInstance();
    $block = array();

    #$xoopsTpl->assign('event_all', _MB_EVENT_ALL);
	$currenttime = amformattime(time(), "Y-m-d");
	/*
	if ($xoopsModuleConfig['noexpire'] != 1) {
		$sqlquery = "event_date_end >= DATE_FORMAT('$currenttime', '%Y-%c-%d %H:%i') AND";
	} else {
		$sqlquery = "";
	}*/

	//$sqlquery = amevent_expire();
	
	//$sql = ("SELECT * FROM " .$xoopsDB->prefix('amevents_events') . " WHERE " . $sqlquery . " event_validated=1 AND event_showme=1 ORDER BY event_date_start ASC LIMIT $options[0]");
	//$sql = ("SELECT * FROM " .$xoopsDB->prefix('amevents_events') . " WHERE event_date_end >= DATE_FORMAT('$currenttime', '%Y-%c-%d %H:%i') AND event_validated=1 AND event_showme=1 ORDER BY event_date_start ASC LIMIT $options[0]");
	$sql = ("SELECT * FROM " .$xoopsDB->prefix('amevents_events') . " WHERE event_date_end >= DATE_FORMAT('$currenttime', '%Y-%c-%d %H:%i') AND event_validated=1 AND event_showme=1 ORDER BY event_date_start ASC LIMIT $options[0]");
    $result = $xoopsDB->query($sql);
        while ($myrow = $xoopsDB->fetchArray($result)) {

            $title = $myts->makeTboxData4Show($myrow['event_name']);
                if (!XOOPS_USE_MULTIBYTES) {
                    if (strlen($myrow['event_name']) >= $options[1]) {
                        $title = $myts->makeTboxData4Show(substr($myrow['event_name'], 0, ($options[1] - 1))) . "...";
                    } 
                 }
            $date = $myrow['event_date_start'];
            
            $events['id']     = $myrow['id'];
            $events['title']  = $title;
            #$events['event_date_start']  = format_date($date, "j M Y");
            $events['event_date_start']  = formatTimestamp(strtotime($date), "$options[2]");
            
            // language doodahs
            //$events['mb_event_all']  = _MB_EVENT_ALL;
            //$events['mb_event_submit']  = _MB_EVENT_SUBMIT;

        $block['upevents'][] = $events;
        } // end while 1
        
        $control = array();
        // show/hide submit event link depending on if user allowed to submit
        // and logged in.
		if(isset($xoopsModuleConfig['allowusersubmit']) && $xoopsModuleConfig['allowusersubmit'] != 1) {
			$control['showsublink'] = "0";
		} else {
			$control['showsublink'] = "1";
		}
		
		// language doodahs
		$block['mb_event_all']  = _MB_EVENT_ALL;
		$block['mb_event_submit']  = _MB_EVENT_SUBMIT;
		
		$block = array_merge($block, $control);
		
		//echo "<pre>";
		//print_r($block);
		//echo "</pre>";
		
    return $block;
	
}


function events_upcoming_edit($options) {

	$form  = "&nbsp;" . _MB_EVENT_SHOW . "&nbsp;<input type=\"text\"     name=\"options[]\" value=\"" . $options[0] . "\" size=\"5\" />&nbsp;" . _MB_EVENT_NUMBERS . "<br />";
	$form .= "&nbsp;" . _MB_EVENT_SHOW . "&nbsp;<input type=\"text\"     name=\"options[]\" value=\"" . $options[1] . "\" size=\"5\" />&nbsp;" . _MB_EVENT_CHARS . "<br />";
	$form .= "&nbsp;" . _MB_EVENT_UPDTFRMT . "&nbsp;<input type=\"text\" name=\"options[]\" value=\"" . $options[2] . "\" size=\"8\" />";

	return $form;    
}
/*
function events($date) {
global $xoopsDB;

    $sql = "SELECT * FROM ".$xoopsDB->prefix("amevents_events")." WHERE event_date_start='$date' ORDER BY event_name ASC";
    $result = $xoopsDB->query($sql);
        while ($myrow2 = $xoopsDB->fetchArray($result2)) {
            
            $title = $myts->makeTboxData4Show($myrow['event_name']);
                if (!XOOPS_USE_MULTIBYTES) {
                    if (strlen($myrow['event_name']) >= $options[1]) {
                        $title = $myts->makeTboxData4Show(substr($myrow['event_name'], 0, ($options[1] - 1))) . "...";
                    } 
                            }
                        
                    $events['title']  = $title;
                    $events['id']     = $myrow['id'];
        
        } // end while
    
} // end
*/


?>