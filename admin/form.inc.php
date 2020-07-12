<?php

//print_r($data);

// modify what (if anything) is display in the form, depending upon
// where it's included from (edit or add)


// kill undefined index error messages
if (!isset($data['event_country'])) { $data['event_country'] = ""; }
if (!isset($data['event_url'])) { $data['event_url'] = ""; }
if (!isset($data['event_description'])) { $data['event_description'] = ""; }

	
// Now the actual form

// dynamic form
//
$ameventsform = new XoopsThemeForm($formtitle, "ameventsform", xoops_getenv('PHP_SELF'), 'post');

// formdata[event_name]
if (!isset($data['event_name'])) { $data['event_name'] = ""; }
$title = new XoopsFormText(_AM_EVE_FRMCAPSDTTL, 'formdata[event_name]', 40, 255, $data['event_name']);
$ameventsform->addElement($title);
unset($title);


//$startdate = new XoopsFormDateTime( mixed $caption, mixed $name, mixed $size = 15, mixed $value = 0 );
if (isset($data['event_date_start'])) {	$startdate = strtotime($data['event_date_start']); }
	else { $startdate = ""; }
	
$startdate = new XoopsFormDateTime(_AM_EVE_FRMCAPSDDATE, 'formdata[startdate]', 15, $startdate);
$ameventsform->addElement($startdate);
unset($startdate);


// multiday
if (isset($data['event_duration']) && $data['event_duration'] > 1) { $multichecked = "1"; }
else { $multichecked = "0"; }

$multidaybox = new XoopsFormCheckBox(_AM_EVE_FRMCAPSMDAY, 'formdata[multiday]', $multichecked); // checked value here whether will be checked?
$multidaybox->addOption(1, _AM_EVE_FRMCAPSMDAY2); // checked value here what will be sent in form?
$ameventsform->addElement($multidaybox);
unset($multidaybox);


// end date _AM_EVE_FRMCAPSDDATEEND - 
// http://dev.xoops.org/modules/phpwiki/index.php/XoopsFormDateTime
//if (isset($data['event_date_end'])) { $enddate = strtotime($data['event_date_end']); }
//	else { $enddate = $startdate; }
if (isset($data['event_duration']) && $data['event_duration'] == 1) {
	$enddate = strtotime($data['event_date_start']);
} else {
	$enddate = strtotime($data['event_date_end']);
}
	
$enddate = new XoopsFormDateTime(_AM_EVE_FRMCAPSDDATEEND, 'formdata[enddate]', 15, $enddate);
$ameventsform->addElement($enddate);
unset($enddate);


//
// Location
// new XoopsFormSelect($caption, $name, $value=null, $size=1, $multiple=false)
// addOption($value, $name="")
$catselect = new XoopsFormSelect(_AM_EVE_FRMCAPSLOC, 'formdata[country]', $data['event_country'], '1', false);
$catselect->addOption('0', _AM_EVE_FRMCAPSLOCSEL);
	$sql = ("SELECT * FROM " .$xoopsDB->prefix('amevents_country') . " ORDER BY country_name ASC");
	$result=$xoopsDB->query($sql);
	while($myrow = $xoopsDB->fetchArray($result)) {
		$country_code	= $myrow['country_code'];
		$country_name	= $myrow['country_name'];
		
		$catselect->addOption($country_code, $country_name);	
	} 
$ameventsform->addElement($catselect);


// URL
$eventurl = new XoopsFormText(_AM_EVE_FRMCAPSDURL, 'formdata[url]', 40, 255, $data['event_url']);
$ameventsform->addElement($eventurl);
unset($eventurl);


// Event author
#if ($approveprivilege && is_object($xoopsUser) && $xoopsUser->isAdmin($xoopsModule->mid())) {
	if(!isset($event_uid)) {
		$event_uid = $xoopsUser->getVar('uid');
	}
	$member_handler = &xoops_gethandler('member');
	$usercount = $member_handler->getUserCount();
	if ($usercount < 300) {
		$ameventsform->addElement(new XoopsFormSelectUser(_AM_EVE_FRMCAPSAUTHOR, 'formdata[uid]', true, $event_uid), false);
	} else {
		$ameventsform->addElement(new XoopsFormText(_AM_EVE_FRMCAPSAUTHOR, 'formdata[uid]', 10, 10, $event_uid), false);
	}
#}


// event details _AM_EVE_FRMCAPSDDETAIL
#$default_ed = new XoopsFormDhtmlTextArea(_AM_EVE_FRMCAPSDDETAIL, 'formdata[description]', $data['event_description'], '20', '40');

