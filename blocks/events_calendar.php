<?php
// $Id: events_calendar.php,v 1.3 2006/03/31 23:52:54 andrew Exp $
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

#include_once(XOOPS_ROOT_PATH . "/modules/amevents/include/functions.inc.php");

function events_calendar_show($options) {
    global $xoopsDB, $xoopsModule, $xoopsUser;
    $myts =& MyTextSanitizer::getInstance();
    $block = array();

    // test stuff
    $mtime_start = microtime();
    
	// Do calendar layout stuff
	// thingy doodah function
	$eventsarr = init_events();

	//$dhtmlEvents = "";
	//$dhtmlcount = 0;
		
	$year = date("Y"); // four digit year
	$month = date("n"); // numerical month, no leading zeros
	
    $daysInMonth = date("t", mktime(0, 0, 0, $month, 1, $year)) ;
    
    // test
    //echo $year." ".$month." ".$daysInMonth;
    
    $monthtext = array(0 => '', 1 => _MB_EVENTCALJAN, 2 => _MB_EVENTCALFEB, 3 => _MB_EVENTCALMAR, 4 => _MB_EVENTCALAPR, 5 => _MB_EVENTCALMAY, 6 => _MB_EVENTCALJUN, 7 => _MB_EVENTCALJUL, 8 => _MB_EVENTCALAUG, 9 => _MB_EVENTCALSEP, 10 => _MB_EVENTCALOCT, 11 => _MB_EVENTCALNOV, 12 => _MB_EVENTCALDEC);
    
    	// start table html
    	$ameventcal['table'] = "<table border=\"0\" class=\"ameventscal\">";
    	// month & year row
    	$ameventcal['table'] .= "<tr>\n";
    	$ameventcal['table'] .= "<td colspan=\"7\" class=\"monthyeartext\">" . $monthtext["$month"] . " " . date("Y") . "</td>\n";
    	$ameventcal['table'] .= "</tr>\n";
    	// days row
        $ameventcal['table'] .= "<tr>\n";
        $ameventcal['table'] .= "<td class=\"daynames\">" . _MB_EVENTSUNDAY .    "</td>\n";
        $ameventcal['table'] .= "<td class=\"daynames\">" . _MB_EVENTMONDAY .    "</td>\n";
        $ameventcal['table'] .= "<td class=\"daynames\">" . _MB_EVENTTUESDAY .   "</td>\n";
        $ameventcal['table'] .= "<td class=\"daynames\">" . _MB_EVENTWEDNESDAY . "</td>\n";
        $ameventcal['table'] .= "<td class=\"daynames\">" . _MB_EVENTTHURSDAY .  "</td>\n";
        $ameventcal['table'] .= "<td class=\"daynames\">" . _MB_EVENTFRIDAY .    "</td>\n";
        $ameventcal['table'] .= "<td class=\"daynames\">" . _MB_EVENTSATURDAY .  "</td>\n";
        $ameventcal['table'] .= "</tr>\n";
    	
        // Get day of week.
    	$dayOfWeek = date("w", mktime(0, 0, 0, $month, 1, $year));
        
        // start date rows
        $ameventcal['table'] .= "<tr>\n";
        
        // We want to pad out the days of the week before current month starts
        // with empty cells.
		if ($dayOfWeek <> 0){
		   for ($i=0; $i < $dayOfWeek; $i++)
		   { $ameventcal['table'] .=  "<td class=\"blankday\">&nbsp;</td>\n"; }
		}
        
			//$dhtmlEvents = "";
			// main for loop 
			for ($dayDateOfMonth = 1; $dayDateOfMonth <= $daysInMonth; $dayDateOfMonth++) {

				// grab the info of the cell being generated.
				$dayOfMonth = date("j", mktime(0, 0, 0, $month, $dayDateOfMonth, $year));
				$dayOfWeek = date("w", mktime(0, 0, 0, $month, $dayDateOfMonth, $year));
				
				// Set new row if first day of week 
				if ($dayOfWeek == 0){
					$ameventcal['table'] .=  "<tr>\n"; 
				} // if
				
   				// Change class for highlight cell if dates match (if today).
				if ($dayOfMonth ==  date("j") &&  $month == date("n")) {
					$dayCellClass = "today";
				} else {
					$dayCellClass = "days";
				}
				

				# foreach????
				$matchDate = date("Y-m-d", mktime(0,0,0, $month, $dayDateOfMonth, $year));
				#echo $matchDate;

				//$dhtmlcount = 0;
				//$dhtmlEvents = "";
				for($i=0;$i < count($eventsarr);$i++) {
					//$dhtmlcount = 0;
					if (preg_match("/$matchDate/", $eventsarr[$i])) {
						//echo "match ".$eventsarr[$i]."<br />";
						

						
						$daythingy = split("-", $eventsarr[$i]);
						// Switch for DHTML pop ups
						if($options[0] == 1) {
							$dhtmlEvents .= get_events_linkdata($eventsarr[$i], $options);
							$ameventcal['table'] .=  "<td class=\"" . $dayCellClass . "\" onmouseover=\"document.getElementById('amevpopdiv" . $eventsarr[$i] . "').style.display='block'\";><a href=\"" . XOOPS_URL . "/modules/amevents/index.php?v=day&amp;y=" . $daythingy[0] . "&amp;m=" . $daythingy[1] . "&amp;d=" . $daythingy[2] . "\">" . $dayOfMonth . "</a></td>\n"; 
						} else {
							$dhtmlEvents .= "";
							$ameventcal['table'] .=  "<td class=\"" . $dayCellClass . "\"><a href=\"" . XOOPS_URL . "/modules/amevents/index.php?v=day&amp;y=" . $daythingy[0] . "&amp;m=" . $daythingy[1] . "&amp;d=" . $daythingy[2] . "\">" . $dayOfMonth . "</a></td>\n"; 
						}



						//$daythingy = split("-", $eventsarr[$i]);
						//$datethingy = $eventsarr[$i];
						//$ameventcal['table'] .=  "<td class=\"" . $dayCellClass . "\"><a href=\"" . XOOPS_URL . "/modules/amevents/index.php?v=day&y=" . $daythingy[0] . "&amp;m=" . $daythingy[1] . "&amp;d=" . $daythingy[2] . "\">" . $dayOfMonth . "</a></td>\n"; 
						#$ameventcal['table'] .=  "<td class=\"" . $dayCellClass . "\"><a href=\"" . XOOPS_URL . "/modules/amevents/index.php?v=day&y=" . $daythingy[0] . "&amp;m=" . $daythingy[1] . "&amp;d=" . $daythingy[2] . "\" onmouseover='document.getElementById(\"amevpopdiv" . $eventsarr[$i] . "\").style.visibility=\"visible;\"' onmouseout='document.getElementById(\"amevpopdiv" . $eventsarr[$i] . "\").style.visibility=\"hidden;\"'>" . $dayOfMonth . "</a></td>\n"; 
						// prefable, if not using onmouseout elsewhere
						#$ameventcal['table'] .=  "<td class=\"" . $dayCellClass . "\" onmouseover='document.getElementById(\"amevpopdiv" . $eventsarr[$i] . "\").style.visibility=\"visible;\"' onmouseout='document.getElementById(\"amevpopdiv" . $eventsarr[$i] . "\").style.visibility=\"hidden;\"'><a href=\"" . XOOPS_URL . "/modules/amevents/index.php?v=day&y=" . $daythingy[0] . "&amp;m=" . $daythingy[1] . "&amp;d=" . $daythingy[2] . "\">" . $dayOfMonth . "</a></td>\n"; 
						// works in FF only
						#$ameventcal['table'] .=  "<td class=\"" . $dayCellClass . "\" onmouseover='document.getElementById(\"amevpopdiv" . $eventsarr[$i] . "\").style.visibility=\"visible;\"';><a href=\"" . XOOPS_URL . "/modules/amevents/index.php?v=day&amp;y=" . $daythingy[0] . "&amp;m=" . $daythingy[1] . "&amp;d=" . $daythingy[2] . "\">" . $dayOfMonth . "</a></td>\n"; 
						// USE this one below (now in switch above)...
						//$ameventcal['table'] .=  "<td class=\"" . $dayCellClass . "\" onmouseover=\"document.getElementById('amevpopdiv" . $eventsarr[$i] . "').style.display='block'\";><a href=\"" . XOOPS_URL . "/modules/amevents/index.php?v=day&amp;y=" . $daythingy[0] . "&amp;m=" . $daythingy[1] . "&amp;d=" . $daythingy[2] . "\">" . $dayOfMonth . "</a></td>\n"; 
						
						
						//onmouseover='document.getElementById("aaa").style.visibility="visible;"';
						#$daythingy = split("-", $eventsarr[$i]);
						#echo $daythingy[2];
					} else {
						$eventlink = false;
						//$cell = 0;
					}
					//echo "match ".$ameventcal."<br />";
				}
				
				//echo "match ".$eventsarr[$i]."<br />";
				
				if($daythingy[2] != $dayDateOfMonth) {
					$ameventcal['table'] .=  "<td class=\"" . $dayCellClass . "\">" . $dayOfMonth . "</td>\n"; 
				}
   				
   				// end week row
				if ( $dayOfWeek == 6 ) {  
					$ameventcal['table'] .=  "</tr>\n"; 
				}
				
				// fill blank day cells (end of month)
				if ( $dayOfWeek < 6 && $dayDateOfMonth == $daysInMonth ) {
					for ( $i = $dayOfWeek ; $i < 6; $i++ ) {
						$ameventcal['table'] .=  "<td class=\"blankday\">&nbsp;</td>\n"; 
					}
				$ameventcal['table'] .=  "</tr>\n";
				
				} // end if
				
			} // end main for loop
    	
    	// end table html
		$ameventcal['table'] .= "</table>\n\n";
		
		// Return dhtml stuff
		$ameventcal['table'] .= $dhtmlEvents;
		
		// test
		#echo $ameventcal['table'];
		#echo $dhtmlEvents;
		
		$mtime_end = microtime();
		$duration = $mtime_end - $mtime_start;
		#echo "<pre>Seconds: ".round($duration, 4)."</pre>";
				
#exit;
		
	$block['ameventcal'][] = $ameventcal;
    return $block;
	
} // end function

