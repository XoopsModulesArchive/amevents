# $Id: mysql.sql,v 1.7 2006/03/08 22:20:52 andrew Exp $

#//  ------------------------------------------------------------------------ //
#//  Author: Andrew Mills                                                     //
#//  Email:  ajmills@the-crescent.net                                         //
#//	 About:  This file is part of the AM-Events module for Xoops v2.          //
#//                                                                           //
#//  ------------------------------------------------------------------------ //
#//                XOOPS - PHP Content Management System                      //
#//                    Copyright (c) 2000 XOOPS.org                           //
#//                       <http://www.xoops.org/>                             //
#//  ------------------------------------------------------------------------ //
#//  This program is free software; you can redistribute it and/or modify     //
#//  it under the terms of the GNU General Public License as published by     //
#//  the Free Software Foundation; either version 2 of the License, or        //
#//  (at your option) any later version.                                      //
#//                                                                           //
#//  You may not change or alter any portion of this comment or credits       //
#//  of supporting developers from this source code or any supporting         //
#//  source code which is considered copyrighted (c) material of the          //
#//  original comment or credit authors.                                      //
#//                                                                           //
#//  This program is distributed in the hope that it will be useful,          //
#//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
#//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
#//  GNU General Public License for more details.                             //
#//                                                                           //
#//  You should have received a copy of the GNU General Public License        //
#//  along with this program; if not, write to the Free Software              //
#//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
#//  ------------------------------------------------------------------------ //


-- 
-- Table structure for table `amevents_events`
-- 

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


-- --------------------------------------------------------

-- 
-- Table structure for table `xoops_amevents_country`
-- 

CREATE TABLE `amevents_country` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `country_name` varchar(150) default NULL,
  `country_code` varchar(5) NOT NULL default '00',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

-- 
-- Dumping data for table `xoops_amevents_country`
-- 

