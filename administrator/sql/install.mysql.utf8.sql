CREATE TABLE IF NOT EXISTS `#__appsconda_compilations` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `appname` varchar(255) NOT NULL,
  `packagename` varchar(255) NOT NULL,
  `entrypage` varchar(255) NOT NULL,
  `appicon` varchar(255) NOT NULL,
  `splashimage` varchar(255) NOT NULL,
  `splashbackground` varchar(255) NOT NULL,
  `sentforcompile` int(11) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `state` int(11) NOT NULL DEFAULT 1,
  `ordering` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB COMMENT="" DEFAULT COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `#__appsconda_custompages` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `image1` varchar(255) NOT NULL,
  `title1` varchar(255) NOT NULL,
  `content1` text NOT NULL,
  `image2` varchar(255) NOT NULL,
  `title2` varchar(255) NOT NULL,
  `content2` text NOT NULL,
  `image3` varchar(255) NOT NULL,
  `title3` varchar(255) NOT NULL,
  `content3` text NOT NULL,
  `image4` varchar(255) NOT NULL,
  `title4` varchar(255) NOT NULL,
  `content4` text NOT NULL,
  `image5` varchar(255) NOT NULL,
  `title5` varchar(255) NOT NULL,
  `content5` text NOT NULL,
  `image6` varchar(255) NOT NULL,
  `title6` varchar(255) NOT NULL,
  `content6` text NOT NULL,
  `image7` varchar(255) NOT NULL,
  `title7` varchar(255) NOT NULL,
  `content7` text NOT NULL,
  `image8` varchar(255) NOT NULL,
  `title8` varchar(255) NOT NULL,
  `content8` text NOT NULL,
  `image9` varchar(255) NOT NULL,
  `title9` varchar(255) NOT NULL,
  `content9` text NOT NULL,
  `image10` varchar(255) NOT NULL,
  `title10` varchar(255) NOT NULL,
  `content10` text NOT NULL,
  `created_by` int(11) NOT NULL,
  `state` int(11) NOT NULL DEFAULT 1,
  `ordering` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB COMMENT="" DEFAULT COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `#__appsconda_drawermenus` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `menu1show` varchar(6) NOT NULL,
  `menu1label` varchar(50) NOT NULL,
  `menu1color` varchar(10) NOT NULL,
  `menu1icon` varchar(255) NOT NULL,
  `menu1access` varchar(5) NOT NULL,
  `menu1contentid` varchar(255) NOT NULL,
  `menu2show` varchar(6) NOT NULL,
  `menu2label` varchar(50) NOT NULL,
  `menu2color` varchar(10) NOT NULL,
  `menu2icon` varchar(255) NOT NULL,
  `menu2access` varchar(5) NOT NULL,
  `menu2contentid` varchar(255) NOT NULL,
  `menu3show` varchar(6) NOT NULL,
  `menu3label` varchar(50) NOT NULL,
  `menu3color` varchar(10) NOT NULL,
  `menu3icon` varchar(255) NOT NULL,
  `menu3access` varchar(5) NOT NULL,
  `menu3contentid` varchar(255) NOT NULL,
  `menu4show` varchar(6) NOT NULL,
  `menu4label` varchar(50) NOT NULL,
  `menu4color` varchar(10) NOT NULL,
  `menu4icon` varchar(255) NOT NULL,
  `menu4access` varchar(5) NOT NULL,
  `menu4contentid` varchar(255) NOT NULL,
  `menu5show` varchar(6) NOT NULL,
  `menu5label` varchar(50) NOT NULL,
  `menu5color` varchar(10) NOT NULL,
  `menu5icon` varchar(255) NOT NULL,
  `menu5access` varchar(5) NOT NULL,
  `menu5contentid` varchar(255) NOT NULL,
  `menu6show` varchar(6) NOT NULL,
  `menu6label` varchar(50) NOT NULL,
  `menu6color` varchar(10) NOT NULL,
  `menu6icon` varchar(255) NOT NULL,
  `menu6access` varchar(5) NOT NULL,
  `menu6contentid` varchar(255) NOT NULL,
  `menu7show` varchar(6) NOT NULL,
  `menu7label` varchar(50) NOT NULL,
  `menu7color` varchar(10) NOT NULL,
  `menu7icon` varchar(255) NOT NULL,
  `menu7access` varchar(5) NOT NULL,
  `menu7contentid` varchar(255) NOT NULL,
  `menu8show` varchar(6) NOT NULL,
  `menu8label` varchar(50) NOT NULL,
  `menu8color` varchar(10) NOT NULL,
  `menu8icon` varchar(255) NOT NULL,
  `menu8access` varchar(5) NOT NULL,
  `menu8contentid` varchar(255) NOT NULL,
  `menu9show` varchar(6) NOT NULL,
  `menu9label` varchar(50) NOT NULL,
  `menu9color` varchar(10) NOT NULL,
  `menu9icon` varchar(255) NOT NULL,
  `menu9access` varchar(5) NOT NULL,
  `menu9contentid` varchar(255) NOT NULL,
  `menu10show` varchar(6) NOT NULL,
  `menu10label` varchar(50) NOT NULL,
  `menu10color` varchar(10) NOT NULL,
  `menu10icon` varchar(255) NOT NULL,
  `menu10access` varchar(5) NOT NULL,
  `youtubeapikey` varchar(255) NOT NULL,
  `youtubechannelid` varchar(255) NOT NULL,
  `menu11show` varchar(6) NOT NULL,
  `menu11label` varchar(50) NOT NULL,
  `menu11color` varchar(10) NOT NULL,
  `menu11icon` varchar(255) NOT NULL,
  `menu11access` varchar(5) NOT NULL,
  `menu11contentid` varchar(255) NOT NULL,
  `menucustompagesshow` varchar(6) NOT NULL,
  `menucustompageslabel` varchar(50) NOT NULL,
  `menucustompagescolor` varchar(10) NOT NULL,
  `menucustompagesicon` varchar(255) NOT NULL,
  `menucustompagesaccess` varchar(5) NOT NULL,
  `menucustompagescontentid` varchar(100) NOT NULL,
  `extrashow` varchar(6) NOT NULL,
  `extralabel` varchar(50) NOT NULL,
  `extraurl` varchar(255) NOT NULL,
  `menusupportshow` varchar(6) NOT NULL,
  `menusupportlabel` varchar(50) NOT NULL,
  `menusupportcolor` varchar(10) NOT NULL,
  `menusupporticon` varchar(255) NOT NULL,
  `menusupportaccess` varchar(5) NOT NULL,
  `supportcatid` int(11) NOT NULL,
  `supportpriorityid` int(11) NOT NULL,
  `supportstatusid` int(11) NOT NULL,
  `imageabovemenu` varchar(255) NOT NULL,
  `loginshow` varchar(6) NOT NULL,
  `loginlabel` varchar(50) NOT NULL,
  `logincolor` varchar(10) NOT NULL,
  `loginicon` varchar(255) NOT NULL,
  `myaccountshow` varchar(6) NOT NULL,
  `myaccountlabel` varchar(50) NOT NULL,
  `myaccountcolor` varchar(10) NOT NULL,
  `myaccounticon` varchar(255) NOT NULL,
  `logoutshow` varchar(6) NOT NULL,
  `logoutlabel` varchar(50) NOT NULL,
  `logoutcolor` varchar(10) NOT NULL,
  `logouticon` varchar(255) NOT NULL,
  `selfcheckinshow` varchar(6) NOT NULL,
  `selfcheckinlabel` varchar(50) NOT NULL,
  `selfcheckinradius` varchar(255) NOT NULL,
  `selfcheckinerror` varchar(255) NOT NULL,
  `selfcheckinsuccess` varchar(255) NOT NULL,
  `selfcheckinerrortime` varchar(255) NOT NULL,
  `selfcheckinerrorlocation` varchar(255) NOT NULL,
  `created_by` int(11) NOT NULL,
  `state` int(11) NOT NULL DEFAULT 1,
  `ordering` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB COMMENT="" DEFAULT COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `#__appsconda_forgotlogin` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `verifycode` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB COMMENT="" DEFAULT COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `#__appsconda_mobileappconfigs` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `menu1show` varchar(6) NOT NULL,
  `menu1label` varchar(50) NOT NULL,
  `menu1color` varchar(10) NOT NULL,
  `menu1icon` varchar(255) NOT NULL,
  `menu1access` varchar(5) NOT NULL,
  `menu1contentid` varchar(255) NOT NULL,
  `menu2show` varchar(6) NOT NULL,
  `menu2label` varchar(50) NOT NULL,
  `menu2color` varchar(10) NOT NULL,
  `menu2icon` varchar(255) NOT NULL,
  `menu2access` varchar(5) NOT NULL,
  `menu2contentid` varchar(255) NOT NULL,
  `menu3show` varchar(6) NOT NULL,
  `menu3label` varchar(50) NOT NULL,
  `menu3color` varchar(10) NOT NULL,
  `menu3icon` varchar(255) NOT NULL,
  `menu3access` varchar(5) NOT NULL,
  `menu3contentid` varchar(255) NOT NULL,
  `menu4show` varchar(6) NOT NULL,
  `menu4label` varchar(50) NOT NULL,
  `menu4color` varchar(10) NOT NULL,
  `menu4icon` varchar(255) NOT NULL,
  `menu4access` varchar(5) NOT NULL,
  `menu4contentid` varchar(255) NOT NULL,
  `menu5show` varchar(6) NOT NULL,
  `menu5label` varchar(50) NOT NULL,
  `menu5color` varchar(10) NOT NULL,
  `menu5icon` varchar(255) NOT NULL,
  `menu5access` varchar(5) NOT NULL,
  `menu5contentid` varchar(255) NOT NULL,
  `menu6show` varchar(6) NOT NULL,
  `menu6label` varchar(50) NOT NULL,
  `menu6color` varchar(10) NOT NULL,
  `menu6icon` varchar(255) NOT NULL,
  `menu6access` varchar(5) NOT NULL,
  `menu6contentid` varchar(255) NOT NULL,
  `menu7show` varchar(6) NOT NULL,
  `menu7label` varchar(50) NOT NULL,
  `menu7color` varchar(10) NOT NULL,
  `menu7icon` varchar(255) NOT NULL,
  `menu7access` varchar(5) NOT NULL,
  `menu7contentid` varchar(255) NOT NULL,
  `menu8show` varchar(6) NOT NULL,
  `menu8label` varchar(50) NOT NULL,
  `menu8color` varchar(10) NOT NULL,
  `menu8icon` varchar(255) NOT NULL,
  `menu8access` varchar(5) NOT NULL,
  `menu8contentid` varchar(255) NOT NULL,
  `menu9show` varchar(6) NOT NULL,
  `menu9label` varchar(50) NOT NULL,
  `menu9color` varchar(10) NOT NULL,
  `menu9icon` varchar(255) NOT NULL,
  `menu9access` varchar(5) NOT NULL,
  `menu9contentid` varchar(255) NOT NULL,
  `menu10show` varchar(6) NOT NULL,
  `menu10label` varchar(50) NOT NULL,
  `menu10color` varchar(10) NOT NULL,
  `menu10icon` varchar(255) NOT NULL,
  `menu10access` varchar(5) NOT NULL,
  `menu10contentid` varchar(255) NOT NULL,
  `menu11show` varchar(6) NOT NULL,
  `menu11label` varchar(50) NOT NULL,
  `menu11color` varchar(10) NOT NULL,
  `menu11icon` varchar(255) NOT NULL,
  `menu11access` varchar(5) NOT NULL,
  `menu11contentid` varchar(255) NOT NULL,
  `menucustompagesshow` varchar(6) NOT NULL,
  `menucustompageslabel` varchar(50) NOT NULL,
  `menucustompagescolor` varchar(10) NOT NULL,
  `menucustompagesicon` varchar(255) NOT NULL,
  `menucustompagesaccess` varchar(5) NOT NULL,
  `menucustompagescontentid` varchar(100) NOT NULL,
  `menusupportshow` varchar(6) NOT NULL,
  `menusupportlabel` varchar(50) NOT NULL,
  `menusupportcolor` varchar(10) NOT NULL,
  `menusupporticon` varchar(255) NOT NULL,
  `menusupportaccess` varchar(5) NOT NULL,
  `imageabovemenu` varchar(255) NOT NULL,
  `titlebgcolor` varchar(10) NOT NULL,
  `titleonlaunch` varchar(255) NOT NULL,
  `titletextcolor` varchar(10) NOT NULL,
  `hamburgercolor` varchar(10) NOT NULL,
  `loginshow` varchar(6) NOT NULL,
  `loginlabel` varchar(50) NOT NULL,
  `logincolor` varchar(10) NOT NULL,
  `loginicon` varchar(255) NOT NULL,
  `myaccountshow` varchar(6) NOT NULL,
  `myaccountlabel` varchar(50) NOT NULL,
  `myaccountcolor` varchar(10) NOT NULL,
  `myaccounticon` varchar(255) NOT NULL,
  `logoutshow` varchar(6) NOT NULL,
  `logoutlabel` varchar(50) NOT NULL,
  `logoutcolor` varchar(10) NOT NULL,
  `logouticon` varchar(255) NOT NULL,
  `selfcheckinshow` varchar(6) NOT NULL,
  `selfcheckinlabel` varchar(50) NOT NULL,
  `selfcheckinradius` varchar(255) NOT NULL,
  `selfcheckinerror` varchar(255) NOT NULL,
  `selfcheckinsuccess` varchar(255) NOT NULL,
  `selfcheckinerrortime` varchar(255) NOT NULL,
  `selfcheckinerrorlocation` varchar(255) NOT NULL,
  `created_by` int(11) NOT NULL,
  `state` int(11) NOT NULL DEFAULT 1,
  `ordering` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB COMMENT="" DEFAULT COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `#__appsconda_mobileapplogins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `deviceidlogin` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB COMMENT="" DEFAULT COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `#__appsconda_mobileconfigs` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `titlebgcolor` varchar(10) NOT NULL,
  `titleonlaunch` varchar(50) NOT NULL,
  `titletextcolor` varchar(10) NOT NULL,
  `hamburgercolor` varchar(10) NOT NULL,
  `backbuttonimage` varchar(255) NOT NULL,
  `selfcheckinradius` varchar(10) NOT NULL,
  `myprofileicon` varchar(255) NOT NULL,
  `myprofilecolor` varchar(10) NOT NULL,
  `myprofilelabel` varchar(50) NOT NULL,
  `myprofileshow` varchar(6) NOT NULL,
  `myeventicon` varchar(255) NOT NULL,
  `myeventcolor` varchar(10) NOT NULL,
  `myeventlabel` varchar(50) NOT NULL,
  `myeventshow` varchar(6) NOT NULL,
  `myordericon` varchar(255) NOT NULL,
  `myordercolor` varchar(10) NOT NULL,
  `myorderlabel` varchar(50) NOT NULL,
  `myordershow` varchar(6) NOT NULL,
  `myticketicon` varchar(255) NOT NULL,
  `myticketcolor` varchar(10) NOT NULL,
  `myticketlabel` varchar(50) NOT NULL,
  `myticketshow` varchar(6) NOT NULL,
  `notifyicon` varchar(255) NOT NULL,
  `notifycolor` varchar(10) NOT NULL,
  `notifylabel` varchar(50) NOT NULL,
  `notifyshow` varchar(6) NOT NULL,
  `checkinadminicon` varchar(255) NOT NULL,
  `checkinadmincolor` varchar(10) NOT NULL,
  `checkinadminlabel` varchar(50) NOT NULL,
  `checkinadminshow` varchar(6) NOT NULL,
  `logouticon` varchar(255) NOT NULL,
  `logoutcolor` varchar(10) NOT NULL,
  `logoutlabel` varchar(50) NOT NULL,
  `logoutshow` varchar(6) NOT NULL,
  `fontsizetitle` varchar(10) NOT NULL,
  `fontsizemenu` varchar(10) NOT NULL,
  `fontsizebody` varchar(10) NOT NULL,
  `fontsizesmall` varchar(255) NOT NULL,
  `buttonbgcolor` varchar(11) NOT NULL,
  `buttontextcolor` varchar(11) NOT NULL,
  `switchcoloron` varchar(10) NOT NULL,
  `switchcoloroff` varchar(10) NOT NULL,
  `forgotpasswordshow` varchar(6) NOT NULL,
  `signupshow` varchar(6) NOT NULL,
  `selfcheckinshow` varchar(6) NOT NULL,
  `firebasejson` text NOT NULL,
  `pmi_client_id` varchar(255) DEFAULT NULL,
  `pmi_client_secret` varchar(255) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `state` int(11) NOT NULL DEFAULT 1,
  `ordering` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB COMMENT="" DEFAULT COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `#__appsconda_mobiledevices` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `juserid` varchar(10) NOT NULL,
  `push` varchar(10) NOT NULL,
  `created_time` varchar(255) NOT NULL,
  `modified_time` varchar(255) NOT NULL,
  `devicetoken` text NOT NULL,
  `created_by` int(11) NOT NULL,
  `state` int(11) NOT NULL DEFAULT 1,
  `ordering` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB COMMENT="" DEFAULT COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `#__appsconda_notificationqueues` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `notification_id` varchar(10) NOT NULL,
  `title` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `token` text NOT NULL,
  `send_date` varchar(255) NOT NULL,
  `created_by` int(11) NOT NULL,
  `state` int(11) NOT NULL DEFAULT 1,
  `ordering` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB COMMENT="" DEFAULT COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `#__appsconda_publications` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_by` int(11) NOT NULL,
  `state` int(11) NOT NULL DEFAULT 1,
  `ordering` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB COMMENT="" DEFAULT COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `#__appsconda_pushs` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `send_date` varchar(255) NOT NULL,
  `created_by` int(11) NOT NULL,
  `state` int(11) NOT NULL DEFAULT 1,
  `ordering` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB COMMENT="" DEFAULT COLLATE=utf8_general_ci;