//----------------------------------------------------------------------------//
// Find events dates and return in an Array to be matched.
function init_events() {
global 	$xoopsDB;

	$events_array = array();
	$eventdata = array();
	$events_data = array();
	
	// We want to set a date range so only events in current month are returned
    // to save processing too many dates.
    $sqlDateStart	= date("Y-m") . "-01 00:00:00";
    $sqlDateEnd		= date("Y-m") . "-" . date("t") . " 23:59:59";

	//DATE_FORMAT('$sqlDateStart', '%Y-%m-%d')
	//$sql = ("SELECT * FROM " .$xoopsDB->prefix('amevents_events') . " WHERE event_date_start=DATE_FORMAT('$sqlDate', '%Y-%c') ORDER BY event_date_start ASC");
	$sql = ("SELECT DISTINCT(DATE_FORMAT(event_date_start, '%Y-%m-%d')) AS event_date_start FROM " .$xoopsDB->prefix('amevents_events') . " WHERE event_date_start >= '$sqlDateStart' AND event_date_start <= '$sqlDateEnd' AND event_date_end >= NOW() AND event_validated='1' AND event_showme='1' ORDER BY event_date_start ASC");
	$result=$xoopsDB->query($sql);
		while($myrow = $xoopsDB->fetchArray($result)) {
			

			//$calevent['cal_id']	= $myrow['id'];
			//$eventdata = array();

			//$eventdata['event_id']				= $myrow['id'];
			$eventdata['event_date_start']		= $myrow['event_date_start'];

			#$eventdata = $myrow['id'] ."|". $myrow['event_date_start'];
			
			#echo $myrow['id'] . " - " . $myrow['event_date_start'] . " " . "<br />";
			
			#$events_data = array();
			#$events_data['event_date_start']	= $myrow['event_date_start'];
			$events_data	= $myrow['event_date_start'];
			
			array_push($events_array, $events_data);
			
		} // while	
		
		#array_push($events_array, $eventdata);
		
		#echo "<pre>";
		#print_r($events_array);
		#print_r($eventdata);
		#print_r($events_data);
		#echo "</pre>";
		
		return $events_array;
		
		
	
} // end function


