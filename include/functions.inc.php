<?php
// $Id: functions.inc.php,v 1.7 2006/03/31 23:53:51 andrew Exp $
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

//include_once(XOOPS_ROOT_PATH . "/modules/" . $xoopsModule->getVar('dirname') . '/include/config.inc.php');
include_once(XOOPS_ROOT_PATH . "/modules/amevents/include/config.inc.php");
//include_once(XOOPS_ROOT_PATH . "/modules/amevents/include/functions.inc.php");

################################################################################
# Format mysql datetime to required doodah
/*
function format_date($datetime = "2000-01-01 00:00:00", $format = "d/m/Y") {

// DateTime format:  YYYY-MM-DD hh:mm:ss
// 0000-00-00

    // If the event is only one day, and has no "end" date, then we want
    // to show a blank field.
    $dateonly = strval(substr($datetime, 0, 10));

    if($dateonly == "0000-00-00") {
        return (NULL);
    }
    else {

	    $yr=strval(substr($datetime, 0, 4));  
	    $mo=strval(substr($datetime, 5, 2));  
	    $da=strval(substr($datetime, 8, 2));  
	    $hr=strval(substr($datetime, 11, 2));  
	    $mi=strval(substr($datetime, 14, 2));  
	    $se=strval(substr($datetime, 17, 2));

	    $date_format = date($format, mktime ($hr,$mi,$se,$mo,$da,$yr)); //." GMT";
   
	    return ($date_format);
    }
	
} // end function
*/
################################################################################
#
function country($code = "00") {
global $xoopsDB;    
    
   	$sql = ("SELECT * FROM " .$xoopsDB->prefix('amevents_country') . " WHERE country_code = '$code' LIMIT 1");    
   	$result=$xoopsDB->query($sql);
        while($myrow = $xoopsDB->fetchArray($result)) {
		
            $country = $myrow['country_name'];
            
        } // end while
        
        if (!isset($country)) { $country = ""; }
        
    return ($country);
    
} // end function

################################################################################
# lists countries for submit form
function list_countries($code = "00") {
global $xoopsDB;    

   	$sql = ("SELECT * FROM " .$xoopsDB->prefix('amevents_country') . " ORDER BY country_name ASC");    
   	$result=$xoopsDB->query($sql);
   	
   	    $country  = "<select name=\"formdata[country]\"><br>";
   	    $country .= "<option value=\"00\">Please select</option>";
   	    $country .= "<option value=\"01\">Internet</option>";
   	
        while($myrow = $xoopsDB->fetchArray($result)) {
		    
            $country_code = $myrow['country_code'];
            $country_name = $myrow['country_name'];
            
            if ($code == $myrow['country_code']) { $selected = " selected"; }
            else { $selected = ""; }
            
            $country .= "<option value=\"" . $country_code . "\"" . $selected . ">" . $country_name . "</option>";
            
        } // end while
        
        $country .= "</select>";
        
    return ($country);
    
} // end function

################################################################################
# footer text for modulepages
function admin_foot_text() {
global $xoopsModule;
    
    echo "<span style=\"font-size: smaller;\">";
    echo "<br />";
    //echo $xoopsModule->getVar('name') . ", version " . round($xoopsModule->getVar('version')/100 , 2) . "<br />";
    echo $xoopsModule->getVar('name') . ", version " . _AMEVENTSVERSION . "<br />";
    echo "Updates are available from <a href=\"http://support.sirium.net\" target=\"_blank\">http://support.sirium.net</a>";
    echo "</span>";

       
} // end
 
