<?php

$configuration = $db->Execute("SELECT configuration_group_id FROM " . TABLE_CONFIGURATION_GROUP . " WHERE configuration_group_title = 'Cookie Control Configuration' ORDER BY configuration_group_id ASC;");
if ($configuration->RecordCount() > 0) {
  while (!$configuration->EOF) {
    $db->Execute("DELETE FROM " . TABLE_CONFIGURATION . " WHERE configuration_group_id = " . $configuration->fields['configuration_group_id'] . ";");
    $db->Execute("DELETE FROM " . TABLE_CONFIGURATION_GROUP . " WHERE configuration_group_id = " . $configuration->fields['configuration_group_id'] . ";");
    $configuration->MoveNext();
  }
}
#$db->Execute("DELETE FROM " . TABLE_CONFIGURATION . " WHERE configuration_group_id = 0;");
$db->Execute("DELETE FROM " . TABLE_CONFIGURATION . " WHERE configuration_key = '';");

$db->Execute("INSERT INTO " . TABLE_CONFIGURATION_GROUP . " (configuration_group_title, configuration_group_description, sort_order, visible) VALUES ('Cookie Control Configuration', 'Set Cookie Control Options', '1', '1');");
$configuration_group_id = $db->Insert_ID();

$db->Execute("UPDATE " . TABLE_CONFIGURATION_GROUP . " SET sort_order = " . $configuration_group_id . " WHERE configuration_group_id = " . $configuration_group_id . ";");

$db->Execute("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES
  ('Version', 'COOKIE_CONTROL_MODULE_VERSION', '1.0', 'Version installed:', " . $configuration_group_id . ", 10, NOW(), NOW(), NULL, 'trim('),
  ('Position your icon', 'COOKIE_CONTROL_POSITION', 'left', 'Choose whether you would like your icon to appear on the left or right of the browser window.', " . $configuration_group_id . ", 20, NOW(), NOW(), NULL, 'zen_cfg_select_option(array(\"left\", \"right\"),'),
  ('Choose your icon', 'COOKIE_CONTROL_SHAPE', 'triangle', 'The icon will be anchored to the corner of the viewport and won\'t scroll with your web page.', " . $configuration_group_id . ", 30, NOW(), NOW(), NULL, 'zen_cfg_select_option(array(\"triangle\", \"diamond\"),'),
  ('Choose your theme', 'COOKIE_CONTROL_THEME', 'light', 'Choose whether you would prefer the Cookie Control widget to have a light or dark display.', " . $configuration_group_id . ", 40, NOW(), NOW(), NULL, 'zen_cfg_select_option(array(\"light\", \"dark\"),'),
  ('Pop up by default', 'COOKIE_CONTROL_STARTOPEN', 'true', 'Choose whether the Cookie Control user interface (UI) is open by default on page load. This makes it much more explicit that you\'re seeking user\'s consent for the use of cookies, and may be a safer option in terms of compliance, until Cookie Control icon is widely recognised.', " . $configuration_group_id . ", 50, NOW(), NOW(), NULL, 'zen_cfg_select_option(array(\"true\", \"false\"),'),
  ('Set autohide time', 'COOKIE_CONTROL_AUTOHIDE', '6000', 'Choose how long the popup will be sown. Set the time in miliseconds (default = 6000).', " . $configuration_group_id . ", 60, NOW(), NOW(), NULL, NULL),
  ('Set protected cookies', 'COOKIE_CONTROL_PROTECTEDCOOKIES', NULL, 'list the cookies you do not want deleted. Comma seperated => analytics,twitter', " . $configuration_group_id . ", 70, NOW(), NOW(), NULL, NULL),
  ('Choose your Consent Model', 'COOKIE_CONTROL_CONSENTMODEL', 'implicit', 'Select the consent model you wish Cookie Control to use. In each consent model the Cookie Control panel appears to the user when they first access the site.<br /><br /><strong>Information Only</strong><br />Informs users the site is using cookies. They are given no option to opt out.<br /><br /><strong>Implict</strong><br />Informs users the site is using cookies and they are given the option to opt out.<br /><br /><strong>Explicit</strong><br />Informs users the site would like to use cookies and they are given the option to opt in.', " . $configuration_group_id . ", 80, NOW(), NOW(), NULL, 'zen_cfg_select_option(array(\"information_only\", \"implicit\", \"explicit\"),'),
  ('Apply to subdomains', 'COOKIE_CONTROL_SUBDOMAINS', 'false', 'If you have multiple sub-domains, you can choose whether Cookie Control opt-ins apply across all sub-domains or just a single domain.<br />E.g. if your main site is at www.mysite.com and your blog is at blog.mysite.com, you\'d probably want a single opt-in to apply across both sites. If you select \"No\", users will have to give there consent once on each site.', " . $configuration_group_id . ", 90, NOW(), NOW(), NULL, 'zen_cfg_select_option(array(\"true\", \"false\"),'),
  ('Countries for showing Cookie Control', 'COOKIE_CONTROL_COUNTRIES', 'Netherlands,Belgium', 'Please enter the list of countries for which you wish the plugin to appear. If left blank Cookie Control will appear for all users from all countries. The full list of countries can be found <a href=\"http://www.geoplugin.com/iso3166\" target=\"_blank\" style=\"text-decoration: none; font-weight: bold;\">here</a>', " . $configuration_group_id . ", 100, NOW(), NOW(), NULL, NULL),
  ('Google Analytics', 'COOKIE_CONTROL_GOOGLE_ANALYTICS', 'UA-XXXXXX-X', 'If you use Google Analytics, enter your Google Analytics key here. This will cause Cookie Control to interact with Google Analytics, opting users in or out depending on their preference.', " . $configuration_group_id . ", 110, NOW(), NOW(), NULL, NULL);");