<?php
  if (!defined('IS_ADMIN_FLAG')) {
    die('Illegal Access');
  }
  $zc150 = (PROJECT_VERSION_MAJOR > 1 || (PROJECT_VERSION_MAJOR == 1 && substr(PROJECT_VERSION_MINOR, 0, 3) >= 5));
  // add upgrade script
  if (defined('COOKIE_CONTROL_MODULE_VERSION')) {
    $cc_version = COOKIE_CONTROL_MODULE_VERSION;
    while ($cc_version != '1.3') {
      switch($cc_version) {
        case '1.0':
          // perform upgrade
          if (file_exists(DIR_WS_INCLUDES . 'installers/cookie_control/1_1.php')) {
            include_once(DIR_WS_INCLUDES . 'installers/cookie_control/1_1.php');
            $messageStack->add('Updated Cookie Control to v1.1', 'success');
            $cc_version = '1.1';
          }
          break;
        case '1.1':
          // perform upgrade
          if (file_exists(DIR_WS_INCLUDES . 'installers/cookie_control/1_2.php')) {
            include_once(DIR_WS_INCLUDES . 'installers/cookie_control/1_2.php');
            $messageStack->add('Updated Cookie Control to v1.2', 'success');
            $cc_version = '1.2';
          }
          break;
        case '1.2':
          // perform upgrade
          if (file_exists(DIR_WS_INCLUDES . 'installers/cookie_control/1_3.php')) {
            include_once(DIR_WS_INCLUDES . 'installers/cookie_control/1_3.php');
            $messageStack->add('Updated Cookie Control to v1.3', 'success');
            $cc_version = '1.3';
          }
          break;
        default:
          $cc_version = '1.3';
          // break all the loops
          break 2;      
      }
    }
  } else {
    // do a new install
    if (file_exists(DIR_WS_INCLUDES . 'installers/cookie_control/new_install.php')) {
      include_once(DIR_WS_INCLUDES . 'installers/cookie_control/new_install.php');
      $messageStack->add('Added Cookie Control Configuration', 'success');
    } else {
      $messageStack->add('New installation file missing, please make sure you have uploaded all files in the package.', 'error');
    }
  }

  if ($zc150) { // continue Zen Cart 1.5.x
    // add configuration menu
    if (!zen_page_key_exists('configCookieControl')) {
      $configuration = $db->Execute("SELECT configuration_group_id FROM " . TABLE_CONFIGURATION . " WHERE configuration_key = 'COOKIE_CONTROL_MODULE_VERSION' LIMIT 1;");
      $configuration_group_id = $configuration->fields['configuration_group_id'];
      if ((int)$configuration_group_id > 0) {
        zen_register_admin_page('configCookieControl',
                                'BOX_CONFIGURATION_COOKIECONTROL', 
                                'FILENAME_CONFIGURATION',
                                'gID=' . $configuration_group_id, 
                                'configuration', 
                                'Y',
                                $configuration_group_id);
          
        $messageStack->add('Enabled Cookie Control Configuration menu.', 'success');
      }
    }
  }