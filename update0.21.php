<?php
// $Id: update0.21.php,v 1.1 2006/03/08 22:16:49 andrew Exp $
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

include_once ('header.php');
#include ('include/config.php');
#include_once ('include/functions.inc.php');

#include_once (XOOPS_ROOT_PATH. "/include/xoopscodes.php");
include_once (XOOPS_ROOT_PATH. "/class/module.errorhandler.php");
include_once (XOOPS_ROOT_PATH. "/class/xoopsformloader.php");

$myts =& MyTextSanitizer::getInstance();
//$eh = new ErrorHandler; // ErrorHandler object

//----------------------------------------------------------------------------//
//
if(!isset($_REQUEST['op'])) {


?>	

<table border="0" align="center" width="500">
	<tr>
		<td>
			<p>This script updates the AM Events database so it will work with
			version 0.21 without having to remove and re-install AM Events, losing
			current events. This update is required for v0.21 to work correctly.</p>
			
			<form action="<?php echo $_SERVER['PHP_SELF']; ?>">
			<input type="hidden" name="op" value="1">
			
			
			
			<br />
			<input type="submit" value="update">
			
			</form>
			
			
		</td>
	</tr>
</table>

<?php	

} // end if

//----------------------------------------------------------------------------//
//
if (isset($_REQUEST['op']) AND $_REQUEST['op'] == "1") {
?>
	
<table border="0" align="center" width="500">
	<tr>
		<td>
		<p><strong>Updating database:</strong></p>
		
<?php
echo "Backing up amevents_events table... ";
//ALTER TABLE old RENAME new;
$result = $xoopsDB->queryF("ALTER TABLE " . $xoopsDB->prefix('amevents_events'). " RENAME " .$xoopsDB->prefix('amevents_events_bak019'). "");
	if ($result) {
		echo "<span style=\"color: green;\">OK: amevents_events_bak019 created.</span><br />\n";
	} else {
		echo "<span style=\"color: red;\">Failed to create backup! Stopping...</span><br />\n";	
		echo "MySQL error " . mysql_errno() . ": " . mysql_error();
		exit;
	}

// Create new amevents_events table
echo "Creating new amevents_events table... ";

$result = $xoopsDB->queryF("CREATE TABLE `".$xoopsDB->prefix('amevents_events')."` (
	`id` int(10) unsigned NOT NULL auto_increment,
	`event_name` varchar(100) default NULL,
	`event_date_start` datetime NOT NULL default '0000-00-00 00:00:00',
	`event_date_end` datetime NOT NULL default '0000-00-00 00:00:00',
	`event_url` varchar(200) default NULL,
	`event_description` mediumtext,
	`event_duration` int(10) unsigned default NULL,
	`event_country` varchar(5) NOT NULL default '00',
	`event_validated` tinyint(5) unsigned NOT NULL default '0',
	`event_showme` tinyint(5) unsigned NOT NULL default '1',
	`uid` int(10) unsigned NOT NULL default '0',
	`event_html` enum('0','1') NOT NULL default '0',
	`event_smiley` enum('0','1') NOT NULL default '1',
	`event_xcode` enum('0','1') NOT NULL default '1',
	`event_image` enum('0','1') NOT NULL default '1',
	`event_br` enum('0','1') NOT NULL default '1',	
	PRIMARY KEY  (`id`) ) TYPE=MyISAM ");

	if ($result) {
		echo "<span style=\"color: green;\">OK</span><br />\n";
		/*
    	echo "Copying table contents... ";
		$resultcopy = $xoopsDB->queryF("INSERT INTO ".$xoopsDB->prefix("articles_main_bak025")." SELECT * FROM ".$xoopsDB->prefix("articles_main"));
		if ($resultcopy) {
			echo "<span style=\"color: green;\">OK</span><br />\n";
			//echo "<form method=\"get\" action=\"$page\">\n<input type=\"hidden\" name=\"stage\" value=\"3\" />\n<input type=\"submit\" value=\" Go ahead and update \" /></form>";
		} else {
			echo "<span style=\"color: red;\">Failed!</span><br />\n";	
			echo "MySQL error " . mysql_errno() . ": " . mysql_error();
			exit;
		}*/
	} else {
		echo "<span style=\"color: red;\">Failed!</span><br />\n";
		echo "MySQL error " . mysql_errno() . ": " . mysql_error();	
		exit;
	}
	
// Copy and modify event data
echo "Copying events over to new table...<br />";


	$sql = ("SELECT * FROM " .$xoopsDB->prefix('amevents_events_bak019') . " ");
	$result=$xoopsDB->query($sql);
    
		// add no results thingy
		while($myrow = $xoopsDB->fetchArray($result)) {
			
			echo "Copying event ID " . $myrow['id'] . ": ";
			
			$id					= $myrow['id'];
			$event_name			= textthingy($myrow['event_name']);
			$event_date_start	= $myrow['event_date_start'];
			$event_date_end		= $myrow['event_date_end'];
			$event_url			= $myrow['event_url'];
			$event_description	= textthingy($myrow['event_description']);
			$event_duration		= $myrow['event_duration'];
			$event_country		= textthingy($myrow['event_country']);
			$event_validated	= $myrow['event_validated'];
			$event_showme		= $myrow['event_showme'];
			$event_uid			= $myrow['event_uid'];
			$event_html			= "0";
			$event_smiley		= "1";
			$event_xcode		= "1";
			$event_image		= "1";
			$event_br			= "1";
			
			
			// insert data
			//$newid = $xoopsDB->genId($xoopsDB->prefix("amevents_events")."_id_seq");
			//$result = $xoopsDB->queryF("CREATE TABLE `".$xoopsDB->prefix('articles_main_bak025')."` (
			//$sql2 = "INSERT INTO '".$xoopsDB->prefix("amevents_events")."' VALUES (
			$result2 = $xoopsDB->queryF("INSERT INTO `".$xoopsDB->prefix('amevents_events')."` VALUES (
			'$id',
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
			)");
			
			//$xoopsDB->queryF($sql2);// or $eh->show("0013");
			//if ($xoopsDB->getAffectedRows($sql2)) {
			//if ($xoopsDB->query($sql2)) {
			if ($result2) {
				echo "<span style=\"color: green;\">OK</span><br />\n";
			} else {
				echo "<span style=\"color: red;\">Failed!</span><br />\n";
				echo "MySQL error " . mysql_errno() . ": " . mysql_error();
				exit;
			}

		} // end while	
	
		
?>
<!--
Reference:

CREATE TABLE `amevents_events` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `event_name` varchar(100) default NULL,
  `event_date_start` date NOT NULL default '0000-00-00',
  `event_date_end` date NOT NULL default '0000-00-00',
  `event_url` varchar(200) default NULL,
  `event_description` text,
  `event_duration` int(10) unsigned default NULL,
  `event_country` varchar(5) NOT NULL default '00',
  `event_validated` tinyint(5) unsigned NOT NULL default '0',
  `event_showme` tinyint(5) unsigned NOT NULL default '1',
  `event_uid` int(10) default NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

CREATE TABLE `amevents_events` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `event_name` varchar(100) default NULL,
  `event_date_start` datetime NOT NULL default '0000-00-00 00:00:00',
  `event_date_end` datetime NOT NULL default '0000-00-00 00:00:00',
  `event_url` varchar(200) default NULL,
  `event_description` mediumtext,
  `event_duration` int(10) unsigned default NULL,
  `event_country` varchar(5) NOT NULL default '00',
  `event_validated` tinyint(5) unsigned NOT NULL default '0',
  `event_showme` tinyint(5) unsigned NOT NULL default '1',
  `uid` int(10) unsigned NOT NULL default '0',
  `event_html` enum('0','1') NOT NULL default '0',
  `event_smiley` enum('0','1') NOT NULL default '1',
  `event_xcode` enum('0','1') NOT NULL default '1',
  `event_image` enum('0','1') NOT NULL default '1',
  `event_br` enum('0','1') NOT NULL default '1',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;	
-->
		</td>
	</tr>
</table>
		
<?php	
}

// for some reason, addslashes doesn't add slashes - possibly because it's not
// coming from a form, or something.
function textthingy($text = "") {

	$text = preg_replace("/\"/", "\\\"", $text);
	$text = preg_replace("/'/", "\'", $text);
	
	return $text;	
	
}




?>