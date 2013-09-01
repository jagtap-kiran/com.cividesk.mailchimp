<?php
require_once 'CRM/Core/Page/Basic.php';
require_once 'CMC/DAO/Setting.php';

/**
 * Page for displaying list of discount codes
 */
class CMC_Page_Mailchimp_Setting extends CRM_Core_Page_Basic {
  /**
   * The action links that we need to display for the browse screen
   *
   * @var array
   * @static
   */
  static $_links = null;

  /**
   * Get BAO Name
   *
   * @return string Classname of BAO.
   */
  function getBAOName() {
    return 'CMC_BAO_Setting';
  }

  /**
   * Get action Links
   *
   * @return array (reference) of action links
   */
  function &links() {
    if (!(self::$_links)) {
      self::$_links = array(
                            CRM_Core_Action::VIEW  => array(
                                                              'name'  => ts('View'),
                                                              'url'   => 'civicrm/civimailchimp/setting/view',
                                                              'qs'    => 'id=%%id%%&reset=1',
                                                              'title' => ts('View Mailchimp Setting')
                                                            ),
                            CRM_Core_Action::UPDATE  => array(
                                                              'name'  => ts('Edit'),
                                                              'url'   => 'civicrm/civimailchimp/setting/edit',
                                                              'qs'    => '&id=%%id%%&reset=1',
                                                              'title' => ts('Edit Mailchimp Setting')
                                                            ),
                            CRM_Core_Action::DISABLE => array(
                                                              'name'  => ts('Disable'),
                                                              'extra' => 'onclick = "enableDisable(%%id%%, \'' . 'CMC_BAO_Setting' . '\', \'' . 'enable-disable' . '\', 1, \'CiviMailchimp_Setting\');"',
                                                              'ref'   => 'disable-action',
                                                              'title' => ts('Disable Mailchimp Setting')
                                                            ),

                            CRM_Core_Action::ENABLE => array(
                                                              'name'  => ts('Enable'),
                                                              'extra' => 'onclick = "enableDisable(%%id%%, \'' . 'CMC_BAO_Setting' . '\' ,\'' . 'disable-enable' . '\', 1, \'CiviMailchimp_Setting\');"',
                                                              'ref'   => 'enable-action',
                                                              'title' => ts('Enable Mailchimp Setting')
                                                            ),
                            CRM_Core_Action::DELETE  => array(
                                                              'name'  => ts('Delete'),
                                                              'url'   => 'civicrm/civimailchimp/setting/delete',
                                                              'qs'    => '&id=%%id%%',
                                                              'title' => ts('Delete Mailchimp Setting')
                                                            )
                           );
    }
    return self::$_links;
  }

  /**
   * Get name of edit form
   *
   * @return string Classname of edit form.
   */
  function editForm() {
    return 'CMC_Form_Mailchimp_Setting';
  }

  /**
   * Get edit form name
   *
   * @return string name of this page.
   */
  function editName() {
    return 'Mailchimp Setting';
  }

  /**
   * Get user context.
   *
   * @return string user context.
   */
  function userContext($mode = null) {
    return 'civicrm/civimailchimp/setting';
  }
  
  function run() {
    $this->preProcess();
    return parent::run();
  }
  
  
  function preProcess() {
    $this->_id = CRM_Utils_Request::retrieve('id', 'Positive', $this, false);
    
    //run mailchimp
    //require_once 'api/api.php';
    //civicrm_api('Mailchimp', 'run', array('version' => '3'));
    
    CRM_Utils_System::setTitle('CiviDesk Mailchimp Setting');
  }

}