################################################################################
# Functions - here for testing only, move to functions page when ready
# thingy
function number_events() {
global $xoopsDB, $currenttime;

$currenttime = amformattime(time(), "Y-m-d");
#$currenttime = "2006-03-04";

    // First, get total number of events
    $sql = ("SELECT COUNT(id) AS countall FROM " .$xoopsDB->prefix('amevents_events') . " WHERE event_validated=1");    
   	$result=$xoopsDB->query($sql);
   	
        while($myrow = $xoopsDB->fetchArray($result)) {
            $count['all'] =  $myrow['countall'];
            
        } // end while

        
    // get number of active events
    #$sql2 = ("SELECT COUNT(id) AS countactive FROM " .$xoopsDB->prefix('amevents_events') . " WHERE event_date_start >= NOW() AND event_validated=1");    
    $sql2 = ("SELECT COUNT(id) AS countactive FROM " .$xoopsDB->prefix('amevents_events') . " WHERE event_date_end >= DATE_FORMAT('$currenttime', '%Y-%c-%d %H:%i') AND event_validated=1 AND event_showme=1");
   	$result2=$xoopsDB->query($sql2);
   	
        while($myrow2 = $xoopsDB->fetchArray($result2)) {
            $count['active'] =  $myrow2['countactive'];
            
        } // end while          
        
        
    // get number of expired events
    $sql2 = ("SELECT COUNT(id) AS countexpired FROM " .$xoopsDB->prefix('amevents_events') . " WHERE event_date_end < NOW() AND event_validated=1");    
   	$result2=$xoopsDB->query($sql2);
   	
        while($myrow2 = $xoopsDB->fetchArray($result2)) {
            $count['expired'] =  $myrow2['countexpired'];
            
        } // end while        

    // get number of hidden events
	$sql2 = ("SELECT COUNT(id) AS counthidden FROM " .$xoopsDB->prefix('amevents_events') . " WHERE event_showme=0");    
   	$result2=$xoopsDB->query($sql2);
   	
        while($myrow2 = $xoopsDB->fetchArray($result2)) {
            $count['hidden'] =  $myrow2['counthidden'];
            
        } // end while  
                
        return($count);
        
} // end function

################################################################################
# Show how many (if any) user subbed events needing validation
function awaiting_validation() {
global $xoopsDB;

   	//$sql = ("SELECT COUNT(id) AS waiting FROM " .$xoopsDB->prefix('amevents_events') . " WHERE event_date_start > NOW() AND event_validated = 0");    
   	$sql = ("SELECT COUNT(id) AS waiting FROM " .$xoopsDB->prefix('amevents_events') . " WHERE event_validated = 0");
   	$result=$xoopsDB->query($sql);
   	
        while($myrow = $xoopsDB->fetchArray($result)) {
		    
            $waiting = $myrow['waiting'];
            
            if ($waiting > 0) {
	            $waiting = "<span style=\"color: red; font-weight: bold;\">" . $waiting . "</span>";
            }
            else {
	            $waiting = "<span style=\"color: black; font-weight: bold;\">" . $waiting . "</span>";
            }
            
    	} // end while
    
    	return($waiting);
	
} // end

################################################################################
# return a few details for notification, where needed.
function event_details($id=0) {
global $xoopsDB;
	
    //$sql = ("SELECT id FROM " .$xoopsDB->prefix('amevents_events') . " WHERE event_date_start >= NOW() AND event_validated=1");    
   	//$result=$xoopsDB->query($sql);
        //while($myrow = $xoopsDB->fetchArray($result)) {
            //$count['active'] =  $myrow['countactive'];
            
        //} // end while 	
	$result = $xoopsDB->query("SELECT id, event_name FROM ".$xoopsDB->prefix("amevents_events")." WHERE id=$id") or $eh->show("0013");
	list($id, $event_name) = $xoopsDB->fetchRow($result);
	 
		$details = array();
		$details['id']			= $id;
		$details['event_name']	= $event_name;
		
	return($details);
	
} // end

//
//----------------------------------------------------------------------------//
// This function is similar to formatTimestamp() in that it returns dates with
// time offsets applied, but gives you more control on the returned format.
// amformattime(unixtimestamp, "format") format = unix (default), or php strings
function amformattime($time = "", $format = "unix") {
global $xoopsUser, $xoopsConfig;	

	// $time = formatTimestamp( $time, "mysql", $useroffset );
	// $xoopsUser->timezone() - user set timezone
	// $xoopsConfig['default_TZ'] - XOOPS default

	if (is_object($xoopsUser)) {
		$timezone = $xoopsUser->timezone();
		if (isset($timezone)) {
			$timeoffset = $xoopsUser->timezone();
		} else {
			$timeoffset = $xoopsConfig['default_TZ'];
		} 
	} else {
		$timeoffset = $xoopsConfig['default_TZ'];
	}
	
	// Apply offsets - I could use formatTimestamp(), but I want more  control over
	// the format returned.
	$timestamp = intval($time) + (intval($timeoffset) - $xoopsConfig['server_TZ'])*3600;

	if ($format != "unix") {
		//$format = "Y-m-d";
		$timestamp = date ($format, $timestamp);
	}
	
	return ($timestamp);

} // end function

