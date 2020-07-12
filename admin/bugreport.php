<?php
// $Id: bugreport.php,v 1.3 2004/12/15 00:43:05 andrew Exp $
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
	include "../language/".$xoopsConfig['language']."/main.php";
} else {
	include "../language/english/main.php";
}
include_once('../include/functions.inc.php');
include XOOPS_ROOT_PATH."/class/xoopsmailer.php";

if (!isset($_GET['op']) and !isset($_POST['op'])) {
xoops_cp_header();

?> 
<p>
<span style="font-weight: bold;"><a href="index.php"><?=_MD_NAVTOP?></a></span>
<span style="font-weight: bold; font-size: smaller;">&gt;&gt;</span>
<span style="font-weight: bold;"><?=_MD_NAVEVENTBUG?></span> 
</p>

<h4 style="text-align: center;"><?=$xoopsModule->getVar('name')?> bug reporting utility</h4>

<p>This page is designed to help you submit bug/problem reports with this
module. To help diagnose and/or replicate any potential problems, some 
information will be e-mailed to the module author - this includes the version
number of this module, the version number of XOOPS it's being used with and
the info supplied by the <a href="<?=$_SERVER['PHP_SELF']?>?op=phpinfo" target="_blank">phpinfo()</a> function.</p>

<p><strong>Please note:</strong> please check that you are using the most current version (where 
a problem may already have been fixed) and that the problem you are experiencing
has not already been reported on the support forums.</p>
<ul>
  <li><?=$xoopsModule->getVar('name')?> support forums: <a href="http://support.sirium.net/modules/newbb/" target="_blank">http://support.sirium.net/modules/newbb/</a></li>
  <li><?=$xoopsModule->getVar('name')?> download area: <a href="http://support.sirium.net/modules/mydownloads/viewcat.php?cid=5" target="_blank">http://support.sirium.net/ [....] viewcat.php?cid=5</a></li>
</ul>

<form action="<?=$_SERVER['PHP_SELF']?>" method="post">
<input type="hidden" name="op" value="send">
<table border="0">
  <tr>
    <td class="head">Your name:</td>
    <td class="odd"><input type="text" name="formdata[name]" value="<?=$xoopsUser->getVar('uname')?>" size="40" maxlength="50"></td>
  </tr>
  <tr>
    <td class="head">Your e-mail:</td>
    <td class="odd"><input type="text" name="formdata[email]" value="<?=$xoopsUser->getVar('email')?>" size="40" maxlength="50"></td>
  </tr>
  <tr>
    <td class="head">Module name:</td>
    <td class="odd">
      <?=$xoopsModule->getVar('name')?>
      <input type="hidden" name="formdata[modname]" value="<?=$xoopsModule->getVar('name')?>">
    </td>
  </tr>
  <tr>
    <td class="head">Module version:</td>
    <td class="odd">
      <?=round($xoopsModule->getVar('version')/100 , 2)?>
      <input type="hidden" name="formdata[modversion]" value="<?=round($xoopsModule->getVar('version')/100 , 2)?>">
    </td>
  </tr>
  <tr>
    <td class="head">XOOPS version:</td>
    <td class="odd">
      <?=XOOPS_VERSION?>
      <input type="hidden" name="formdata[xoopsversion]" value="<?=XOOPS_VERSION?>">
    </td>
  </tr>
  <tr>
   <td class="head" valign="top">
     Details:<br />
     <span style="font-size: smaller;">
     Please provide any details of the problem that you feel is
     relevant.
     </span>
   </td>
   <td class="odd" >
     <textarea name="formdata[details]" rows="10" cols="40"></textarea>
   </td>
  </tr>
  <tr>
    <td class="head">&nbsp;</td>
    <td class="odd"><input type="submit"> <input type="reset"></td>
  </tr>
</table>
</form>

<?=//round($xoopsModule->getVar('version')/100 , 2)?>

<?php                  
admin_foot_text(); 
xoops_cp_footer();
} // end if

#~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~#

if (isset($_POST['op'])) {
xoops_cp_header();
	
	if (isset($_POST['formdata'])) { $formdata = $_POST['formdata']; }

include XOOPS_ROOT_PATH.'/header.php';
	$emailsend['name']			= $formdata['name'];
	$emailsend['email']			= $formdata['email'];
	$emailsend['modname']		= $formdata['modname'];
	$emailsend['modversion']	= $formdata['modversion'];
	$emailsend['xoopsversion']	= $formdata['xoopsversion'];
	$emailsend['message']		= stripslashes($formdata['details']);
	
	$emailsend['recipient']	=	"andy@sirium.net";
	$email_subject = $emailsend['modname'] . " bug report.";
	
	#$messagetext = "Test message text";
	
	$messagetext = "Hi,\n\n";
	$messagetext .= "Name: " . $emailsend['name'] . "\n";
	$messagetext .= "E-mail: " . $emailsend['email'] . "\n";
	$messagetext .= "Submitter: " . $xoopsUser->getVar('uname') . " " . $xoopsUser->getVar('email') . "\n";
	$messagetext .= "\n";
	
	$messagetext .= "Module and XOOPS details:-\n";
	$messagetext .= "Module: " . $emailsend['modname'] . "\n";
	$messagetext .= "Version: " . $emailsend['modversion'] . "\n";
	$messagetext .= "XOOPS version: " . $emailsend['xoopsversion'] . "\n";
	$messagetext .= "\n";
	
	$messagetext .= "Server details:-\n";
	$messagetext .= "Server name: " . $_SERVER['SERVER_NAME'] . "\n";
	$messagetext .= "User agent: " . $_SERVER['HTTP_USER_AGENT'] . "\n";
	$messagetext .= "Server sig: " . $_SERVER['SERVER_SOFTWARE'] . "\n";
	$messagetext .= "\n";
	
	$messagetext .= "\nUser message:-\n";
	$messagetext .= wordwrap($emailsend['message']) . "\n";
	$messagetext .= "\n";
	$messagetext .= "-- \n";

		$xoopsMailer =& getMailer();
		$xoopsMailer->useMail();
		$xoopsMailer->setToEmails($emailsend['recipient']);
		$xoopsMailer->setFromEmail($emailsend['email']);
		$xoopsMailer->setFromName($emailsend['name']);
		$xoopsMailer->setSubject($email_subject);
		$xoopsMailer->setBody($messagetext);
		//$xoopsMailer->send();
		if (!$xoopsMailer->send()) { 
			//echo "it didn't work";
			redirect_header("index.php", 2, "Oops, it didn't work!");
		} else { 
			//echo "it worked";
			redirect_header("index.php", 2, "Report sent!");
		}
		
		#$xoopsTpl->append('email', $emailsend);
		unset($emailsend);





admin_foot_text(); 
xoops_cp_footer();
} // if




################################################################################
#
if (isset($_GET['op']) and $_GET['op'] == "phpinfo") {
    echo phpinfo();    
}




?>