INSERT INTO `#__appsconda_compilations` (`id`, `appname`, `packagename`, `entrypage`, `appicon`, `splashimage`, `splashbackground`, `sentforcompile`, `created_by`, `state`, `ordering`) VALUES
(1, '', '', '', '', '', '', 0, 0, 1, 1);

INSERT INTO `#__appsconda_drawermenus` (`id`, `menu1show`, `menu1label`, `menu1color`, `menu1icon`, `menu1access`, `menu1contentid`, `menu2show`, `menu2label`, `menu2color`, `menu2icon`, `menu2access`, `menu2contentid`, `menu3show`, `menu3label`, `menu3color`, `menu3icon`, `menu3access`, `menu3contentid`, `menu4show`, `menu4label`, `menu4color`, `menu4icon`, `menu4access`, `menu4contentid`, `menu5show`, `menu5label`, `menu5color`, `menu5icon`, `menu5access`, `menu5contentid`, `menu6show`, `menu6label`, `menu6color`, `menu6icon`, `menu6access`, `menu6contentid`, `menu7show`, `menu7label`, `menu7color`, `menu7icon`, `menu7access`, `menu7contentid`, `menu8show`, `menu8label`, `menu8color`, `menu8icon`, `menu8access`, `menu8contentid`, `menu9show`, `menu9label`, `menu9color`, `menu9icon`, `menu9access`, `menu9contentid`, `menu10show`, `menu10label`, `menu10color`, `menu10icon`, `menu10access`, `youtubeapikey`, `youtubechannelid`, `menu11show`, `menu11label`, `menu11color`, `menu11icon`, `menu11access`, `menu11contentid`, `menucustompagesshow`, `menucustompageslabel`, `menucustompagescolor`, `menucustompagesicon`, `menucustompagesaccess`, `menucustompagescontentid`, `extrashow`, `extralabel`, `extraurl`, `menusupportshow`, `menusupportlabel`, `menusupportcolor`, `menusupporticon`, `menusupportaccess`, `supportcatid`, `supportpriorityid`, `supportstatusid`, `imageabovemenu`, `loginshow`, `loginlabel`, `logincolor`, `loginicon`, `myaccountshow`, `myaccountlabel`, `myaccountcolor`, `myaccounticon`, `logoutshow`, `logoutlabel`, `logoutcolor`, `logouticon`, `selfcheckinshow`, `selfcheckinlabel`, `selfcheckinradius`, `selfcheckinerror`, `selfcheckinsuccess`, `selfcheckinerrortime`, `selfcheckinerrorlocation`, `created_by`, `state`, `ordering`) VALUES
(1, 'false', 'Custom Page 1', '#ff6106', '', 'false', '', 'false', 'Custom Page 2', '#ff6106', '', 'false', '', 'false', 'Articles Category 1', '#ff6106', '', 'false', '', 'false', 'Articles Category 2', '#ff6106', '', 'false', '', 'true', 'Article Categories', '#ff6106', '', 'false', '', 'false', 'Contacts Category', '#ff6106', '', 'false', '', 'false', 'Event Booking', '#ff6106', '', 'false', '', 'false', 'Eshop', '#ff6106', '', 'false', '', 'false', 'Kunena Forum', '#ff6106', '', 'false', '', 'false', 'YouTube Channel', '#ff6106', '', 'false', '', '', 'false', 'SP Easy Image Gallery', '#ff6106', '', 'false', '', 'false', 'Custom Pages', '#ff6106', '', 'false', '', 'false', '', '', 'false', 'Helpdesk Pro', '#ff6106', '', 'false', 0, 0, 0, '', 'true', 'Login', '', '', 'true', 'My Account', '', '', 'true', 'Logout', '', '', '', '', '', '', '', '', '', 0, 1, 0);

