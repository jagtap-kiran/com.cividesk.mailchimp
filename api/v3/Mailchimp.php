<?php

//not sure why this is required but didn't seem to autoload
require_once 'CMC/BAO/Setting.php';
/**
 * Create or update a discount code
 *
 * @param array $params  Associative array of property
 *                       name/value pairs to insert in new 'item'
 *
 * @return array api result array
 * {@getfields item_create}
 * @access public
 */
function civicrm_api3_mailchimp_create($params) {
  return _civicrm_api3_basic_create('CMC_BAO_Setting', $params);
}

/**
 * Returns array of items  matching a set of one or more item properties
 *
 * @param array $params  Array of one or more valid property_name=>value pairs. If $params is set
 *                       as null, all items will be returned
 *
 * @return array api result array
 * {@getfields item_get}
 * @access public
 */
function civicrm_api3_mailchimp_get($params) {
  return _civicrm_api3_basic_get('CMC_BAO_Setting', $params);
}

/**
 * delete an existing item
 *
 * This method is used to delete any existing item. id of the group
 * to be deleted is required field in $params array
 *
 * @param array $params array containing id of the item to be deleted
 *
 * @return array API result Array
 * {@getfields item_delete}
 * @access public
 */
function civicrm_api3_mailchimp_delete($params) {
  return _civicrm_api3_basic_delete('CMC_DAO_Setting', $params);
}

/**
 * Run mailchimp script an existing item
 *
 * This method is used to delete any existing item. id of the group
 * to be deleted is required field in $params array
 *
 * @param array $params array containing id of the item to be deleted
 *
 * @return array API result Array
 * {@getfields item_delete}
 * @access public
 */
function civicrm_api3_mailchimp_run() {
    
    require_once 'api/api.php';
    $setting = civicrm_api('Mailchimp', 'get', array('version' => '3', 'is_active' => 1));
    
    if (empty($setting) || $setting['is_error']) {
       $settingURL = CRM_Utils_System::url('civicrm/civimailchimp', 'reset=1'); 
       $statusMsg = ts("There are no valid mailchimp settings available, Please <a href='%1'>click here to configure</a>.", array(1 => $settingURL)); 
       CRM_Core_Session::setStatus($statusMsg);
       
       return false; 
    }
    
    $id = null;
    if (isset($setting['id'])) {
        $id = $setting['id'];
    }

    $values = array();
    if (isset($setting['values'][$id]) && is_array($setting['values'][$id])) {
        $values = $setting['values'][$id];
    }
    
    $baseUrl = $apiKey = $listId = null;
    if (isset($values['base_url'])) {
        $baseUrl = $values['base_url'];
    }
    if (isset($values['api_key'])) {
        $apiKey = $values['api_key'];
    }
    if (isset($values['list_id'])) {
        $listId = $values['list_id'];
    }
    
    if (!$apiKey || !$listId) {
       $settingURL = CRM_Utils_System::url('civicrm/civimailchimp', 'reset=1'); 
       $statusMsg = ts("There are no valid mailchimp settings available, Please <a href='%1'>click here to configure</a>.", array(1 => $settingURL)); 
       CRM_Core_Session::setStatus($statusMsg);
       return false; 
    }
    
    ini_set('display_errors', 1);
    
    require_once 'bin/mailchimp_sync.php';
    $params = array('debugging' => 'on',
                    'display_errors' => 1,
                    'base_url' => $baseUrl,
                    'apikey' => $apiKey,
                    'list_id' => $listId,
                    'api_run' => true);
    
    //run script.
    mailchimpSync::run($params);
    
    CRM_Utils_System::civiExit();
}