$ameventeditor = amevents_getwysiwygform(_AM_EVE_FRMCAPSDDETAIL, 'formdata[description]', $data['event_description'], "100%", "450px", '15');

// Loads XOOPS' default editor
#if ($xoopsModuleConfig['articleeditadmin'] == "0") {
	#$eventeditor = $default_ed;
#} // default

$ameventsform->addElement($ameventeditor);
unset($ameventeditor);
#unset($default_ed);
// end description


// Show/hide event
// we want the "Show" checkbox checked by default, unless we are
// editing an event and show is not set.
if (isset($data['event_showme']) AND $data['event_showme'] == "0") { $showcheck = "0"; }
else { $showcheck = "1"; } 

$showeventbox = new XoopsFormCheckBox(_AM_EVE_FRMCAPSDSHOW, 'formdata[showme]', $showcheck); // checked value here whether will be checked?
$showeventbox->addOption(1, _AM_EVE_FRMCAPSDSHOWDSC); // checked value here what will be sent in form?
$ameventsform->addElement($showeventbox);
unset($showeventbox);


//
// disable html
//
if (isset($event_html) AND $event_html == "0") { $nohtml_checked = "0"; }
else { $nohtml_checked = "1"; } 
$nohtmlbox = new XoopsFormCheckBox("", 'formdata[html]', $nohtml_checked); // checked value here whether will be checked?
$nohtmlbox->addOption(1, _AM_EVE_FRMCAPNOHTML); // checked value here what will be sent in form?

//
// disable auto line breaks
//
if (isset($event_br) AND $event_br == "0") { $nobr_checked = "0"; }
else { $nobr_checked = "1"; }
$nobrbox = new XoopsFormCheckBox("", 'formdata[br]', $nobr_checked); // checked value here whether will be checked?
$nobrbox->addOption(1, _AM_EVE_FRMCAPNOBR); // checked value here what will be sent in form?

//
// disable smileys
//
if (isset($event_smiley) AND $event_smiley == "0") { $nosmiley_checked = "0"; }
else { $nosmiley_checked = "1";}
$smileybox = new XoopsFormCheckBox("", 'formdata[smiley]', $nosmiley_checked); // checked value here whether will be checked?
$smileybox->addOption(1, _AM_EVE_FRMCAPNOSMLY); // checked value here what will be sent in form?

//
// disable xoops codes
//
if (isset($event_xcode) AND $event_xcode == "0") { $noxcode_checked = "0"; }
else { $noxcode_checked = "1"; }
$xcodebox = new XoopsFormCheckBox("", 'formdata[xcode]', $noxcode_checked); // checked value here whether will be checked?
$xcodebox->addOption(1, _AM_EVE_FRMCAPNOXCDE); // checked value here what will be sent in form?

//
// disable xoops images
//
if (isset($event_image) AND $event_image == "0") { $noimage_checked = "0"; }
else { $noimage_checked = "1"; }
$imgcodebox = new XoopsFormCheckBox("", 'formdata[image]', $noimage_checked); // checked value here whether will be checked?
$imgcodebox->addOption(1, _AM_ART_FRMCAPNOXIMG); // checked value here what will be sent in form?

$optionstray = new XoopsFormElementTray('','<br />');
$optionstray->addElement($nohtmlbox);
$optionstray->addElement($nobrbox);
$optionstray->addElement($smileybox);
$optionstray->addElement($xcodebox);
$optionstray->addElement($imgcodebox);
$ameventsform->addElement($optionstray);
unset($nohtmlbox);
unset($smileybox);
unset($xcodebox);
unset($imgcodebox);
unset($nobrbox);


// Hidden fields
if ($formfunc == "add") {
	$ameventsform->addElement(new XoopsFormHidden('op', 'add'));
}
if ($formfunc == "edit") {
	$ameventsform->addElement(new XoopsFormHidden('op', 'edit'));
	$ameventsform->addElement(new XoopsFormHidden('formdata[id]', $data['id']));
}


//
// Submit
//
// new XoopsFormButton('Button Caption', 'button_id', 'Button-Text', 'submit'));
$button_sub = new XoopsFormButton('', 'but_save', _AM_EVE_FRMBTTNSAVE, 'submit');
//$button_sub->setExtra('onclick="return checkfields();"');
$button_can = new XoopsFormButton('', 'but_reset', _AM_EVE_FRMBTTNRST, 'reset');
//$button_pre = new XoopsFormButton('', 'but_preview', _AM_ART_FRMBTTNPRVW, 'submit');
//$button_pre->setExtra('onclick="return checkfields();"');
//$button_pre->setExtra("preview='1'");

