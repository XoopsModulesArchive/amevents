<?php
// $Id: about.php,v 1.1 2006/03/08 22:18:17 andrew Exp $
//  ------------------------------------------------------------------------ //
//  Author: Andrew Mills                                                     //
//  Email:  ajmills@sirium.net                                         //
//	About:  This file is part of the AM Events module for Xoops v2.           //
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
	include "../language/".$xoopsConfig['language']."/main.php";
} else {
	include "../language/english/main.php";
}
include_once ("../include/functions.inc.php");
include_once (XOOPS_ROOT_PATH . "/include/xoopscodes.php");
include_once (XOOPS_ROOT_PATH . "/class/module.errorhandler.php");
include_once (XOOPS_ROOT_PATH . "/class/xoopsformloader.php");
$myts =& MyTextSanitizer::getInstance(); 

//
//----------------------------------------------------------------------------//
//
if(!isset($_REQUEST['op'])) {
xoops_cp_header();
//admin_header("", "<a href=\"". XOOPS_URL ."/modules/". $xoopsModule->getVar('dirname') ."/admin/index.php\">". _AM_ART_NAVINDEX ."</a> &raquo; ". _AM_ART_NAVABOUT ."");
amevent_admin_header("", _AM_EVE_NAVBCEVABOUT);
?>

<br />
<table border="0" cellspacing="1" style="width: 100%;" class="outer">
  <tr>
    <th>About</th>
  </tr>
  <tr>
    <td class="odd">
	  AM Events is an event publishing module for XOOPS.
	</td>
  </tr>
</table>

<br />
<table border="0" cellspacing="1" style="width: 100%" class="outer">
  <tr>
    <th colspan="2">Version info</th>
  </tr>
  <tr>
    <td class="head" width="100">Version:</td>
	<td class="odd"> version in XOOPS: <?php echo round($xoopsModule->getVar('version')/100 , 2); ?>, actual version: <?php echo _AMEVENTSVERSION; ?>. </td>
  </tr>
  <tr>
    <td class="head" width="100">Version info:</td>
	<td class="odd"> See the <a href="http://support.sirium.net/modules/articles/index.php?cat_id=4" target="_blank">AM Events section</a> on the module web site for info on this version.</td>
  </tr>
  <tr>
    <td class="head" width="100">Updates:</td>
	<td class="odd">
	  <a href="#" onclick="javascript:window.open('<?php echo $_SERVER['PHP_SELF']; ?>?op=updates', 'preview', 'height=450,width=650,status=yes,toolbar=no,menubar=no,location=no,scrollbars=yes');">Check for updates</a>
	</td>
  </tr>
  <tr>
</table>

<br />
<table border="0" cellspacing="1" style="width: 100%;" class="outer">
  <tr>
    <th colspan="2">Support, feature requests and comments</th>
  </tr>
  <tr>
    <td class="head" width="100"><?php /*echo $xoopsModule->getVar('name');*/ ?>Forums:</td>
	<td class="odd">
	  The <?php echo $xoopsModule->getVar('name'); ?>
	  <a href="http://support.sirium.net/modules/newbb/index.php?cat=4" target="_blank">support forums</a>
	  is the preferred support method, I aim to answer all support/feature requests as soon as 
	  possible.
	</td>
  </tr>
  <tr>
    <td class="head" width="100">E-mail:</td>
	<td class="odd">
	  I can also be contacted via the 
	  <a href="http://support.sirium.net/modules/contact/" target="_blank">contact form on the web site</a>.
	</td>
  </tr>
  <tr>
    <td class="head" width="100">General:</td>
	<td class="odd">
	  Please also check the forums, FAQs and Article pages to see if your problem
	  and/or question has already been answered. 
	</td>
  </tr>
</table>

<br />
<table border="0" cellspacing="1" style="width: 100%;" class="outer">
  <tr>
    <th>Credits</th>
  </tr>
  <tr>
    <td class="odd">
	  This module is made up from suggestions and ideas from many sources.
	  
	  <br/><br>
	  The idea of this page, and the navigation menu came from the newBB module (v2.0),
	  and Smartfactory modules, and the module dev documentation.<br>
	  <br>
	  Thanks to everyone who has provided translations, ideas, bug reports and
	  support!<br>
	  
	</td>
  </tr>
</table>

<?php

admin_foot_text();
xoops_cp_footer();
} // thing

//
//----------------------------------------------------------------------------//
//
if(isset($_REQUEST['op']) AND $_REQUEST['op'] == "updates") {

	if(!@include('http://support.sirium.net/files/xoopsamevents/version.txt')) {
		echo "Sorry, I was unable to get version info!<br /> The server could be unavailable, or your host does not allow remote file fetching.<br />Please visit the main web site <a href=\"http://support.sirium.net/modules/mydownloads/\" target=\"_blank\">here</a>. ";
		exit;
	}
/*	
$version = "0.24";
$url = "http://support.sirium.net/modules/mydownloads/viewcat.php?cid=2";
*/

/*	if(!isset($version)) {
		echo "Thingy not set";
	} else {
		echo $version;
	}
*/
?>	
<div align="center"><input type="button" value=" Close window " onclick="window.close();"></div>
<table border="0" style="width: 100%;">
  <tr>
    <th colspan="2">Updates</th>
  </tr>
  <tr>
    <td style="width: 90px; font-weight: bold;">Status:</td>
    <td>
<?php
	if (_AMEVENTSVERSION > $version) {
		echo "You are using a newer version than the latest release, you are probably using a test release.";
	}
	if (_AMEVENTSVERSION < $version) {
		echo "An update is available.";
	} 
	if (_AMEVENTSVERSION == $version) {
		echo "You are using the latest version.";
	}
?>    
    </td>
  </tr>
  <tr>
    <td style="width: 90px; font-weight: bold; vertical-align: top;">Details:</td>
	<td>
	  Your version: <?php echo _AMEVENTSVERSION; ?><br/>
	  Available version: <?php echo $version; ?>
	</td>
  </tr>
  <tr>
    <td style="width: 90px; font-weight: bold; vertical-align: top;">Download:</td>
	<td>
	  .tar.gz version: <a href="<?php echo $urlzip; ?>" target="_blank">Download</a> page.<br/>
	  .zip version: <a href="<?php echo $urlgzip; ?>" target="_blank">Download</a> page.
	</td>
  </tr>
  <tr>
    <td colspan="2">
      <span style="font-weight: bold;">History:</span><br />
	  <pre>
<?php echo $history; ?>
	  </pre>
	
	</td>
  </tr>
</table>
<div align="center"><input type="button" value=" Close window " onclick="window.close();"></div>

<?php	
	
} // end




?>
	