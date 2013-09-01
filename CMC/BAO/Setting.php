<?php
require_once 'CMC/DAO/Setting.php';

class CMC_BAO_Setting extends CMC_DAO_Setting {

  /**
   * class constructor
   */
  function __construct() {
    parent::__construct();
  }

  /**
   * Takes an associative array and creates a mailchimp setting
   *
   * This function extracts all the params it needs to initialize the created
   * mailchimp setting. The params array could contain additional unused name/value
   * pairs
   *
   * @param array  $params (reference ) an assoc array of name/value pairs
   *
   * @return object CMC_BAO_Setting object
   * @access public
   * @static
   */
  static function &add(&$params) {
    
    $setting = new CMC_DAO_Setting();
    $setting->base_url = $params['base_url'];
    $setting->api_key = $params['api_key'];
    $setting->list_id = $params['list_id'];
    $setting->is_active = $params['is_active'];
    
    if (! empty($params['id'])) {
      $setting->id = $params['id'];
    }

    $setting->is_active = CRM_Utils_Array::value('is_active', $params) ? 1 : 0;
    
    $id = empty($params['id']) ? NULL : $params['id'];
    $op = $id ? 'edit' : 'create';
    
    //make sure to keep single setting active.
    if ($setting->is_active) {
      $query = 'UPDATE civicrm_mailchimp_setting SET is_active = 0';
      CRM_Core_DAO::executeQuery($query);
    }
    
    $setting->save();

    return $setting;
  }

  /**
   * Takes a bunch of params that are needed to match certain criteria and
   * retrieves the relevant objects. Typically the valid params are only
   * contact_id. We'll tweak this function to be more full featured over a period
   * of time. This is the inverse function of create. It also stores all the retrieved
   * values in the default array
   *
   * @param array $params   (reference) an assoc array of name/value pairs
   * @param array $defaults (reference) an assoc array to hold the flattened values
   *
   * @return object CMC_BAO_Setting object on success, null otherwise
   * @access public
   * @static
   */
  static function retrieve(&$params, &$defaults) {
    $setting = new CMC_DAO_Setting();
    $setting->copyValues($params);
    if ($setting->find(true)) {
      CRM_Core_DAO::storeValues($setting, $defaults);
      return $setting;
    }
    return null;
  }

  static function getActiveSetting() {
    $values = array();
    $setting = new CMC_DAO_Setting();
    $setting->is_active = 1;
    if ($setting->find(true)) {
      CRM_Core_DAO::storeValues($setting, $values);
    }

    return $values;
  }

  /**
   * update the is_active flag in the db
   *
   * @param int      $id        id of the database record
   * @param boolean  $is_active value we want to set the is_active field
   *
   * @return Object             DAO object on sucess, null otherwise
   *
   * @access public
   * @static
   */
  static function setIsActive($id, $is_active) {
    //make sure to keep single setting active.
    if ($is_active) {
      $query = 'UPDATE civicrm_mailchimp_setting SET is_active = 0 WHERE  id != %1';
      $p = array(1 => array($id, 'Integer'));
      CRM_Core_DAO::executeQuery($query, $p);
    }
      
    return CRM_Core_DAO::setFieldValue('CMC_DAO_Setting', $id, 'is_active', $is_active);
  }


  /**
   * Function to delete discount codes
   *
   * @param  int  $settingId    ID of the discount code to be deleted.
   *
   * @access public
   * @static
   * @return true on success else false
   */
  static function del($settingId) {
    $setting = new CMC_DAO_Setting();
    $setting->id = $settingId;

    if ($setting->find(TRUE)) {
      $setting->delete();
      return TRUE;
    }

    return FALSE;
  }
}
