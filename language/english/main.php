<?php
// $Id: main.php,v 1.9 2006/03/10 00:42:42 andrew Exp $

// English version.


// index.php - Initial event listing.
define("_MD_AMEVENT_CAPLIST",		"Upcoming events");
define("_MD_AMEVENT_CAPEVENT",		"Event");
define("_MD_AMEVENT_CAPDATESTRT",	"Starts");
define("_MD_AMEVENT_CAPDATEEND",	"Ends");
define("_MD_AMEVENT_CAPDURATION",	"Duration");

// index.php - detailed event view
define("_MD_AMEVENT_POSTED",		"Posted");
define("_MD_AMEVENT_POSTEDBY",		"by");
define("_MD_AMEVENT_POSTEDON",		"on");
define("_MD_AMEVENT_TITLE",			"Event:");
define("_MD_AMEVENT_DATESTART",		"Starts:");
define("_MD_AMEVENT_DATEEND",		"Ends:");
define("_MD_AMEVENT_DURATION",		"Duration:");
define("_MD_AMEVENT_LOCATION",		"Location:");
define("_MD_AMEVENT_URL",			"Web:");
define("_MD_AMEVENT_DETAILS",		"Event details:");
define("_MD_AMEVENT_EML2FRIEND",	"E-mail to friend");
define("_MD_AMEVENT_INDEXLINKTXT",	"Return to index");
define("_MD_AMEVENT_PRINTVERSION",	"Printer friendly version");
define("_MD_AMEVENT_ADMINURLED",	"Edit this event");
define("_MD_AMEVENT_ADMINURLDEL",	"Delete this event");
define("_MD_AMEVENT_NOEVENTMSG",	"There are currently no events to display, please check back later!.");


// submit.php
define("_MD_AMEVENT_FORMTTL",		"Submit an event");
define("_MD_AMEVENT_EVENTTTL",		"Event name:");
define("_MD_AMEVENT_STARTDATE",		"Start date:");
define("_MD_AMEVENT_DATEFORMAT",	"Date format: yyyy-mm-dd<br />Please select the nearest open/close time.");
define("_MD_AMEVENT_MULTIDAY",		"Multiple days:");
define("_MD_AMEVENT_MULTIDAYCAP",	"select if event is over 2 or more days.");
define("_MD_AMEVENT_ENDDATE",		"End date:");
define("_MD_AMEVENT_LOCATIONSUB",	"Location:");
define("_MD_AMEVENT_SELECTLOC",		"Please select a location");
define("_MD_AMEVENT_URLSUB",		"URL:");
define("_MD_AMEVENT_DETAILSSUB",	"Details:");
define("_MD_AMEVENT_BUTTONSAVE",	"Submit event");
define("_MD_AMEVENT_BUTTONRST"	,	"Reset");
define("_MD_AMEVENT_OPTHTML",		"Allow HTML formatting.");
define("_MD_AMEVENT_OPTBR",			"Enable auto line break formatting.");
define("_MD_AMEVENT_OPTSMLY",		"Convert smilies to icons.");
define("_MD_AMEVENT_OPTXCODE",		"Enable XOOPS codes.");
define("_MD_AMEVENT_OPTXIMAGE",		"Enable XOOPS images (requires XOOPS codes to be enabled).");
define("_MD_NOTALLOWED",			"This function is disabled.");
define("_MD_EVEJSERRTITLE",			"Please enter an event title.");
define("_MD_EVEJSERRLOCATE",		"Please select a location.");



// email.php
define("_MD_EMAILHEADTTL", 		"E-mail Event to friend");
define("_MD_EMAILYOURNAME",		"Your name:");
define("_MD_EMAILYOUREMAIL",	"Your e-mail:");
define("_MD_EMAILRECIPIENT",	"Recipient:");
define("_MD_EMAILMESSAGE",		"Your message:");
define("_MD_EMAILMESSAGEDESC",	"This will be included in the e-mail.");
define("_MD_EMAILSEND",			"send");
define("_MD_EMAILSET",			"reset");
define("_MD_EMAILSECNOTE",		"<strong>Please note:</strong> Some security information will be sent along with the e-mail to help trace anyone who abuses this service."); 
define("_MD_EMAILNOTON",		"This feature is not enabled.");


// print.php
define("_MD_AMEVENT_PRTTITLE",			"Event:");
define("_MD_AMEVENT_PRTDATESTART",		"Starts:");
define("_MD_AMEVENT_PRTDATEEND",		"Ends:");
define("_MD_AMEVENT_PRTDURATION",		"Duration:");
define("_MD_AMEVENT_PRTDURATIONDAYS",	"day(s)");
define("_MD_AMEVENT_PRTLOCATION",		"Location:");
define("_MD_AMEVENT_PRTURL",			"Web:");
define("_MD_AMEVENT_PRTDETAILS",		"Event details:");

define("_MD_AMEVENT_PRTPUBLISHED",		"This event was originally published on:");
define("_MD_AMEVENT_PRTSITETTL",		"Site name:");
define("_MD_AMEVENT_PRTSITEURL",		"Site URL:");


// Confirmation - user side
define("_MD_EVENTUSERENTERED",		"Your event has been submitted");
define("_MD_EVENTUSERENTEREDEX",	"Thank your for your submission. We will check and validate your event as soon as possible.");
define("_MD_EVENTUSERENTEREDEXA",	"Thank your for your submission. Your event should now be visible. Please be aware that an admin may review your submission, and remove it if it's not suitable.");
define("_MD_EVENTUSERENTERFAIL",	"Failed to submit event.");
define("_MD_EVENTUSERENTERFAILEX",	"Your submission failed - please contact us with the error you encountered.");
define("_MD_EVENTLOGGEDIN",			"You must be logged in.");
define("_MD_EVENTNOTALLOWED",		"You are not allowed access to this area.");


?>
