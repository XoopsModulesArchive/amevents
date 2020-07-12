<?php
// $Id: print.php,v 1.6 2006/03/08 22:16:28 andrew Exp $
//  ------------------------------------------------------------------------ //
//  Author: Andrew Mills                                                     //
//  Email:  ajmills@sirium.net                                         //
//	About:  This file is part of the Articles module for Xoops v2.           //
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
#include_once ('include/functions.inc.php');
$myts =& MyTextSanitizer::getInstance();

if (isset($_GET['id'])) {
		$id = $_GET['id'];
	

//
//----------------------------------------------------------------------------//
// check if print version feature is allowed.
if ($xoopsModuleConfig['allowprintversion'] != 1) {
	redirect_header(XOOPS_URL ."/modules/". $xoopsModule->getVar('dirname') ."/index.php", 2, _MD_NOACCESSHERE);
	exit();
}

//
//----------------------------------------------------------------------------//
//		
		
// put html here
html_header(); 

?>

<table class="maintbl">
  <tr>
    <td>
    

<?php
	$sql = ("SELECT * FROM " . $xoopsDB->prefix("amevents_events") . " WHERE id=" . $id . " AND event_validated=1 AND event_showme=1 LIMIT 1");
	$result=$xoopsDB->query($sql);
	while($myrow = $xoopsDB->fetchArray($result)) {
    
		$amevent_id				= $myrow['id'];
		$amevent_title			= $myts->displayTarea($myrow['event_name'], 0, 0, 1 ,0 ,0);
		$amevent_description	= $myts->displayTarea($myrow['event_description'], $myrow['event_html'], $myrow['event_smiley'], $myrow['event_xcode'], $myrow['event_image'], $myrow['event_br']);
        
		$event_country	= country($myrow['event_country']);
		$event_url		= $myrow['event_url'];

		#$event_date_start	= format_date($myrow['event_date_start'], $xoopsModuleConfig['datefrmtmain']);
		#$event_date_end		= format_date($myrow['event_date_end'], $xoopsModuleConfig['datefrmtmain']);
		$event_date_start	= formatTimestamp(strtotime($myrow['event_date_start']), $xoopsModuleConfig['datefrmtmain']);
		if($myrow['event_date_end'] != "0000-00-00 00:00:00") {
            	$event_date_end	= formatTimestamp(strtotime($myrow['event_date_end']), $xoopsModuleConfig['datefrmtmain']);
        }
		$event_duration		= $myrow['event_duration'];


?>	

<table border="0">
  <tr>
    <td><strong><?php echo _MD_AMEVENT_PRTTITLE; ?></strong> &nbsp;</td>
    <td><?php echo $amevent_title; ?></td>
  </tr>
  <tr>
    <td><strong><?php echo _MD_AMEVENT_PRTDATESTART; ?></strong> &nbsp;</td>
    <td><?php echo $event_date_start; ?></td>
  </tr>
  <tr>
    <td><strong><?php echo _MD_AMEVENT_PRTDATEEND; ?></strong> &nbsp;</td>
    <td><?php echo $event_date_end; ?></td>
  </tr>
  <tr>
    <td valign="top"><strong><?php echo _MD_AMEVENT_PRTDURATION; ?></strong> &nbsp;</td>
    <td><?php echo $event_duration; ?> <?php echo _MD_AMEVENT_PRTDURATIONDAYS; ?></td>
  </tr>
  <tr>
    <td valign="top"><strong><?php echo _MD_AMEVENT_PRTLOCATION; ?></strong> &nbsp;</td>
    <td><?php echo $event_country; ?></td>
  </tr>
  <tr>
    <td><strong><?php echo _MD_AMEVENT_PRTURL; ?></strong></td>
    <td><?php echo $event_url; ?></td>
  </tr>
</table>
<table>
  <tr><td height="5"></td></tr>
  <tr>
    <td>
      <strong><?php echo _MD_AMEVENT_PRTDETAILS; ?></strong><br />
      <?php echo $amevent_description; ?>
    </td>
  </tr>
  <tr><td height="5"></td></tr>
</table>
<table>
  <tr>
    <td colspan="2"><strong><?php echo _MD_AMEVENT_PRTPUBLISHED; ?></strong></td>
  </tr>
  <tr>
    <td width="100"><strong><?php echo _MD_AMEVENT_PRTSITETTL; ?></strong></td>
    <td><?php echo $xoopsConfig['sitename']; ?></td>
  </tr>
  <tr>
    <td><strong><?php echo _MD_AMEVENT_PRTSITEURL; ?></strong></td>
    <td><a href="<?php echo XOOPS_URL; ?>/modules/amevents/index.php?id=<?php echo $id; ?>"><?php echo XOOPS_URL; ?>/modules/amevents/index.php?id=<?php echo $id; ?></a></td>
  </tr>
</table>

<?php
		#$article = array('id' => $myrow['id'], 'article_title' => $myrow['art_title'], 'art_article_text' => $myrow['art_article_text'], 'art_views' => $myrow['art_views'], 'art_posted_datetime' => post_date($myrow['art_posted_datetime'], "D d M Y"));
	}	
?>	

    </td>
  </tr>
</table>

<?php

// html footer
html_footer();
} // end if


################################################################################
# functions
# 
function html_header() {
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 TRANSITIONAL//EN">
<html>
<head>
	<title></title>
<style type="text/css">
	<!--
	body {
		font-family: "Times New Roman", Times, serif;
		font-size: 12pt;
		color: Black;
	}

	table.maintbl {
		border-style: solid;
		border-width: 1px;
		border-color: Black;
		width: 90%;
		margin-left: 5%;
		margin-right: 5%;
	}
	-->
</style>

<script language="Javascript1.2" type="text/javascript">
<!--
function printpage() {
window.print();  
}
//-->
</script>

</head>
<body onload="printpage()">

<?php

} // end function

################################################################################
#
function html_footer() {
?>

</body>
</html>
<?php
} // end function

################################################################################
#
function post_date($datetime, $format) {

// DateTime format:  YYYY-MM-DD hh:mm:ss

	$yr=strval(substr($datetime, 0, 4));  
	$mo=strval(substr($datetime, 5, 2));  
	$da=strval(substr($datetime, 8, 2));  
	$hr=strval(substr($datetime, 11, 2));  
	$mi=strval(substr($datetime, 14, 2));  
	$se=strval(substr($datetime, 17, 2));

	$date_format = date($format, mktime ($hr,$mi,$se,$mo,$da,$yr)); //." GMT";
   
	return $date_format;
	
} // end function

################################################################################
# functions
# art_view_count() no longer used, only here for reference.
function increment_article_views($id) {
global $xoopsDB;
//global $xoopsModule;


	//$xoopsDB->query("UPDATE ".$xoopsDB->prefix("articles_main")." SET art_views=art_views+1 where id='$id'");
	//$xoopsDB->queryF("UPDATE ".$xoopsDB->prefix("seccont")." SET counter=counter+1 WHERE artid=$artid");
	$sql = ("UPDATE ".$xoopsDB->prefix("articles_main")." SET art_views=art_views+1 WHERE id=$id");
	$xoopsDB->queryF($sql);

                //if ($xoopsDB->query($q)){
                //        fc_admin_message(_FC_EDIT_DONE,0,"");
	
	
	//return $articleviews;

} // end function
# end of functions
################################################################################

#include XOOPS_ROOT_PATH.'/include/comment_view.php';
#include XOOPS_ROOT_PATH.'/footer.php';
?>