INSERT INTO `#__appsconda_mobileconfigs` (`id`, `titlebgcolor`, `titleonlaunch`, `titletextcolor`, `hamburgercolor`, `backbuttonimage`, `selfcheckinradius`, `myprofileicon`, `myprofilecolor`, `myprofilelabel`, `myprofileshow`, `myeventicon`, `myeventcolor`, `myeventlabel`, `myeventshow`, `myordericon`, `myordercolor`, `myorderlabel`, `myordershow`, `myticketicon`, `myticketcolor`, `myticketlabel`, `myticketshow`, `notifyicon`, `notifycolor`, `notifylabel`, `notifyshow`, `checkinadminicon`, `checkinadmincolor`, `checkinadminlabel`, `checkinadminshow`, `logouticon`, `logoutcolor`, `logoutlabel`, `logoutshow`, `fontsizetitle`, `fontsizemenu`, `fontsizebody`, `fontsizesmall`, `buttonbgcolor`, `buttontextcolor`, `switchcoloron`, `switchcoloroff`, `forgotpasswordshow`, `signupshow`, `selfcheckinshow`, `firebasejson`, `pmi_client_id`, `pmi_client_secret`, `created_by`, `state`, `ordering`) VALUES
(1, '#481aa1', 'Welcome', '#ffffff', '#ffffff', '', '100', '', '#481aa1', 'My Profile', 'true', '', '#481aa1', 'My Event', 'false', '', '#481aa1', 'My Orders', 'false', '', '#481aa1', 'My Tickets', 'false', '', '#481aa1', 'Notification Settings', 'true', '', '#481aa1', 'Checkin Admin', 'false', '', '#481aa1', 'Logout', 'true', '20', '18', '16', '13', '#481aa1', '#ffffff', '#11bd22', '#ff0900', 'true', 'true', 'false', '', 64, 1, 1);
