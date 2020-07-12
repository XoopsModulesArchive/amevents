<?php
// $Id: index.php,v 1.3 2006/03/08 22:18:17 andrew Exp $
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
include_once('../include/functions.inc.php');

xoops_cp_header();

//amevent_admin_header("", "<a href=\"". XOOPS_URL ."/modules/". $xoopsModule->getVar('dirname') ."/admin/index.php\">". _AM_EVE_NAVINDEX ."</a> &raquo; ". _AM_EVE_NAVFRNTPAGE ."");
amevent_admin_header("", _AM_EVE_NAVFRNTPAGE);

// get event stuff
$numevents = number_events();

?> 
<br />
<table cellpadding="0" cellspacing="1" class="outer" style="width: 100%;">
  <tr>
    <th colspan="2"><?php echo _AM_EVE_GENSTATS; ?></th>
  </tr>
  <tr>
    <td class="head" style="width: 100px;"><?php echo _AM_EVE_TTLVAL; ?></td>
	<td class="odd"><?php echo awaiting_validation(); ?> <?php echo _AM_EVE_VALWAIT; ?></td>
  </tr>
  <tr>
    <td class="head" style="width: 100px;"><?php echo _AM_EVE_TTLEVENTS; ?></td>
	<td class="odd"><?php echo $numevents['all']; ?> <?php echo _AM_EVE_TTLTOTAL; ?></td>
  </tr>
  <tr>
    <td class="head" style="width: 100px;"><?php echo _AM_EVE_TTLPUBLISHED; ?></td>
	<td class="odd"><?php echo $numevents['active']; ?> <?php echo _AM_EVE_TTLACTIVE; ?></td>
  </tr>
    <tr>
    <td class="head" style="width: 100px;"><?php echo _AM_EVE_TTLEXPIRED; ?></td>
	<td class="odd"><?php echo $numevents['expired']; ?> <?php echo _AM_EVE_TTLEXP; ?></td>
  </tr>
    <tr>
    <td class="head" style="width: 100px;"><?php echo _AM_EVE_TTLHIDDEN; ?></td>
	<td class="odd"><?php echo $numevents['hidden']; ?> <?php echo _AM_EVE_TTLHID; ?></td>
  </tr>
</table>

<br />

<?php                  
admin_foot_text(); 
xoops_cp_footer();
?>
