<?php
require_once 'CRM/Core/DAO.php';
require_once 'CRM/Utils/Type.php';
class CMC_DAO_Setting extends CRM_Core_DAO {
  /**
   * static instance to hold the table name
   *
   * @var string
   * @static
   */
  static $_tableName = 'civicrm_mailchimp_setting';
  /**
   * static instance to hold the field values
   *
   * @var array
   * @static
   */
  static $_fields = null;
  /**
   * static instance to hold the FK relationships
   *
   * @var string
   * @static
   */
  static $_links = null;
  /**
   * static instance to hold the values that can
   * be imported
   *
   * @var array
   * @static
   */
  static $_import = null;
  /**
   * static instance to hold the values that can
   * be exported
   *
   * @var array
   * @static
   */
  static $_export = null;
  /**
   * static value to see if we should log any modifications to
   * this table in the civicrm_log table
   *
   * @var boolean
   * @static
   */
  static $_log = false;
  /**
   * Discount Item ID
   *
   * @var int unsigned
   */
  public $id;
  /**
   * Base Url.
   *
   * @var string
   */
  public $base_url;
  /**
   * Api Key.
   *
   * @var string
   */
  public $api_key;
  /**
   * list id?
   *
   * @var string
   */
  public $list_id;
  
  /**
   * Is this setting active?
   *
   * @var boolean
   */
  public $is_active;
  /**
   * class constructor
   *
   * @access public
   * @return cividiscount_item
   */
  function __construct() {
    parent::__construct();
  }
  /**
   * return foreign links
   *
   * @access public
   * @return array
   */
  function &links() {
    if (!(self::$_links)) {
      self::$_links = array();
    }
    return self::$_links;
  }
  /**
   * returns all the column names of this table
   *
   * @access public
   * @return array
   */
  static function &fields() {
    if (!(self::$_fields)) {
      self::$_fields = array(
          'id' => array(
            'name' => 'id',
            'type' => CRM_Utils_Type::T_INT,
            'required' => true,
          ),
          'base_url' => array(
            'name' => 'base_url',
            'type' => CRM_Utils_Type::T_TEXT,
            'title' => ts('Api Key'),
            'required' => false,
            'size' => CRM_Utils_Type::T_TEXT,
          ),
          'api_key' => array(
            'name' => 'api_key',
            'type' => CRM_Utils_Type::T_TEXT,
            'title' => ts('Base Url'),
            'required' => true,
            'size' => CRM_Utils_Type::T_TEXT,
          ),
          'list_id' => array(
            'name' => 'list_id',
            'type' => CRM_Utils_Type::T_STRING,
            'title' => ts('List ID'),
            'required' => true,
            'maxlength' => 255,
            'size' => CRM_Utils_Type::HUGE,
          ),
          'is_active' => array(
            'name' => 'is_active',
            'type' => CRM_Utils_Type::T_BOOLEAN,
          ),
       );
    }
    return self::$_fields;
  }
  /**
   * returns the names of this table
   *
   * @access public
   * @return string
   */
  static function getTableName() {
    return CRM_Core_DAO::getLocaleTableName(self::$_tableName);
  }
  /**
   * returns if this table needs to be logged
   *
   * @access public
   * @return boolean
   */
  function getLog() {
    return self::$_log;
  }
  /**
   * returns the list of fields that can be imported
   *
   * @access public
   * return array
   */
  function &import($prefix = false) {
    if (!(self::$_import)) {
      self::$_import = array();
      $fields = self::fields();
      foreach($fields as $name => $field) {
        if (CRM_Utils_Array::value('import', $field)) {
          if ($prefix) {
            self::$_import['mailchimp_setting'] = & $fields[$name];
          }
          else {
            self::$_import[$name] = & $fields[$name];
          }
        }
      }
    }
    return self::$_import;
  }
  /**
   * returns the list of fields that can be exported
   *
   * @access public
   * return array
   */
  function &export($prefix = false) {
    if (!(self::$_export)) {
      self::$_export = array();
      $fields = self::fields();
      foreach($fields as $name => $field) {
        if (CRM_Utils_Array::value('export', $field)) {
          if ($prefix) {
            self::$_export['mailchimp_item'] = & $fields[$name];
          }
          else {
            self::$_export[$name] = & $fields[$name];
          }
        }
      }
    }
    return self::$_export;
  }
}
