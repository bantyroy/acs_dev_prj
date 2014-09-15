/*
Navicat MySQL Data Transfer

Source Server         : Jajabor
Source Server Version : 50527
Source Host           : localhost:3306
Source Database       : acs_dev_prj

Target Server Type    : MYSQL
Target Server Version : 50527
File Encoding         : 65001

Date: 2014-08-08 16:36:38
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `acs_admin_site_settings`
-- ----------------------------
DROP TABLE IF EXISTS `acs_admin_site_settings`;
CREATE TABLE `acs_admin_site_settings` (
  `i_id` int(4) NOT NULL AUTO_INCREMENT,
  `s_admin_email` varchar(255) NOT NULL,
  `s_smtp_host` varchar(255) NOT NULL,
  `s_smtp_password` varchar(255) NOT NULL,
  `s_smtp_userid` varchar(255) NOT NULL,
  `i_records_per_page` int(11) NOT NULL,
  `i_project_posting_approval` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1->On, 0->Off',
  `i_banner_speed` int(11) NOT NULL,
  `i_featured_slider_speed` int(11) NOT NULL,
  `i_auto_slide_control` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1->On, 0->Off',
  `i_featured_project_auto_slide_control` tinyint(4) NOT NULL DEFAULT '1',
  `s_facebook_url` varchar(255) NOT NULL,
  `s_g_plus_url` varchar(255) NOT NULL,
  `s_linked_in_url` varchar(255) NOT NULL,
  `s_twitter_url` varchar(255) NOT NULL,
  `s_rss_feed_url` varchar(255) NOT NULL,
  PRIMARY KEY (`i_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of acs_admin_site_settings
-- ----------------------------
INSERT INTO acs_admin_site_settings VALUES ('1', 'test@gmail.com', 'mail.acumencs.com', 'smtp1234', 'smtp@acumencs.com', '5', '0', '50', '10', '1', '1', 'http://www.facebook.com', 'http://www.google.com', 'http://www.linkedin.in', 'http://www.twitter.com', 'http://www.abc.com');

-- ----------------------------
-- Table structure for `acs_admin_user_type`
-- ----------------------------
DROP TABLE IF EXISTS `acs_admin_user_type`;
CREATE TABLE `acs_admin_user_type` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `s_user_type` varchar(100) CHARACTER SET latin1 NOT NULL,
  `dt_created_on` int(11) NOT NULL,
  `i_status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of acs_admin_user_type
-- ----------------------------
INSERT INTO acs_admin_user_type VALUES ('3', 'Accountant', '1325934926', '1');
INSERT INTO acs_admin_user_type VALUES ('4', 'Editor', '1325934926', '1');
INSERT INTO acs_admin_user_type VALUES ('5', 'Admin', '1325934926', '1');
INSERT INTO acs_admin_user_type VALUES ('6', 'Content Writter', '1325934926', '1');
INSERT INTO acs_admin_user_type VALUES ('7', 'SEO Executive', '1391680706', '1');

-- ----------------------------
-- Table structure for `acs_auto_mail`
-- ----------------------------
DROP TABLE IF EXISTS `acs_auto_mail`;
CREATE TABLE `acs_auto_mail` (
  `i_id` int(11) NOT NULL AUTO_INCREMENT,
  `s_subject` varchar(100) DEFAULT NULL,
  `s_body` text,
  `s_key` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`i_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of acs_auto_mail
-- ----------------------------
INSERT INTO acs_auto_mail VALUES ('1', 'Registration Successful', '<p>Hi [USER],</p>\r\n<p>Thank you for registering at isubtech! You are receiving this email as we received the details from our website. If this was you please <a href=\"[VERIFY_URL]\">Click here</a> to verify your account with us.</p>\r\n<!--<p>Not You? Please <a href=\"[REMOVE_INFORMATION]\">click here</a> to remove your information.</p>-->\r\n<p>&nbsp;</p>\r\n<p><u>Login Details</u>: <br>Username: [USERNAME]<br>Password: [PASSWORD]</p>\r\n<p>&nbsp;</p>\r\n<p>Kind Regards, <br>\r\nisubTECH Team</p>', 'registration_successful');
INSERT INTO acs_auto_mail VALUES ('2', 'Contact Us', '<p>Dear Admin,</p>\r\n<p>You have some contact request.</p>\r\n<p>Details :</p>\r\n<p>Name : [NAME] <br>Email : [EMAIL]<br>Phone : [PHONE]\r\n<br>Company: [COMPANY]\r\n<br>Job Profile: [COMPANYROLE]\r\n<br>Reffer To: [REFFERTO]\r\n<br>Message: [MESSAGE]</p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<p>Regards,<br>isubTECH Team</p>', 'contact_us');
INSERT INTO acs_auto_mail VALUES ('3', 'Contact Form Reply', '<p>Dear [USER],</p>\r\n<p>Thank you for your contact request.</p>[MESSAGE]\r\n<p>&nbsp;&nbsp;\r\n</p><p>Regards,<br>isubTECH Team</p>', 'contact_us_reply');
INSERT INTO acs_auto_mail VALUES ('4', 'Account has been verified', '<p>Hi [USER]</p><p>\r\n</p><p>Thank you for registering at isubTech! You are receiving this email as we received the details from our website. Your account has been verified successfully. Please login to view your account.</p><p></p>\r\n<p>&nbsp;</p>\r\n\r\n<p>Kind Regards, </p>\r\n<p>isubTECH Team</p>', 'account_verified');
INSERT INTO acs_auto_mail VALUES ('5', 'Account has been removed', '<p>Hi [USER]</p><p>\r\n</p><p>Thank you for registering at isubTech! Your account has been removed.</p>\r\n<p>&nbsp;</p>\r\n\r\n<p>Kind Regards, </p>\r\n<p>isubTECH Team</p>', 'account_removed');
INSERT INTO acs_auto_mail VALUES ('6', 'Forgot Password', '<p>Hi [USER],</p>\r\n<p>Your password has been reset. Please login with this new temporary password and change it immediatly.</p>\r\n<p><a rel=\"nofollow\" target=\"_blank\">Click here</a> to login [URL].</p>\r\n<p>&nbsp;</p>\r\n<p><u>Login Details</u>: <br>Email: [EMAIL]<br>Password: [PASSWORD]</p>\r\n<p>&nbsp;</p>\r\n<p>Kind Regards, <br>isubTECH Team</p><br>', 'forgot_password');
INSERT INTO acs_auto_mail VALUES ('7', 'Order Confirmation', '<p>Hi [USER],</p>\r\n<p>Your order has been successfully placed. Thanks you for using isubTech.</p><p>[DETAILS]<br></p><p>Kind Regards, <br>isubTECH Team</p>', 'order_confirmation');
INSERT INTO acs_auto_mail VALUES ('8', 'Job post notification', '<p>Dear [BUYER_NAME],</p>\r\n<p>Thanks for posting your job.</p>\r\n<p>Job title: <strong>[JOB_TITLE]</strong></p>\r\n<p>Job type: [CATEGORY]</p>\r\n<p>Your job has been submitted successfully.&nbsp;</p>\r\n<p>For any status change, you will be notified immediately.&nbsp;</p>\r\n<p>Sincerely,<br></p>\r\n<p><strong>iSubTech Team </strong></p>\r\n<p><a target=\"_blank\" rel=\"nofollow\"></a></p>', 'job_posted');
INSERT INTO acs_auto_mail VALUES ('9', 'Job Edit Mail for Buyer', '<p>Dear [BUYER_NAME],</p><p>Your job has been edited successfully.</p><p>Job title:&nbsp;<strong>[JOB_TITLE]</strong></p><p>Job type: [CATEGORY]</p><p>For any status change, you will be notified immediately.&nbsp;<br></p><p>Sincerely,<br></p><p><strong>iSubTech Team</strong></p>', 'job_edited_for_buyer');
INSERT INTO acs_auto_mail VALUES ('10', 'Job Edit Notification', '<p>Dear [TRADESMAN_NAME],</p><p>The following project has been edited.</p><p>Job title:&nbsp;<strong>[JOB_TITLE]</strong></p><p>Job type: [CATEGORY]</p><p>Please visit your dashboard to view the details.&nbsp;</p><p>For any status change, you will be notified immediately.&nbsp;</p><p>Sincerely,<br></p><p><strong>iSubTech Team</strong></p>', 'job_edited_for_tradesman');

-- ----------------------------
-- Table structure for `acs_category`
-- ----------------------------
DROP TABLE IF EXISTS `acs_category`;
CREATE TABLE `acs_category` (
  `i_id` int(11) NOT NULL AUTO_INCREMENT,
  `s_category` varchar(60) NOT NULL COMMENT '"_req" stands for its requred field',
  `s_category_description` varchar(500) DEFAULT NULL,
  `s_image` varchar(255) DEFAULT NULL,
  `s_date` varchar(255) DEFAULT NULL,
  `s_another_image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`i_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of acs_category
-- ----------------------------
INSERT INTO acs_category VALUES ('1', 'Mrinmoy_1', 'Is that really works', null, null, null);
INSERT INTO acs_category VALUES ('3', 'Mrinmoy_3', 'Is that really works', 'eid_mubarak_1406812349.jpg', null, null);
INSERT INTO acs_category VALUES ('4', 'Mrinmoy_4', 'Yes it\'s really working', '14783360205_f77b4fbf18_c_1406879760.jpg', null, null);
INSERT INTO acs_category VALUES ('5', 'Test', 'hjhasjkdhfjas', '14783360205_f77b4fbf18_c_1406901071.jpg', '1./10/2015', 'icici_bank_1406901071.png');

-- ----------------------------
-- Table structure for `acs_country`
-- ----------------------------
DROP TABLE IF EXISTS `acs_country`;
CREATE TABLE `acs_country` (
  `i_id` int(11) NOT NULL AUTO_INCREMENT,
  `i_state` varchar(100) DEFAULT NULL,
  `s_county` varchar(255) DEFAULT NULL,
  `d_county_surtax` double DEFAULT '0',
  PRIMARY KEY (`i_id`),
  KEY `i_state_id` (`i_state`),
  KEY `id` (`i_id`)
) ENGINE=MyISAM AUTO_INCREMENT=69 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of acs_country
-- ----------------------------
INSERT INTO acs_country VALUES ('1', '9', 'Hillsborough', '1');
INSERT INTO acs_country VALUES ('2', '9', 'Alachua', '0');
INSERT INTO acs_country VALUES ('3', '9', 'Baker', '1');
INSERT INTO acs_country VALUES ('4', '9', 'Bay', '0.5');
INSERT INTO acs_country VALUES ('5', '9', 'Bradford', '1');
INSERT INTO acs_country VALUES ('6', '9', 'Brevard', '0');
INSERT INTO acs_country VALUES ('7', '9', 'Broward', '0');
INSERT INTO acs_country VALUES ('8', '9', 'Calhoun', '1.5');
INSERT INTO acs_country VALUES ('9', '9', 'Charlotte', '1');
INSERT INTO acs_country VALUES ('10', '9', 'Citrus', '0');
INSERT INTO acs_country VALUES ('11', '9', 'Clay', '1');
INSERT INTO acs_country VALUES ('12', '9', 'Collier', '0');
INSERT INTO acs_country VALUES ('13', '9', 'Columbia', '1');
INSERT INTO acs_country VALUES ('14', '9', 'Dade', '1');
INSERT INTO acs_country VALUES ('15', '9', 'De Soto', '1');
INSERT INTO acs_country VALUES ('16', '9', 'Dixie', '1');
INSERT INTO acs_country VALUES ('17', '9', 'Duval', '1');
INSERT INTO acs_country VALUES ('18', '9', 'Escambia', '1.5');
INSERT INTO acs_country VALUES ('19', '9', 'Flagler', '1');
INSERT INTO acs_country VALUES ('20', '9', 'Franklin', '1');
INSERT INTO acs_country VALUES ('21', '9', 'Gadsden', '1.5');
INSERT INTO acs_country VALUES ('22', '9', 'Gilchrist', '1');
INSERT INTO acs_country VALUES ('23', '9', 'Glades', '1');
INSERT INTO acs_country VALUES ('24', '9', 'Gulf', '1');
INSERT INTO acs_country VALUES ('25', '9', 'Hamilton', '1');
INSERT INTO acs_country VALUES ('26', '9', 'Hardee', '1');
INSERT INTO acs_country VALUES ('27', '9', 'Hendry', '1');
INSERT INTO acs_country VALUES ('28', '9', 'Hernando', '0.5');
INSERT INTO acs_country VALUES ('29', '9', 'Highlands', '1');
INSERT INTO acs_country VALUES ('30', '9', 'Holmes', '1');
INSERT INTO acs_country VALUES ('31', '9', 'Indian River', '1');
INSERT INTO acs_country VALUES ('32', '9', 'Jackson', '1.5');
INSERT INTO acs_country VALUES ('33', '9', 'Jefferson', '1');
INSERT INTO acs_country VALUES ('34', '9', 'Lafayette', '1');
INSERT INTO acs_country VALUES ('35', '9', 'Lake', '1');
INSERT INTO acs_country VALUES ('36', '9', 'Lee', '0');
INSERT INTO acs_country VALUES ('37', '9', 'Leon', '1.5');
INSERT INTO acs_country VALUES ('38', '9', 'Levy', '1');
INSERT INTO acs_country VALUES ('39', '9', 'Liberty', '1.5');
INSERT INTO acs_country VALUES ('40', '9', 'Madison', '1.5');
INSERT INTO acs_country VALUES ('41', '9', 'Manatee', '0.5');
INSERT INTO acs_country VALUES ('42', '9', 'Marion', '0');
INSERT INTO acs_country VALUES ('43', '9', 'Martin', '0');
INSERT INTO acs_country VALUES ('44', '9', 'Miami-Dade', '1');
INSERT INTO acs_country VALUES ('45', '9', 'Monroe', '1.5');
INSERT INTO acs_country VALUES ('46', '9', 'Nassau', '1');
INSERT INTO acs_country VALUES ('47', '9', 'Okaloosa', '0');
INSERT INTO acs_country VALUES ('48', '9', 'Okeechobee', '1');
INSERT INTO acs_country VALUES ('49', '9', 'Orange', '0.5');
INSERT INTO acs_country VALUES ('50', '9', 'Osceola', '1');
INSERT INTO acs_country VALUES ('51', '9', 'Palm Beach', '0');
INSERT INTO acs_country VALUES ('52', '9', 'Pasco', '1');
INSERT INTO acs_country VALUES ('53', '9', 'Pinellas', '1');
INSERT INTO acs_country VALUES ('54', '9', 'Polk', '1');
INSERT INTO acs_country VALUES ('55', '9', 'Putnam', '1');
INSERT INTO acs_country VALUES ('56', '9', 'St. Johns', '0');
INSERT INTO acs_country VALUES ('57', '9', 'St. Lucie', '0.5');
INSERT INTO acs_country VALUES ('58', '9', 'Santa Rosa', '0.5');
INSERT INTO acs_country VALUES ('59', '9', 'Sarasota', '1');
INSERT INTO acs_country VALUES ('60', '9', 'Seminole', '0');
INSERT INTO acs_country VALUES ('61', '9', 'Sumter', '1');
INSERT INTO acs_country VALUES ('62', '9', 'Suwannee', '1');
INSERT INTO acs_country VALUES ('63', '9', 'Taylor', '1');
INSERT INTO acs_country VALUES ('64', '9', 'Union', '1');
INSERT INTO acs_country VALUES ('65', '9', 'Volusia', '0.5');
INSERT INTO acs_country VALUES ('66', '9', 'Wakulla', '1');
INSERT INTO acs_country VALUES ('67', '9', 'Walton', '1.5');
INSERT INTO acs_country VALUES ('68', '9', 'Washington', '1');

-- ----------------------------
-- Table structure for `acs_language`
-- ----------------------------
DROP TABLE IF EXISTS `acs_language`;
CREATE TABLE `acs_language` (
  `i_id` int(11) NOT NULL AUTO_INCREMENT,
  `s_language` varchar(50) DEFAULT NULL,
  `i_country_id` int(11) NOT NULL,
  `i_status` tinyint(1) DEFAULT '1' COMMENT '1-> Active, 0-> Inactive',
  PRIMARY KEY (`i_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of acs_language
-- ----------------------------
INSERT INTO acs_language VALUES ('1', 'English (en)', '2', '1');
INSERT INTO acs_language VALUES ('2', 'English', '2', '1');

-- ----------------------------
-- Table structure for `acs_menu`
-- ----------------------------
DROP TABLE IF EXISTS `acs_menu`;
CREATE TABLE `acs_menu` (
  `i_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '(PK)',
  `s_name` varchar(255) NOT NULL,
  `s_link` text NOT NULL COMMENT 'excluding the base_url(). e.g.-dashboard/',
  `i_parent_id` smallint(4) NOT NULL,
  `i_main_id` smallint(4) NOT NULL,
  `s_action_permit` text NOT NULL,
  `s_icon_class` varchar(100) NOT NULL DEFAULT 'icon-home',
  `en_s_name` varchar(255) NOT NULL,
  `ar_s_name` varchar(255) NOT NULL,
  `i_display_order` tinyint(2) NOT NULL,
  PRIMARY KEY (`i_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of acs_menu
-- ----------------------------
INSERT INTO acs_menu VALUES ('1', 'General', '', '0', '0', '', 'icon-home', 'General', 'General', '0');
INSERT INTO acs_menu VALUES ('2', 'Dashboard', 'dashboard/', '1', '1', '', 'icon-home', 'Dashboard', 'Dashboard', '0');
INSERT INTO acs_menu VALUES ('3', 'My Account', 'my_account/', '1', '1', 'Edit', 'icon-home', 'My Account', 'My Account', '0');
INSERT INTO acs_menu VALUES ('4', 'Site Setting', 'site_setting/', '1', '1', 'Edit', 'icon-home', 'Site Setting', 'Site Setting', '0');
INSERT INTO acs_menu VALUES ('5', 'Admin User', '', '0', '0', '', 'icon-home', 'Admin User', 'Admin User', '0');
INSERT INTO acs_menu VALUES ('6', 'User Type Access', 'user_type_master/', '5', '5', 'View List||Add||Edit||Access Control', 'icon-home', 'User Type Access', 'User Type Access', '0');
INSERT INTO acs_menu VALUES ('7', 'Admin User', 'manage_admin_user/', '5', '5', 'View List||View Detail||Add||Edit||Delete', 'icon-home', 'Admin User', 'Admin User', '0');
INSERT INTO acs_menu VALUES ('8', 'Core', '', '0', '0', '', 'icon-home', 'Core', 'Core', '0');
INSERT INTO acs_menu VALUES ('9', 'Generate CRUD', 'generate_crud/', '8', '8', 'View List||Generate', 'icon-home', 'Generate CRUD', 'Generate CRUD', '0');
INSERT INTO acs_menu VALUES ('10', 'Menu Setting', 'menu_setting/', '8', '8', 'Menu Permission||View List||Sub Menu List', 'icon-home', 'Menu Setting', 'Menu Setting', '0');
INSERT INTO acs_menu VALUES ('11', 'Product', 'product/', '1', '1', 'View List||View Detail||Add||Edit||Delete', 'icon-home', 'Product', '', '0');

-- ----------------------------
-- Table structure for `acs_menu_permit`
-- ----------------------------
DROP TABLE IF EXISTS `acs_menu_permit`;
CREATE TABLE `acs_menu_permit` (
  `i_id` int(11) NOT NULL AUTO_INCREMENT,
  `i_menu_id` int(11) NOT NULL COMMENT 'this can be 0 if the action is default',
  `s_action` varchar(100) NOT NULL COMMENT 'Default =>available for all user types, ex: ajax, login page, home page etc.',
  `s_link` text NOT NULL COMMENT 'excluding the base_url(). e.g.-dashboard/',
  `i_user_type` tinyint(2) NOT NULL COMMENT '0->Super Admin,1->Sub Admin',
  PRIMARY KEY (`i_id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of acs_menu_permit
-- ----------------------------
INSERT INTO acs_menu_permit VALUES ('1', '0', 'Default', 'home/', '0');
INSERT INTO acs_menu_permit VALUES ('2', '0', 'Default', 'home/logout', '0');
INSERT INTO acs_menu_permit VALUES ('3', '0', 'Default', 'home/ajax_menu_track/', '0');
INSERT INTO acs_menu_permit VALUES ('4', '0', 'Default', 'error_404/', '0');
INSERT INTO acs_menu_permit VALUES ('5', '10', 'Menu Permission', 'menu_setting/menu_permission/', '0');
INSERT INTO acs_menu_permit VALUES ('6', '10', 'View List', 'menu_setting/show_list/', '0');
INSERT INTO acs_menu_permit VALUES ('7', '10', 'Sub Menu List', 'menu_setting/sub_menu_list/', '0');
INSERT INTO acs_menu_permit VALUES ('8', '2', 'Edit', 'dashboard/modify_information/', '0');
INSERT INTO acs_menu_permit VALUES ('9', '3', 'Edit', 'my_account/modify_information/', '0');
INSERT INTO acs_menu_permit VALUES ('10', '4', 'Edit', 'site_setting/modify_information/', '0');
INSERT INTO acs_menu_permit VALUES ('11', '6', 'View List', 'user_type_master/show_list/', '0');
INSERT INTO acs_menu_permit VALUES ('12', '6', 'Add', 'user_type_master/add_information/', '0');
INSERT INTO acs_menu_permit VALUES ('13', '6', 'Edit', 'user_type_master/modify_information/', '0');
INSERT INTO acs_menu_permit VALUES ('14', '6', 'Access Control', 'user_type_master/access_control/', '0');
INSERT INTO acs_menu_permit VALUES ('15', '7', 'View List', 'manage_admin_user/show_list/', '0');
INSERT INTO acs_menu_permit VALUES ('16', '7', 'View Detail', 'manage_admin_user/view_detail/', '0');
INSERT INTO acs_menu_permit VALUES ('17', '7', 'Add', 'manage_admin_user/add_information/', '0');
INSERT INTO acs_menu_permit VALUES ('18', '7', 'Edit', 'manage_admin_user/modify_information/', '0');
INSERT INTO acs_menu_permit VALUES ('19', '7', 'Delete', 'manage_admin_user/delete_information/', '0');
INSERT INTO acs_menu_permit VALUES ('20', '9', 'View List', 'generate_crud/index/', '0');
INSERT INTO acs_menu_permit VALUES ('21', '9', 'Generate', 'generate_crud/generate/', '0');
INSERT INTO acs_menu_permit VALUES ('22', '2', 'Default', 'dashboard/set_menu_session/', '0');
INSERT INTO acs_menu_permit VALUES ('23', '11', 'View List', 'product/show_list/', '0');
INSERT INTO acs_menu_permit VALUES ('24', '11', 'View Detail', 'product/view_detail/', '0');
INSERT INTO acs_menu_permit VALUES ('25', '11', 'Add', 'product/add_information/', '0');
INSERT INTO acs_menu_permit VALUES ('26', '11', 'Edit', 'product/modify_information/', '0');
INSERT INTO acs_menu_permit VALUES ('27', '11', 'Delete', 'product/delete_information/', '0');

-- ----------------------------
-- Table structure for `acs_product`
-- ----------------------------
DROP TABLE IF EXISTS `acs_product`;
CREATE TABLE `acs_product` (
  `i_id` int(11) NOT NULL AUTO_INCREMENT,
  `i_category_id` int(11) NOT NULL,
  `s_product_name` varchar(80) NOT NULL COMMENT '"_req" stands for required field',
  `s_product_description` text,
  `s_product_image` varchar(255) DEFAULT NULL,
  `f_price` float(8,2) NOT NULL DEFAULT '0.00',
  `i_quantity` int(10) NOT NULL DEFAULT '0',
  `e_color` enum('Red','Green','Blue','Black','Brown') DEFAULT NULL,
  `i_status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1-> Active, 0-> Inactive',
  PRIMARY KEY (`i_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of acs_product
-- ----------------------------
INSERT INTO acs_product VALUES ('1', '1', 'Test Product', 'Located on the east bank of the Hooghly river, it is the principal commercial, cultural, and educational centre of East India, while the Port of ', '64570f21f506b6d6a83ec2af0621148b_1407334557.jpg', '12.00', '150', '', '1');
INSERT INTO acs_product VALUES ('2', '3', 'Mrinsss', 'test etst el jklg jdfklgj dfljgklsdfjl kdfj jsdfklgjsdfklgdsfgsdf gsdfklgsdflk gjsdfgsdfg sdfgsdfg ksdflgkl;sdfg', '0', '20.00', '120', '', '1');

-- ----------------------------
-- Table structure for `acs_user`
-- ----------------------------
DROP TABLE IF EXISTS `acs_user`;
CREATE TABLE `acs_user` (
  `i_id` int(8) NOT NULL AUTO_INCREMENT,
  `s_first_name` varchar(255) NOT NULL,
  `s_last_name` varchar(255) NOT NULL,
  `s_user_name` varchar(255) NOT NULL,
  `s_email` varchar(255) NOT NULL,
  `s_password` varchar(255) NOT NULL,
  `s_address` text NOT NULL,
  `s_contact_number` varchar(20) NOT NULL,
  `i_created_by` int(11) NOT NULL,
  `i_user_type` tinyint(2) NOT NULL DEFAULT '2' COMMENT '0-> Super Admin, 1-> Front End User (Customer), 2-> Front End User (Supplier),  Greter than 2 Admin User',
  `s_password_hints` varchar(255) DEFAULT NULL,
  `s_password_answer` varchar(255) DEFAULT NULL,
  `s_verification_code` char(21) DEFAULT NULL,
  `e_is_newsletter` enum('no','yes') DEFAULT 'no',
  `dt_created_on` datetime NOT NULL,
  `i_is_verified` tinyint(1) DEFAULT '0' COMMENT '0-> Not Verified, 1-> Verified',
  `i_available_bids` bigint(20) DEFAULT '0',
  `i_used_bids` bigint(20) DEFAULT '0',
  `i_status` tinyint(2) NOT NULL COMMENT '0-> active, 1-> inactive',
  `s_avatar` varchar(255) NOT NULL,
  `s_chat_im` varchar(255) NOT NULL,
  PRIMARY KEY (`i_id`),
  UNIQUE KEY `email` (`s_email`),
  UNIQUE KEY `varification_code` (`s_verification_code`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of acs_user
-- ----------------------------
INSERT INTO acs_user VALUES ('1', 'Super', 'Admin', 'super_admin', 'test@gmail.com', 'adb8835820ebfbfb94d78a5023ba2e03', 'UAE', '11111111111', '1', '0', null, null, null, 'no', '2014-01-30 17:28:00', '0', '0', '0', '1', 'avatar5.png', 'Skype: test_skype, Gmail: test.001');
INSERT INTO acs_user VALUES ('2', 'admin ', 'user1', 'adminuser1', 'adminuser1@gmail.com', 'c661fbba3f9f9784d4d74713c8397d09', '', '', '1', '3', null, null, null, 'no', '2014-01-30 17:28:00', '0', '0', '0', '1', '', '');
INSERT INTO acs_user VALUES ('3', 'Admin', 'User2', 'adminuser2', 'adminuser2@gmail.com', 'c661fbba3f9f9784d4d74713c8397d09', '', '', '1', '7', null, null, 'F5XJS8OKSJ-1393413289', 'no', '2014-01-30 17:33:00', '0', '0', '0', '1', '', '');
INSERT INTO acs_user VALUES ('6', 'Cynthia', 'GreenWood', 'cynthia', 'cynthiagreenw@gmail.com', 'fa14e287fe84499885077c190e1149b7', '', '', '0', '1', 'What is my name', 'Cynthia', 'JWSMJNPSFF-1393416817', 'yes', '2014-02-26 17:54:43', '1', '2550', '0', '1', '', '');
INSERT INTO acs_user VALUES ('7', 'Supplier', 'Dev', 'supplier', 'ban2demo@gmail.com', 'fa14e287fe84499885077c190e1149b7', '', '', '0', '2', 'hi', 'hihi', '4RD5YSS4SD-1393500430', 'yes', '2014-02-27 16:57:10', '1', '1400', '0', '1', '', '');
