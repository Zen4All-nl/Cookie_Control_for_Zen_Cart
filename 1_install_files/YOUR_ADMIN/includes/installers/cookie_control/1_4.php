<?php
  $db->Execute("UPDATE " . TABLE_CONFIGURATION . " SET configuration_value = '1.4' WHERE configuration_key = 'COOKIE_CONTROL_MODULE_VERSION' LIMIT 1;");
  $configuration = $db->Execute("SELECT configuration_group_id FROM " . TABLE_CONFIGURATION_GROUP . " WHERE configuration_group_title = 'Cookie Control Configuration' LIMIT 1;");
  $configuration_group_id = $configuration->fields['configuration_group_id'];
  if ($configuration_group_id > 0) {
  $db->Execute("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES
      ('Hide Cookie Control after consent?', 'COOKIE_CONTROL_HIDE', 'false', 'If you want to hide the Cookie Control icon after the user has given consent set to true', " . $configuration_group_id . ", 65, NOW(), NOW(), NULL, 'zen_cfg_select_option(array(\"true\", \"false\"),');"
    );
  }