INSERT INTO `amevents_country` VALUES (1, 'United Kingdom', 'gb');
INSERT INTO `amevents_country` VALUES (2, 'Australia', 'au');
INSERT INTO `amevents_country` VALUES (3, 'Germany', 'de');
INSERT INTO `amevents_country` VALUES (4, 'Czech Republic', 'cz');
INSERT INTO `amevents_country` VALUES (5, 'France', 'fr');
INSERT INTO `amevents_country` VALUES (6, 'Ireland', 'ie');
INSERT INTO `amevents_country` VALUES (7, 'Netherlands', 'nl');
INSERT INTO `amevents_country` VALUES (8, 'Norway', 'no');
INSERT INTO `amevents_country` VALUES (9, 'New Zealand', 'nz');
INSERT INTO `amevents_country` VALUES (10, 'Sweden', 'se');
INSERT INTO `amevents_country` VALUES (11, 'Internet', '01');
INSERT INTO `amevents_country` VALUES (12, 'United States', 'us');
INSERT INTO `amevents_country` VALUES (13, 'Brazil', 'br');
INSERT INTO `amevents_country` VALUES (14, 'Canada', 'ca');
INSERT INTO `amevents_country` VALUES (15, 'Afghanistan', 'af');
INSERT INTO `amevents_country` VALUES (16, 'Åland Islands', 'ax');
INSERT INTO `amevents_country` VALUES (17, 'Albania', 'al');
INSERT INTO `amevents_country` VALUES (18, 'Algeria', 'dz');
INSERT INTO `amevents_country` VALUES (19, 'American Samoa', 'as');
INSERT INTO `amevents_country` VALUES (20, 'Andorra', 'ad');
INSERT INTO `amevents_country` VALUES (21, 'Angola', 'ao');
INSERT INTO `amevents_country` VALUES (22, 'Anguilla', 'ai');
INSERT INTO `amevents_country` VALUES (23, 'Antarctica', 'aq');
INSERT INTO `amevents_country` VALUES (24, 'Antigua And Barbuda', 'ag');
INSERT INTO `amevents_country` VALUES (25, 'Argentina', 'ar');
INSERT INTO `amevents_country` VALUES (26, 'Armenia', 'am');
INSERT INTO `amevents_country` VALUES (27, 'Aruba', 'aw');
INSERT INTO `amevents_country` VALUES (29, 'Azerbaijan', 'az');
INSERT INTO `amevents_country` VALUES (30, 'Bahamas', 'bs');
INSERT INTO `amevents_country` VALUES (31, 'Bahrain', 'bh');
INSERT INTO `amevents_country` VALUES (32, 'Bangladesh', 'bd');
INSERT INTO `amevents_country` VALUES (33, 'Barbados', 'bb');
INSERT INTO `amevents_country` VALUES (34, 'Belarus', 'by');
INSERT INTO `amevents_country` VALUES (35, 'Belgium', 'be');
INSERT INTO `amevents_country` VALUES (36, 'Belize', 'bz');
INSERT INTO `amevents_country` VALUES (37, 'Benin', 'bj');
INSERT INTO `amevents_country` VALUES (38, 'Bermuda', 'bm');
INSERT INTO `amevents_country` VALUES (39, 'Bhutan', 'bt');
INSERT INTO `amevents_country` VALUES (40, 'Bolivia', 'bo');
INSERT INTO `amevents_country` VALUES (41, 'Bosnia And Herzegovina', 'ba');
INSERT INTO `amevents_country` VALUES (42, 'Botswana', 'bw');
INSERT INTO `amevents_country` VALUES (43, 'Bouvet Island', 'bv');
INSERT INTO `amevents_country` VALUES (44, 'British Indian Ocean Territory', 'io');
INSERT INTO `amevents_country` VALUES (45, 'Brunei Darussalam', 'bn');
INSERT INTO `amevents_country` VALUES (46, 'Bulgaria', 'bg');
INSERT INTO `amevents_country` VALUES (47, 'Burkina Faso', 'bf');
INSERT INTO `amevents_country` VALUES (48, 'Burundi', 'bi');
INSERT INTO `amevents_country` VALUES (49, 'Cambodia', 'kh');
INSERT INTO `amevents_country` VALUES (50, 'Cameroon', 'cm');
INSERT INTO `amevents_country` VALUES (52, 'Cape Verde', 'cv');
INSERT INTO `amevents_country` VALUES (53, 'Cayman Islands', 'ky');
INSERT INTO `amevents_country` VALUES (54, 'Central African Republic', 'cf');
INSERT INTO `amevents_country` VALUES (55, 'Chad', 'td');
INSERT INTO `amevents_country` VALUES (56, 'Chile', 'cl');
INSERT INTO `amevents_country` VALUES (57, 'China', 'cn');
INSERT INTO `amevents_country` VALUES (58, 'Christmas Island', 'cx');
INSERT INTO `amevents_country` VALUES (59, 'Cocos (keeling) Islands', 'cc');
INSERT INTO `amevents_country` VALUES (60, 'Colombia', 'co');
INSERT INTO `amevents_country` VALUES (61, 'Comoros', 'km');
INSERT INTO `amevents_country` VALUES (62, 'Congo', 'cg');
INSERT INTO `amevents_country` VALUES (63, 'Congo, The Democratic Republic Of The', 'cd');
INSERT INTO `amevents_country` VALUES (64, 'Cook Islands', 'ck');
INSERT INTO `amevents_country` VALUES (65, 'Costa Rica', 'cr');
INSERT INTO `amevents_country` VALUES (66, 'Croatia', 'hr');
INSERT INTO `amevents_country` VALUES (67, 'Cuba', 'cu');
INSERT INTO `amevents_country` VALUES (68, 'Cyprus', 'cy');
INSERT INTO `amevents_country` VALUES (69, 'Denmark', 'dk');
INSERT INTO `amevents_country` VALUES (70, 'Djibouti', 'dj');
INSERT INTO `amevents_country` VALUES (71, 'Dominica', 'dm');
INSERT INTO `amevents_country` VALUES (72, 'Dominican Republic', 'do');
INSERT INTO `amevents_country` VALUES (73, 'Ecuador', 'ec');
INSERT INTO `amevents_country` VALUES (74, 'Egypt', 'eg');
INSERT INTO `amevents_country` VALUES (75, 'El Salvador', 'sv');
INSERT INTO `amevents_country` VALUES (76, 'Equatorial Guinea', 'gq');
INSERT INTO `amevents_country` VALUES (77, 'Eritrea', 'er');
INSERT INTO `amevents_country` VALUES (78, 'Estonia', 'ee');
INSERT INTO `amevents_country` VALUES (79, 'Ethiopia', 'et');
INSERT INTO `amevents_country` VALUES (80, 'Falkland Islands (malvinas)', 'fk');
INSERT INTO `amevents_country` VALUES (81, 'Faroe Islands', 'fo');
INSERT INTO `amevents_country` VALUES (82, 'Fiji', 'fj');
INSERT INTO `amevents_country` VALUES (83, 'Finland', 'fi');
INSERT INTO `amevents_country` VALUES (84, 'French Guiana', 'gf');
INSERT INTO `amevents_country` VALUES (85, 'French Polynesia', 'pf');
INSERT INTO `amevents_country` VALUES (86, 'French Southern Territories', 'tf');
INSERT INTO `amevents_country` VALUES (87, 'Gabon', 'ga');
INSERT INTO `amevents_country` VALUES (88, 'Gambia', 'gm');
INSERT INTO `amevents_country` VALUES (89, 'Georgia', 'ge');
INSERT INTO `amevents_country` VALUES (90, 'Ghana', 'gh');
INSERT INTO `amevents_country` VALUES (91, 'Gibraltar', 'gi');
INSERT INTO `amevents_country` VALUES (92, 'Greece', 'gr');
INSERT INTO `amevents_country` VALUES (93, 'Greenland', 'gl');
INSERT INTO `amevents_country` VALUES (94, 'Grenada', 'gd');
INSERT INTO `amevents_country` VALUES (95, 'Guadeloupe', 'gp');
INSERT INTO `amevents_country` VALUES (96, 'Guam', 'gu');
INSERT INTO `amevents_country` VALUES (97, 'Guatemala', 'gt');
INSERT INTO `amevents_country` VALUES (98, 'Guinea', 'gn');
INSERT INTO `amevents_country` VALUES (99, 'Guinea-bissau', 'gw');
INSERT INTO `amevents_country` VALUES (100, 'Guyana', 'gy');
INSERT INTO `amevents_country` VALUES (101, 'Haiti', 'ht');
INSERT INTO `amevents_country` VALUES (102, 'Heard Island And Mcdonald Islands', 'hm');
INSERT INTO `amevents_country` VALUES (103, 'Holy See (vatican City State)', 'va');
INSERT INTO `amevents_country` VALUES (104, 'Honduras', 'hn');
INSERT INTO `amevents_country` VALUES (105, 'Hong Kong', 'hk');
INSERT INTO `amevents_country` VALUES (106, 'Hungary', 'hu');
INSERT INTO `amevents_country` VALUES (107, 'Iceland', 'is');
INSERT INTO `amevents_country` VALUES (108, 'India', 'in');
INSERT INTO `amevents_country` VALUES (109, 'Indonesia', 'id');
INSERT INTO `amevents_country` VALUES (110, 'Iran, Islamic Republic Of', 'ir');
INSERT INTO `amevents_country` VALUES (111, 'Iraq', 'iq');
INSERT INTO `amevents_country` VALUES (112, 'Israel', 'il');
INSERT INTO `amevents_country` VALUES (113, 'Italy', 'it');
INSERT INTO `amevents_country` VALUES (114, 'Jamaica', 'jm');
INSERT INTO `amevents_country` VALUES (115, 'Japan', 'jp');
INSERT INTO `amevents_country` VALUES (116, 'Jordan', 'jo');
INSERT INTO `amevents_country` VALUES (117, 'Kazakhstan', 'kz');
INSERT INTO `amevents_country` VALUES (118, 'Kenya', 'ke');
INSERT INTO `amevents_country` VALUES (119, 'Kiribati', 'ki');
INSERT INTO `amevents_country` VALUES (120, 'Korea, Republic Of', 'kr');
INSERT INTO `amevents_country` VALUES (121, 'Kuwait', 'kw');
INSERT INTO `amevents_country` VALUES (122, 'Kyrgyzstan', 'kg');
INSERT INTO `amevents_country` VALUES (123, 'Latvia', 'lv');
INSERT INTO `amevents_country` VALUES (124, 'Lebanon', 'lb');
INSERT INTO `amevents_country` VALUES (125, 'Lesotho', 'ls');
INSERT INTO `amevents_country` VALUES (126, 'Liberia', 'lr');
INSERT INTO `amevents_country` VALUES (127, 'Libyan Arab Jamahiriya', 'ly');
INSERT INTO `amevents_country` VALUES (128, 'Liechtenstein', 'li');
INSERT INTO `amevents_country` VALUES (129, 'Lithuania', 'lt');
INSERT INTO `amevents_country` VALUES (130, 'Luxembourg', 'lu');
INSERT INTO `amevents_country` VALUES (131, 'Macao', 'mo');
INSERT INTO `amevents_country` VALUES (132, 'Macedonia, The Former Yugoslav Republic Of', 'mk');
INSERT INTO `amevents_country` VALUES (133, 'Madagascar', 'mg');
INSERT INTO `amevents_country` VALUES (134, 'Malawi', 'mw');
INSERT INTO `amevents_country` VALUES (135, 'Malaysia', 'my');
INSERT INTO `amevents_country` VALUES (136, 'Maldives', 'mv');
INSERT INTO `amevents_country` VALUES (137, 'Mali', 'ml');
INSERT INTO `amevents_country` VALUES (138, 'Malta', 'mt');
INSERT INTO `amevents_country` VALUES (139, 'Marshall Islands', 'mh');
INSERT INTO `amevents_country` VALUES (140, 'Martinique', 'mq');
INSERT INTO `amevents_country` VALUES (141, 'Mauritania', 'mr');
INSERT INTO `amevents_country` VALUES (142, 'Mauritius', 'mu');
INSERT INTO `amevents_country` VALUES (143, 'Mayotte', 'yt');
INSERT INTO `amevents_country` VALUES (144, 'Mexico', 'mx');
INSERT INTO `amevents_country` VALUES (145, 'Micronesia, Federated States Of', 'fm');
INSERT INTO `amevents_country` VALUES (146, 'Moldova, Republic Of', 'md');
INSERT INTO `amevents_country` VALUES (147, 'Monaco', 'mc');
INSERT INTO `amevents_country` VALUES (148, 'Mongolia', 'mn');
INSERT INTO `amevents_country` VALUES (149, 'Montserrat', 'ms');
INSERT INTO `amevents_country` VALUES (150, 'Morocco', 'ma');
INSERT INTO `amevents_country` VALUES (151, 'Mozambique', 'mz');
INSERT INTO `amevents_country` VALUES (152, 'Myanmar', 'mm');
INSERT INTO `amevents_country` VALUES (153, 'Namibia', 'na');
INSERT INTO `amevents_country` VALUES (154, 'Nauru', 'nr');
INSERT INTO `amevents_country` VALUES (155, 'Nepal', 'np');
INSERT INTO `amevents_country` VALUES (156, 'Netherlands Antilles', 'an');
INSERT INTO `amevents_country` VALUES (157, 'New Caledonia', 'nc');
INSERT INTO `amevents_country` VALUES (158, 'Nicaragua', 'ni');
INSERT INTO `amevents_country` VALUES (159, 'Niger', 'ne');
INSERT INTO `amevents_country` VALUES (160, 'Nigeria', 'ng');
INSERT INTO `amevents_country` VALUES (161, 'Niue', 'nu');
INSERT INTO `amevents_country` VALUES (162, 'Norfolk Island', 'nf');
INSERT INTO `amevents_country` VALUES (163, 'Northern Mariana Islands', 'mp');
INSERT INTO `amevents_country` VALUES (164, 'Oman', 'om');
INSERT INTO `amevents_country` VALUES (165, 'Pakistan', 'pk');
INSERT INTO `amevents_country` VALUES (166, 'Palau', 'pw');
INSERT INTO `amevents_country` VALUES (167, 'Palestinian Territory, Occupied', 'ps');
INSERT INTO `amevents_country` VALUES (168, 'Panama', 'pa');
INSERT INTO `amevents_country` VALUES (169, 'Papua New Guinea', 'pg');
INSERT INTO `amevents_country` VALUES (170, 'Paraguay', 'py');
INSERT INTO `amevents_country` VALUES (171, 'Peru', 'pe');
INSERT INTO `amevents_country` VALUES (172, 'Philippines', 'ph');
INSERT INTO `amevents_country` VALUES (173, 'Pitcairn', 'pn');
INSERT INTO `amevents_country` VALUES (174, 'Poland', 'pl');
INSERT INTO `amevents_country` VALUES (175, 'Portugal', 'pt');
INSERT INTO `amevents_country` VALUES (176, 'Puerto Rico', 'pr');
INSERT INTO `amevents_country` VALUES (177, 'Qatar', 'qa');
INSERT INTO `amevents_country` VALUES (178, 'Reunion', 're');
INSERT INTO `amevents_country` VALUES (179, 'Romania', 'ro');
INSERT INTO `amevents_country` VALUES (180, 'Russian Federation', 'ru');
INSERT INTO `amevents_country` VALUES (181, 'Rwanda', 'rw');
INSERT INTO `amevents_country` VALUES (182, 'Saint Helena', 'sh');
INSERT INTO `amevents_country` VALUES (183, 'Saint Kitts And Nevis', 'kn');
INSERT INTO `amevents_country` VALUES (184, 'Saint Lucia', 'lc');
INSERT INTO `amevents_country` VALUES (185, 'Saint Pierre And Miquelon', 'pm');
INSERT INTO `amevents_country` VALUES (186, 'Saint Vincent And The Grenadines', 'vc');
INSERT INTO `amevents_country` VALUES (187, 'Samoa', 'ws');
INSERT INTO `amevents_country` VALUES (188, 'San Marino', 'sm');
INSERT INTO `amevents_country` VALUES (189, 'Sao Tome And Principe', 'st');
INSERT INTO `amevents_country` VALUES (190, 'Saudi Arabia', 'sa');
INSERT INTO `amevents_country` VALUES (191, 'Senegal', 'sn');
INSERT INTO `amevents_country` VALUES (192, 'Serbia And Montenegro', 'cs');
INSERT INTO `amevents_country` VALUES (193, 'Seychelles', 'sc');
INSERT INTO `amevents_country` VALUES (194, 'Sierra Leone', 'sl');
INSERT INTO `amevents_country` VALUES (195, 'Singapore', 'sg');
INSERT INTO `amevents_country` VALUES (196, 'Slovakia', 'sk');
INSERT INTO `amevents_country` VALUES (197, 'Slovenia', 'si');
INSERT INTO `amevents_country` VALUES (198, 'Solomon Islands', 'sb');
INSERT INTO `amevents_country` VALUES (199, 'Somalia', 'so');
INSERT INTO `amevents_country` VALUES (200, 'South Africa', 'za');
INSERT INTO `amevents_country` VALUES (201, 'South Georgia And The South Sandwich Islands', 'gs');
INSERT INTO `amevents_country` VALUES (202, 'Spain', 'es');
INSERT INTO `amevents_country` VALUES (203, 'Sri Lanka', 'lk');
INSERT INTO `amevents_country` VALUES (204, 'Sudan', 'sd');
INSERT INTO `amevents_country` VALUES (205, 'Suriname', 'sr');
INSERT INTO `amevents_country` VALUES (206, 'Svalbard And Jan Mayen', 'sj');
INSERT INTO `amevents_country` VALUES (207, 'Swaziland', 'sz');
INSERT INTO `amevents_country` VALUES (208, 'Switzerland', 'ch');
INSERT INTO `amevents_country` VALUES (209, 'Syrian Arab Republic', 'sy');
INSERT INTO `amevents_country` VALUES (210, 'Taiwan, Province Of China', 'tw');
INSERT INTO `amevents_country` VALUES (211, 'Tajikistan', 'tj');
INSERT INTO `amevents_country` VALUES (212, 'Tanzania, United Republic Of', 'tz');
INSERT INTO `amevents_country` VALUES (213, 'Thailand', 'th');
INSERT INTO `amevents_country` VALUES (214, 'Timor-leste', 'tl');
INSERT INTO `amevents_country` VALUES (215, 'Togo', 'tg');
INSERT INTO `amevents_country` VALUES (216, 'Tokelau', 'tk');
INSERT INTO `amevents_country` VALUES (217, 'Tonga', 'to');
INSERT INTO `amevents_country` VALUES (218, 'Trinidad And Tobago', 'tt');
INSERT INTO `amevents_country` VALUES (219, 'Tunisia', 'tn');
INSERT INTO `amevents_country` VALUES (220, 'Turkey', 'tr');
INSERT INTO `amevents_country` VALUES (221, 'Turkmenistan', 'tm');
INSERT INTO `amevents_country` VALUES (222, 'Turks And Caicos Islands', 'tc');
INSERT INTO `amevents_country` VALUES (223, 'Tuvalu', 'tv');
INSERT INTO `amevents_country` VALUES (224, 'Uganda', 'ug');
INSERT INTO `amevents_country` VALUES (225, 'Ukraine', 'ua');
INSERT INTO `amevents_country` VALUES (226, 'United Arab Emirates', 'ae');
INSERT INTO `amevents_country` VALUES (227, 'United States Minor Outlying Islands', 'um');
INSERT INTO `amevents_country` VALUES (228, 'Uruguay', 'uy');
INSERT INTO `amevents_country` VALUES (229, 'Uzbekistan', 'uz');
INSERT INTO `amevents_country` VALUES (230, 'Vanuatu', 'vu');
INSERT INTO `amevents_country` VALUES (231, 'Venezuela', 've');
INSERT INTO `amevents_country` VALUES (232, 'Viet Nam', 'vn');
INSERT INTO `amevents_country` VALUES (233, 'Virgin Islands, British', 'vg');
INSERT INTO `amevents_country` VALUES (234, 'Virgin Islands, U.S.', 'vi');
INSERT INTO `amevents_country` VALUES (235, 'Wallis And Futuna', 'wf');
INSERT INTO `amevents_country` VALUES (236, 'Western Sahara', 'eh');
INSERT INTO `amevents_country` VALUES (237, 'Yemen', 'ye');
INSERT INTO `amevents_country` VALUES (238, 'Zambia', 'zm');
INSERT INTO `amevents_country` VALUES (239, 'Zimbabwe', 'zw');
