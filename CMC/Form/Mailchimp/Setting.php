<?php
require_once 'CMC/DAO/Setting.php';
require_once 'CMC/BAO/Setting.php';
require_once 'CRM/Admin/Form.php';

/**
 * This class generates form components for cividiscount administration.
 *
 */
class CMC_Form_Mailchimp_Setting extends CRM_Admin_Form {
  protected $_id = null;
  protected $_values = array();

  function preProcess() {
    $this->_id      = CRM_Utils_Request::retrieve('id', 'Positive', $this, false, 0);
    $this->set('BAOName', 'CMC_BAO_Setting');
    parent::preProcess();

    $session = CRM_Core_Session::singleton();
    $url = CRM_Utils_System::url('civicrm/civimailchimp', 'reset=1');
    $session->pushUserContext($url);

    // check and ensure that update / delete have a valid id
    require_once 'CRM/Utils/Rule.php';
    if ($this->_action & (CRM_Core_Action::UPDATE | CRM_Core_Action::DELETE)) {
      if (! CRM_Utils_Rule::positiveInteger($this->_id)) {
        CRM_Core_Error::fatal(ts('We need a valid setting ID for update and/or delete'));
      }
    }
    
    //retrieve values
    if ($this->_id) {
       $params = array('id' => $this->_id);
       CMC_BAO_Setting::retrieve($params, $this->_values); 
    }

    CRM_Utils_System::setTitle(ts('Mailchimp Settings'));
  }

  function setDefaultValues() {
    $defaults = $this->_values;
    
    $defaults['is_active'] = $origID ? CRM_Utils_Array::value('is_active', $defaults) : 1;
    
    return $defaults;
  }

  /**
   * Function to build the form
   *
   * @return None
   * @access public
   */
  public function buildQuickForm() {
    parent::buildQuickForm();

    if ($this->_action & CRM_Core_Action::DELETE) {
      return;
    }

    $this->applyFilter('__ALL__', 'trim');
    
    $element =& $this->add('text', 'base_url',
      ts('Base Url'),
      CRM_Core_DAO::getAttribute('CMC_DAO_Setting', 'base_url'),
      true);
    
    if ($this->_action & CRM_Core_Action::VIEW) {
      $element->freeze();
    }
    
    $element =& $this->add('text', 'list_id', ts('List ID'), CRM_Core_DAO::getAttribute('CMC_DAO_Setting', 'list_id'), true);
    if ($this->_action & CRM_Core_Action::VIEW) {
      $element->freeze();
    }
    
    $element =& $this->add('text', 'api_key', ts('Api Key'), CRM_Core_DAO::getAttribute('CMC_DAO_Setting', 'api_key'), true);
    if ($this->_action & CRM_Core_Action::VIEW) {
      $element->freeze();
    }
    
    $element =& $this->addElement('checkbox', 'is_active', ts('Is setting Active?'));
    if ($this->_action & CRM_Core_Action::VIEW) {
      $element->freeze();
    }
  }

  /**
   * Function to process the form
   *
   * @access public
   * @return None
   */
  public function postProcess() {
    if ($this->_action & CRM_Core_Action::VIEW) {
      return;
    }
    if ($this->_action & CRM_Core_Action::DELETE) {
      CMC_BAO_Setting::del($this->_id);
      CRM_Core_Session::setStatus(ts('Selected Mailchimp setting has been deleted.'));
      return;
    }

    $params = $this->exportValues();

    if ($this->_action & CRM_Core_Action::UPDATE) {
      $params['id'] = $this->_id;
    }
    
    //add settings
    $setting = CMC_BAO_Setting::add($params);

    CRM_Core_Session::setStatus(ts('The setting for list \'%1\' has been saved.',
      array(1 => $setting->list_id )));
  }

}