$tray = new XoopsFormElementTray('');
$tray->addElement($button_sub);
$tray->addElement($button_can);
//$tray->addElement($button_pre);
$ameventsform->addElement($tray);

// display form
$ameventsform->display();

//
// OLD FORM BELOW
//
/*
?>


<script language="javascript">
<!-- begin/hide

var yearEnd = "";
var yearMonth = "";
var yearDay = "";

function InitSaveVariables(form) {
   yearEnd   = document.getElementById('yearend').value;
   yearMonth = document.getElementById('monthend').value;
   yearDay   = document.getElementById('dayend').value;
}

function copyDate(form) {
   if (form.copy.checked) {
      InitSaveVariables(form);
      form.yearend.value  = document.getElementById('year').value;
      form.monthend.value = document.getElementById('month').value;
      form.dayend.value   = document.getElementById('day').value;
   }
   else {
      form.yearend.value  = yearEnd;
      form.monthend.value = yearMonth;
      form.dayend.value   = yearDay;
   }
}

// -->
</script>

<form method="post" action="<?=$_SERVER['PHP_SELF']?>">
<?php
if ($formfunc == "add") { echo "<input type=\"hidden\" name=\"op\" value=\"add\">\n"; }
if ($formfunc == "edit") { 
	echo "<input type=\"hidden\" name=\"op\" value=\"edit\">\n"; 
	echo "<input type=\"hidden\" name=\"formdata[id]\" value=\"" . $data['id'] . "\">\n";
}
?>
<table border="0">
  <tr>
    <th colspan="2"><?=$formtitle?></th>
  </tr>
  <tr>
    <td class="head">Event title:</td>
    <td class="odd"><input type="text" name="formdata[event_name]" value="<?=$data['event_name']?>" size="40"></td>
  </tr>
  <tr>
    <td class="head">Date:</td>
    <td class="odd">
      <table border="0" style="width: 30%;">
        <tr>
          <td>Year</td>
          <td><input type="text" name="formdata[year]" id="year" value="<?=$year?>" size="4" maxlength="4"></td>
          <td><!-- <{$eventdatefor_year}> --></td>
        </tr>
        <tr>
          <td>Month</td>
          <td><input type="text" name="formdata[month]" id="month" value="<?=$month?>" size="2" maxlength="2"></td>
          <td><!-- <{$eventdatefor_month}> --></td>
        </tr>
        <tr>
          <td>Day</td>
          <td><input type="text" name="formdata[day]" id="day" value="<?=$day?>" size="2" maxlength="2"></td>
          <td><!-- <{$eventdatefor_day}> --></td>
        </tr>
      </table>    
    
    </td>
  </tr>
  
  <tr>
    <td class="head">Multi day:</td>
    <td class="odd">
      <input type="checkbox" name="formdata[multiday]" id="copy" value="1" OnClick="javascript:copyDate(this.form);" <?=$multichecked?>>
    </td>
  </tr>
  <tr>
    <td class="head">Date end:</td>
    <td class="odd">
      <table border="0" style="width: 30%;">
        <tr>
          <td>Year</td>
          <td><input type="text" name="formdata[yearend]" id="yearend" value="<?=$yearend?>" size="4" maxlength="4"></td>
          <td><!-- <{$eventdatefor_year}> --></td>
        </tr>
        <tr>
          <td>Month</td>
          <td><input type="text" name="formdata[monthend]" id="monthend" value="<?=$monthend?>" size="2" maxlength="2"></td>
          <td><!-- <{$eventdatefor_month}> --></td>
        </tr>
        <tr>
          <td>Day</td>
          <td><input type="text" name="formdata[dayend]" id="dayend" value="<?=$dayend?>" size="2" maxlength="2"></td>
          <td><!-- <{$eventdatefor_day}> --></td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td class="head">Location:</td>
    <td class="odd">
      <?=list_countries($data['event_country'])?>
    </td>
  </tr>
  <tr>
    <td class="head">URL:</td>
    <td class="odd"><input type="text" name="formdata[url]" value="<?=$data['event_url']?>" size="40"></td>
  </tr>
  <tr>
    <td class="head" valign="top">Details:</td>
    <td class="odd"><textarea name="formdata[description]" rows="10" cols="40"><?=$data['event_description']?></textarea></td>
  </tr>
  <tr>
    <td class="head">Show:</td>
    <td class="odd"><input type="checkbox" name="formdata[showme]" value="1" <?=$showcheck?>></td>
  </tr>
  <tr>
    <td class="head" valign="top">&nbsp;</td>
    <td class="odd"><input type="submit"> <input type="reset"></td>
  </tr>
</table>
</form>
<?php
*/


?>