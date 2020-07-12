<?php
// $Id: admin.php,v 1.3 2006/03/08 22:20:13 andrew Exp $

// English version.


// General
// Navbar
define("_AM_EVE_NAVINDEX",		"Index");
define("_AM_EVE_NAVEVEADD",		"Add event");
define("_AM_EVE_NAVEVEEDDEL",	"Edit/Del Event");
define("_AM_EVE_NAVVALIDATE",	"Validate");
define("_AM_EVE_NAVFRNTPAGE",	"Front page");
define("_AM_EVE_NAVABOUT",		"About");
// "Breadcrumbs" bar
define("_AM_EVE_NAVBCINDEX",	"Index");
define("_AM_EVE_NAVBCEVEEDDE",	"Edit/Del article");
define("_AM_EVE_NAVBCVALEVE",	"Validate articles");
define("_AM_EVE_NAVBCEVEADD",	"add event");
define("_AM_EVE_NAVBCEVEADDED",	"edit/delete event");
define("_AM_EVE_NAVBCEVEED",	"edit event");
define("_AM_EVE_NAVBCEVEVAL",	"validate event");
define("_AM_EVE_NAVBCEVABOUT",	"about");
// Info bar
define("_AM_EVE_NAVINFMOD",		"module");
define("_AM_EVE_NAVINFPREF",	"prefs");
define("_AM_EVE_NAVINFHELP",	"help");
define("_AM_EVE_NAVINFABOUT",	"about");


// index.php
define("_AM_EVE_GENSTATS",		"General stats:");
define("_AM_EVE_TTLVAL",		"Validation:");
define("_AM_EVE_VALWAIT",		"events are waiting for <a href=\"validate.php\">validation</a>.");
define("_AM_EVE_TTLEVENTS",		"No. events:");
define("_AM_EVE_TTLTOTAL",		"total <a href=\"eventadmin.php\">event(s)</a>.");
define("_AM_EVE_TTLPUBLISHED",	"Published:");
define("_AM_EVE_TTLACTIVE",		"<a href=\"eventadmin.php\">event(s)</a> are published.");
define("_AM_EVE_TTLEXPIRED",	"Expired:");
define("_AM_EVE_TTLEXP",		"<a href=\"eventadmin.php\">event(s)</a> have expired.");
define("_AM_EVE_TTLHIDDEN",		"Hidden:");
define("_AM_EVE_TTLHID",		"<a href=\"eventadmin.php\">event(s)</a> are hidden.");

#define("_AM_EVENT_TITLE",		"AM Events admin");
#define("_AM_EVENT_TBLCAPTION",	"Choose an option:");
#define("_AM_EVENT_AWAITVALID",	"validate events");
#define("_AM_EVENT_ADD",			"add event");
#define("_AM_EVENT_ADMIN",		"event admin");
#define("_AM_EVENT_BUGS",		"report bug");


// form.inc.php
define("_AM_EVE_FRMCAPSDTTL",		"Event title:");
define("_AM_EVE_FRMCAPSDDATE",		"Date:");
define("_AM_EVE_FRMCAPSMDAY",		"Multiple days:");
define("_AM_EVE_FRMCAPSMDAY2",		"select if event is over 2 or more days.");
define("_AM_EVE_FRMCAPSDDATEEND",	"Date end:");
define("_AM_EVE_FRMCAPSLOC",		"Location:");
define("_AM_EVE_FRMCAPSLOCSEL",		"Please select a location");
define("_AM_EVE_FRMCAPSDURL",		"URL:");
define("_AM_EVE_FRMCAPSAUTHOR",		"Author:");
define("_AM_EVE_FRMCAPSDDETAIL",	"Details:");
define("_AM_EVE_FRMCAPSDSHOW",		"Show:");
define("_AM_EVE_FRMCAPSDSHOWDSC",	"select to publish event.");
define("_AM_EVE_FRMBTTNSAVE",		"Save event");
define("_AM_EVE_FRMBTTNRST",		"Cancel");
define("_AM_EVE_FRMCAPNOHTML",		"Allow HTML.");
define("_AM_EVE_FRMCAPNOBR",		"Convert line breaks (deselect when using WYSIWYG editors).");
define("_AM_EVE_FRMCAPNOSMLY",		"Allow XOOPS smiley icons.");
define("_AM_EVE_FRMCAPNOXCDE",		"Allow XOOPS codes.");
define("_AM_ART_FRMCAPNOXIMG",		"Allow display of images with XOOPS codes.");


// eventadmin.php
define("_AM_AMEVENT_CPTNTITLE",		"Events");
define("_AM_AMEVENT_CPTNEVENTS",	"Events");
define("_AM_AMEVENT_CPTNACTIVE",	"Active");
define("_AM_AMEVENT_CPTNENDS",		"Ended");
define("_AM_AMEVENT_CPTNDATE",		"Today's date");
define("_AM_AMEVENT_CPTNEDIT",		"click to edit event");
define("_AM_EVE_CONF_CONFIRMDEL",	"Are you sure you want to permanently delete this event?");
define("_AM_EVE_CONF_DELETED",		"Event deleted from database!");
define("_AM_EVE_CONF_NOTDELETED",	"Failed to delete event to database!");
define("_AM_EVE_CONF_UPDATED",		"Event updated!");
define("_AM_EVE_CONF_UPDATEDFAIL",	"Failed to update event!");
define("_AM_AMEVENT_CPTNTENDS",		"ends");


// eventadd.php
define("_AM_EVE_CONF_ADDED",	"Event added to database!");
define("_AM_EVE_CONF_FAILED",	"Failed to add event to database!");


// preview.php
define("_AM_EVE_PRE_TITLE",		"Event name:");
define("_AM_EVE_PRE_START",		"Start:");
define("_AM_EVE_PRE_END",		"End:");
define("_AM_EVE_PRE_DURATION",	"Duration:");
define("_AM_EVE_PRE_DAYS",		"Day(s)");
define("_AM_EVE_PRE_LOCATION",	"Location:");
define("_AM_EVE_PRE_URL",		"URL:");
define("_AM_EVE_PRE_DETAILS",	"Event details:");
define("_AM_EVE_PRE_CLOSE",		"Close window");


// validate.php
define("_AM_AMEVENT_CPTNVALTITLE",	"Validate events");
define("_AM_AMEVENT_CPTNID",		"id");
define("_AM_AMEVENT_CPTNNAME",		"event name");
define("_AM_AMEVENT_CPTNSTARTS",	"starts");
define("_AM_AMEVENT_CPTNPREVIEW",	"click to preview");
define("_AM_AMEVENT_CPTNVAL",		"click to validate event and show");
define("_AM_AMEVENT_CPTNVALED",		"click to validate event, but do not show");
define("_AM_AMEVENT_CPTNDEL",		"click to delete event");
define("_AM_AMEVENT_CPTNNOVAL",		"There are no events to validate.");
define("_AM_AMEVENT_CONF_VAL",		"Event validated successfully!");
define("_AM_AMEVENT_CONF_VALFAIL",	"Event not validated!");
define("_AM_EVE_CONF_VALDELSURE",	"Are you sure you want to permanently delete this event?");
define("_AM_EVE_CONF_VALDEL",		"Submitted event deleted!");
define("_AM_EVE_CONF_VALDELFAIL",	"Failed to delete user submitted event!");


// about.php


// Add/edit event form text
// Form and Listing Titles
define("_AM_EVENTADD",		"Add an event");
define("_AM_EVENTEDIT",		"Edit event");


 
?>