//----------------------------------------------------------------------------//
// Find events dates and return in an Array to be matched.
function get_events_linkdata($date = "", $options) {
global 	$xoopsDB;
$myts =& MyTextSanitizer::getInstance();

	#$dhtml = "<div id=\"amevpopdiv" . $date . "\" class=\"ameventsmcdiv\" style=\"position: absolute; visibility: hidden;\">\n";
	//$dhtml = "<div id=\"amevpopdiv" . $date . "\" class=\"ameventsmcdiv\" style=\"position: absolute; display: none;\">\n";
	$dhtml = "<div id=\"amevpopdiv" . $date . "\" class=\"ameventsmcdiv\">\n";
	//$dhtml = "<div id=\"amevpopdiv" . $date . "\">\n<ul id=\"ampopul\">";

	#$dhtml .= "<div style=\"text-align: right;\"><a href=\"#\" onmousedown='document.getElementById(\"amevpopdiv" . $date . "\").style.visibility=\"hidden;\"' style=\"font-weight: normal; text-decoration: none;\">[x]</a></div>";
	$dhtml .= "<div style=\"text-align: right;\"><a href=\"#\" onmousedown=\"document.getElementById('amevpopdiv" . $date . "').style.display='none'\" style=\"font-weight: normal; text-decoration: none;\" title=\"" . _MB_EVENTCALCLS . "\">[x]</a></div>";
	$dhtml .= "<ul id=\"ampopul\">\n";
	
	//echo $date . "<br />";
	
	$sqldate = split("-", $date);
	$year = $sqldate[0];
	$month = $sqldate[1];
	$day = $sqldate[2];

	// mktime(hours, mins, secs, month, day, year));
	$sqlStart = date("Y-m-d 23:59:59", mktime(0, 0, 0, $month, $day-1, $year));
	$sqlEnd   = date("Y-m-d 00:00:00", mktime(0, 0, 0, $month, $day+1, $year));

	$sql = ("SELECT * FROM " .$xoopsDB->prefix('amevents_events') . " WHERE event_date_start > '$sqlStart' AND event_date_start < '$sqlEnd' AND event_validated='1' AND event_showme='1' ORDER BY event_date_start ASC");
	$result=$xoopsDB->query($sql);
		while($myrow = $xoopsDB->fetchArray($result)) {

			$eventdata['event_id']				= $myrow['id'];
			//$eventdata['event_date_start']		= $myrow['event_date_start'];
			$event_name = $myrow['event_name'];
			//$options[10] = "15"; // TEMPORARY - ADD TO PREFS!

				if (!XOOPS_USE_MULTIBYTES) {
					if (strlen($myrow['event_name']) >= $options[1]) {
						$event_name = $myts->makeTboxData4Show(substr($myrow['event_name'], 0, ($options[1] - 1))) . "[..]";
					} 
				}
			
			//$dhtml .=  "<li>" . $myrow['event_date_start'] . "</li>";
			$dhtml .=  "<li id=\"ampoplist\"><a href=\"" . XOOPS_URL . "/modules/amevents/index.php?id=" . $myrow['id'] . "\">" . $event_name . "</a></li>";			
			
			//echo  $myrow['event_date_start'] . "<br />";

		} // while

	$dhtml .= "</ul>\n</div>";
	
	//echo $dhtml;

	return $dhtml;

} // end function



//----------------------------------------------------------------------------//
//
function events_calendar_edit($options) {

	if($options[0] == "1") { $selectedy = " selected"; } 
		else { $selectedn = " selected"; }

	//$form  = "&nbsp;" . _MB_EVENT_SHOWPOPUS . "&nbsp;<input type=\"text\" name=\"options[]\" value=\"" . $options[0] . "\" size=\"5\" />&nbsp;<br />";
	$form = "&nbsp;" . _MB_EVENT_SHOWPOPUS;
	$form .=  " <select name=\"options[]\">";
	$form .= "<option value=\"1\"". $selectedy . ">yes</option>";
	$form .= "<option value=\"0\"". $selectedn . ">no</option>";
	$form .= "</select>";
	$form .= "<br />";
	$form .= "&nbsp;" . _MB_EVENT_SHOW .      "&nbsp;<input type=\"text\" name=\"options[]\" value=\"" . $options[1] . "\" size=\"5\" />&nbsp;" . _MB_EVENT_SHOWPOPTTL . "";

	return $form;    
}


?>