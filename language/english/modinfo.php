<?php
// English strings for displaying information about this module in the site administration web pages

// The name of this module. Prefix (_MI_) is for Module Information
define("_MI_EVENTS_NAME", "AM Events");

// The description of this module
define("_MI_EVENTS_DESC", "Events doodah.");

// Names of blocks in this module. Note that not all modules have blocks
#define("_MI_XX_TITLES", "");
define("_MI_EVENTS_BNAME1", "Upcoming events");
define("_MI_EVENTS_BNAME2", "Events calendar");

// Names of admin menu items
define('_MI_AMEVENT_MENU1',	'Index');
define('_MI_AMEVENT_MENU2',	'Validate event');
define('_MI_AMEVENT_MENU3',	'Add event');
define('_MI_AMEVENT_MENU4',	'Edit event');

// Sub menus 
define("_MI_EVENTS_SMNAME1", "Submit event");


// Notifications
define("_MI_AMEVENT_EVENT_NOTIFY",		"Global");
define("_MI_AMEVENT_EVENT_NOTIFYDSC",	"Notify of new events");

define("_MI_AMEVENT_EVENTADMIN_NOTIFY",		"Admin events");
define("_MI_AMEVENT_EVENTADMIN_NOTIFYDSC",	"Events for administrators");

define("_MI_AMEVENT_NEWEVENT_NOTIFY",		"New event added.");
define("_MI_AMEVENT_NEWEVENT_NOTIFYCAP",	"Notify me of new events");
define("_MI_AMEVENT_NEWEVENT_NOTIFYDSC",	"Notification of a new event");
define("_MI_AMEVENT_NEWEVENT_NOTIFYSBJ",	"A new event has been added");

define("_MI_AMEVENT_NEWUSEREVENT_NOTIFY",		"New event");
define("_MI_AMEVENT_NEWUSEREVENT_NOTIFYCAP",	"Notify admin of user submitted event");
define("_MI_AMEVENT_NEWUSEREVENT_NOTIFYDSC",	"Notifies admins of new events added by visitors");
define("_MI_AMEVENT_NEWUSEREVENT_NOTIFYSBJ",	"New user submitted event");

define("_MI_AMEVENT_NEWUSEREVENT_NOTA",		"New unvalidated event");
define("_MI_AMEVENT_NEWUSEREVENT_NOTCAPA",	"Notify admin of auto approved user submitted event");
define("_MI_AMEVENT_NEWUSEREVENT_NOTDSCA",	"Notifies admins of new events added by visitors that bave been directly added, and not validated.");
define("_MI_AMEVENT_NEWUSEREVENT_NOTSBJA",	"New user submitted event");


// Config options
define("_MI_AMEVENT_OPTION_LOGGEDIN",		"Logged in:");
define("_MI_AMEVENT_OPTION_LOGGEDINDSC",	"Should user be logged in to submit events.");
define("_MI_AMEVENT_OPTION_DATE",			"Date format - index:");
define("_MI_AMEVENT_OPTION_DATEDSC",		"Date format for index list. See PHP's <a href=\"http://www.php.net/date\" target=\"_blank\">date format page</a> for the different date format characters you can use.");
define("_MI_AMEVENT_OPTION_DATEMAIN",		"Date format - event:");
define("_MI_AMEVENT_OPTION_DATEMAINDSC",	"Date format for detailed event. See PHP's <a href=\"http://www.php.net/date\" target=\"_blank\">date format page</a> for the different date format characters you can use.");
define("_MI_AMEVENT_OPTION_DATEADMIN",		"Date format - admin:");
define("_MI_AMEVENT_OPTION_DATEADMINDSC",	"Date format for admin list. See PHP's <a href=\"http://www.php.net/date\" target=\"_blank\">date format page</a> for the different date format characters you can use.");
define('_MI_AMEVENT_OPTION_PAGETTL',		'Event name as page title:');
define('_MI_AMEVENT_OPTION_PAGETTLDSC',		'display the event\'s name in the page title.');
define('_MI_AMEVENT_OPTION_PAGETTL1',		'No');
define('_MI_AMEVENT_OPTION_PAGETTL2',		'Yes: &lt;module name&gt; - &lt;event title&gt;');
define('_MI_AMEVENT_OPTION_PAGETTL3',		'Yes: &lt;event title&gt; - &lt;module name&gt;');
define("_MI_AMEVENT_OPT_EML2FRE",			"Enable e-mail to friend:");
define("_MI_AMEVENT_OPT_EML2FREDSC",		"Enable the e-mail to friend feature.");
define("_MI_AMEVENT_OPT_EMLLOGGEDIN",		"Log in to use e-mail to friend:");
define("_MI_AMEVENT_OPT_EMLLOGGEDINDSC",	"Make users log in to use e-mail to friend feature.");
define("_MI_AMEVENT_OPT_EMLOWNMSG",			"Allow own message:");
define("_MI_AMEVENT_OPT_EMLOWNMSGDSC",		"Let user enter their own e-mail message.");
define("_MI_AMEVENT_OPT_EMLCHARS",			"Max e-mail characters:");
define("_MI_AMEVENT_OPT_EMLCHARSDSC",		"The maximum allowed characters users can enter in their message.");

define("_MI_AMEVENT_OPT_EMLMSGSBJCT",		"E-mail subject:");
define("_MI_AMEVENT_OPT_EMLMSGSBJCTDSC",	"The text to appear in the e-mail's subject field.");
define("_MI_AMEVENT_OPT_EMLMSGSUBJECT",		"A friend has recommended this event");

define("_MI_AMEVENT_OPT_EMAILTXT",		"E-mail message:");
define("_MI_AMEVENT_OPT_EMAILTXTSC",	"The text that will me sent in the e-mail to friend mesage.");
define("_MI_AMEVENT_OPT_EMAILTXTMSG",	"Hello,

A user of {SITE_NAME} feels that the following page may be of interest to you.

{ARTICLE_URL}

Their message below:

**

{USER_MESSAGE}

**

Security information:
If this e-mail has been sent inappropriately, please forward the complete e-mail to {ADMIN_EMAIL}.
User's IP address: {USER_IP}
User's Browser: {USER_BROWSER}
Time sent: {USER_TIME}

-- 
 {SITE_NAME}
 {SITE_URL}
");

define("_MI_AMEVENT_OPT_PRINTVER",		"Show printable version:");
define("_MI_AMEVENT_OPT_PRINTVERDSC",	"show and allow printer friendly version of Event.");
define("_MI_AMEVENT_OPT_EDITADMIN",		"Admin editor:");
define("_MI_AMEVENT_OPT_EDITADMINDSC",	"The editor to use in the admin area.");
define("_MI_AMEVENT_OPT_EDITUSER",		"User editor:");
define("_MI_AMEVENT_OPT_EDITUSERDSC",	"The editor to use for the user submit form.");
define("_MI_AMEVENT_OPT_ALLOWSUB",		"Allow user to submit events:");
define("_MI_AMEVENT_OPT_ALLOWSUBDSC",	"");
define("_MI_AMEVENT_OPT_AUTOSUB",		"Auto approve:");
define("_MI_AMEVENT_OPT_AUTOSUBDSC",	"Add user submitted event without validation.<br /><b>NOTE:</b> Use with caution! Submitted events may contain unsuitable content...");
define("_MI_AMEVENT_OPT_NOEXPIRE",		"Do not expire events:");
define("_MI_AMEVENT_OPT_NOEXPIREDSC",	"Leave events on view after their expiry date/time.");

?>