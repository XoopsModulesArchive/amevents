<?php
// $Id: search.inc.php,v 1.1 2005/01/26 22:18:47 andrew Exp $
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

function amevents_search($queryarray, $andor, $limit, $offset, $userid){
	global $xoopsDB;
	$sql = "SELECT id, event_name, event_description, UNIX_TIMESTAMP(event_date_start) AS date FROM ".$xoopsDB->prefix("amevents_events")." WHERE event_validated=1 AND event_showme=1";
	if ( $userid != 0 ) {
		$sql .= " AND uid=".$userid." ";
	}
	// because count() returns 1 even if a supplied variable
	// is not an array, we must check if $querryarray is really an array
	if ( is_array($queryarray) && $count = count($queryarray) ) {
		$sql .= " AND ((event_name LIKE '%$queryarray[0]%' OR event_description LIKE '%$queryarray[0]%')";
		for($i=1;$i<$count;$i++){
			$sql .= " $andor ";
			$sql .= "(event_name LIKE '%$queryarray[$i]%' OR event_description LIKE '%$queryarray[$i]%')";
		}
		$sql .= ") ";
	}
	$sql .= "ORDER BY event_date_start DESC";
	$result = $xoopsDB->query($sql,$limit,$offset);
	$ret = array();
	$i = 0;
 	while($myrow = $xoopsDB->fetchArray($result)){
		$ret[$i]['image'] = "images/forum.gif";
		$ret[$i]['link'] = "index.php?id=" . $myrow['id'] ."";
		$ret[$i]['title'] = $myrow['event_name'];
		$ret[$i]['time'] = $myrow['date'];
		//$ret[$i]['uid'] = $myrow['submitter'];
		$i++;
	}
	return $ret;
}
?>