################################################################################
# Get form wysiwyg editor - based on function in news 1.4(?), and sampleform.inc.php.
# Width & height passed through are for 2.0.* version.
function amevents_getwysiwygform($caption, $name, $value = "", $width = "100%", $height = '400px', $formrows = "20", $formcols = "50", $config = "") {
global $xoopsModuleConfig;
	
	$editor = false;
	$x22=false;
	$xv=str_replace('XOOPS ','',XOOPS_VERSION);
	if(substr($xv,2,1)=='2') {
		$x22=true;
	}

	// options for the editor
	//required configs
	$editor_options['name']		= $name;
	$editor_options['value']	= $value;
	//optional configs
		$editor_options['rows']		= $formrows; // default value = 5
		$editor_options['cols']		= $formcols; // default value = 50
		$editor_options['width']	= $width; // default value = 100%
		$editor_options['height']	= $height; // default value = 400px	
	
	// Want to choose which editor config to use, depending on whether user or admin side.
	if ($config == "user") { $whichconfig = $xoopsModuleConfig['articleedituser']; }
	else { $whichconfig = $xoopsModuleConfig['articleeditadmin']; }
	
	switch($whichconfig){
	case "0": // xoops' default dhtml
		if(!$x22) {
				$editor = new XoopsFormDhtmlTextArea($caption, $name, $value, $editor_options['rows'], $editor_options['cols']);
			#}
		} else {
			$editor = new XoopsFormEditor($caption, "dhtml", $editor_options);
		}
		break;
	case "1": // spaw
		if(!$x22) {
			if (is_readable(XOOPS_ROOT_PATH . "/class/spaw/formspaw.php")) {
				include_once XOOPS_ROOT_PATH . "/class/spaw/formspaw.php";
				$editor = new XoopsFormSpaw($caption, $name, $value, $width, $height);
			} else {
				$editor = new XoopsFormDhtmlTextArea($caption, $name, $value, $editor_options['rows'], $editor_options['width']);
			}
		} else {
			$editor = new XoopsFormEditor($caption, "spaw", $editor_options);
		}
		break;
	case "2": // fck editor
		if(!$x22) {
			if (is_readable(XOOPS_ROOT_PATH . "/class/fckeditor/formfckeditor.php")) {
				include_once(XOOPS_ROOT_PATH . "/class/fckeditor/formfckeditor.php");
				$editor = new XoopsFormFckeditor($caption, $name, $value, $width, $height);
			} else {
				$editor = new XoopsFormDhtmlTextArea($caption, $name, $value, $editor_options['rows'], $editor_options['width']);
			}
		}
		else {
			$editor = new XoopsFormEditor($caption, "fckeditor", $editor_options);
		}
		break;
	case "3": // htmlarea
		if(!$x22) {
			if (is_readable(XOOPS_ROOT_PATH . "/class/htmlarea/formhtmlarea.php")) {
				include_once(XOOPS_ROOT_PATH . "/class/htmlarea/formhtmlarea.php");
				$editor = new XoopsFormHtmlarea($caption, $name, $value, $width, $height);
			} else {
				$editor = new XoopsFormDhtmlTextArea($caption, $name, $value, $editor_options['rows'], $editor_options['width']);
			}
		}
		else {
			$editor = new XoopsFormEditor($caption, "htmlarea", $editor_options);
		}
		break;
	case "4": // koivi (edkoivipath)
		if(!$x22) {
			if (is_readable(XOOPS_ROOT_PATH . "/class/koivi/formwysiwygtextarea.php")) {
				include_once(XOOPS_ROOT_PATH . "/class/koivi/formwysiwygtextarea.php");
				$editor = new XoopsFormWysiwygTextArea($caption, $name, $value, $width, $height);
			} else {
				$editor = new XoopsFormDhtmlTextArea($caption, $name, $value, $editor_options['rows'], $editor_options['width']);
			}
		}
		else {
			$editor = new XoopsFormEditor($caption, "koivi", $editor_options);
		}
		break;
	case "5": // xoops compact/textarea
		if(!$x22) {
			$editor = new XoopsFormTextArea($caption, $name, $value, $editor_options['rows'], $editor_options['width']);
		}
		else {
			$editor = new XoopsFormTextArea($caption, $name, $editor_options);
		}
		break;
	} // end switch
	
	return $editor;
	
} // end function

//
//----------------------------------------------------------------------------//
// Get sql for expiry
function amevent_expire() {
global $xoopsModuleConfig;
	
	$currenttime = amformattime(time(), "Y-m-d");
	
	if ($xoopsModuleConfig['noexpire'] != 1) {
		$sqlquery = "event_date_end >= DATE_FORMAT('$currenttime', '%Y-%c-%d %H:%i') AND";
	} else {
		$sqlquery = "";
	}
	
	return $sqlquery;
	
} // end function


//
//----------------------------------------------------------------------------//
// Admin header
function amevent_admin_header($holder = "", $breadcrumb = "") {
global $xoopsModule, $xoopsConfig;
?>
<style type="text/css">
#toptext { font-size: 11px; }
#listitem { display: inline; list-style: none; margin-left: 0px; }
#listitemurl { padding: 3px 0.5em; border: 1px solid #777788; margin-left: 3px; }
</style>

<table border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
  <tr>
    <td style="text-align: left;">
      <span id="toptext">
        <?php //echo $breadcrumbs; ?>
        <?php echo "<a href=\"". XOOPS_URL ."/modules/". $xoopsModule->getVar('dirname') ."/admin/index.php\">". _AM_EVE_NAVINDEX ."</a> &raquo; ". $breadcrumb .""?>
      </span>
    </td>
    <td style="text-align: right;">
      <span id="toptext"><strong><?php echo $xoopsModule->name(); ?> 
      <?php echo _AM_EVE_NAVINFMOD; ?></strong> 
      : 
      <a href="<?php echo XOOPS_URL."/modules/system/admin.php?fct=preferences&amp;op=showmod&amp;mod=".$xoopsModule->getVar('mid'); ?>"><?php echo _AM_EVE_NAVINFPREF; ?></a>
      :
      <a href="#"><?php echo _AM_EVE_NAVINFHELP; ?></a>
      :
      <a href="about.php"><?php echo _AM_EVE_NAVINFABOUT; ?></a>
      </span>
    </td>
  </tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
  <tr><td style="height: 10px;"></td></tr>
  <tr>
    <td>
      <ul style="padding-left: 0px; margin-left: 0px;">
		<li id="listitem"><a href="<?php echo XOOPS_URL; ?>/modules/<?php echo $xoopsModule->getVar('dirname'); ?>/admin/index.php" id="listitemurl"><?php echo _AM_EVE_NAVINDEX; ?></a></li>
		<li id="listitem"><a href="<?php echo XOOPS_URL; ?>/modules/<?php echo $xoopsModule->getVar('dirname'); ?>/admin/eventadd.php" id="listitemurl"><?php echo _AM_EVE_NAVEVEADD; ?></a></li>
		<li id="listitem"><a href="<?php echo XOOPS_URL; ?>/modules/<?php echo $xoopsModule->getVar('dirname'); ?>/admin/eventadmin.php" id="listitemurl"><?php echo _AM_EVE_NAVEVEEDDEL; ?></a></li>
		<!-- <li id="listitem"><a href="<?php echo XOOPS_URL; ?>/modules/<?php echo $xoopsModule->getVar('dirname'); ?>/admin/catadd.php" id="listitemurl"><?php //echo _AM_EVE_NAVCATADD; ?></a></li>-->
		<!-- <li id="listitem"><a href="<?php echo XOOPS_URL; ?>/modules/<?php echo $xoopsModule->getVar('dirname'); ?>/admin/cateddel.php" id="listitemurl"><?php //echo _AM_EVE_NAVCATEDDEL; ?></a></li> -->
		<li id="listitem"><a href="<?php echo XOOPS_URL; ?>/modules/<?php echo $xoopsModule->getVar('dirname'); ?>/admin/validate.php" id="listitemurl"><?php echo _AM_EVE_NAVVALIDATE; ?></a></li>
      </ul>
    </td>
  </tr>
</table>


<?
} //


?>