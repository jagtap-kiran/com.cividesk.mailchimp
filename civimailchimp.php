<?php

/**
 * Implementation of hook_civicrm_install()
 */
function civimailchimp_civicrm_install() {
  $civimailchimpRoot = dirname(__FILE__) . DIRECTORY_SEPARATOR;
  $civimailchimpSQL = $civimailchimpRoot . DIRECTORY_SEPARATOR . 'civimailchimp.sql';

  CRM_Utils_File::sourceSQLFile(CIVICRM_DSN, $civimailchimpSQL);

  // rebuild the menu so our path is picked up
  CRM_Core_Invoke::rebuildMenuAndCaches();
}

/**
 * Implementation of hook_civicrm_uninstall()
 */
function civimailchimp_civicrm_uninstall() {
  $civimailchimpRoot = dirname(__FILE__) . DIRECTORY_SEPARATOR;

  $civimailchimpSQL = $civimailchimpRoot . DIRECTORY_SEPARATOR . 'civimailchimp.uninstall.sql';

  CRM_Utils_File::sourceSQLFile(CIVICRM_DSN, $civimailchimpSQL);

  // rebuild the menu so our path is picked up
  CRM_Core_Invoke::rebuildMenuAndCaches();
}

/**
 * Implementation of hook_civicrm_config()
 */
function civimailchimp_civicrm_config(&$config) {
  $template =& CRM_Core_Smarty::singleton();

  $civimailchimpRoot =
    dirname(__FILE__) . DIRECTORY_SEPARATOR;

  $civimailchimpDir = $civimailchimpRoot . 'templates';

  if (is_array($template->template_dir)) {
    array_unshift($template->template_dir, $civimailchimpDir);
  }
  else {
    $template->template_dir = array($civimailchimpDir, $template->template_dir);
  }

  // also fix php include path
  $include_path = $civimailchimpRoot . PATH_SEPARATOR . get_include_path();
  set_include_path($include_path);
}

/**
 * Implementation of hook_civicrm_perm()
 *
 * Module extensions dont implement this hook as yet, will need to add for 4.2
 */
function civimailchimp_civicrm_perm() {
  return array('administer CiviCRM', 'administer CiviCRM');
}

/**
 * Implementation of hook_civicrm_xmlMenu
 */
function civimailchimp_civicrm_xmlMenu(&$files) {
  $files[] =
    dirname(__FILE__) . DIRECTORY_SEPARATOR .
    'xml'               . DIRECTORY_SEPARATOR .
    'Menu'              . DIRECTORY_SEPARATOR .
    'civimailchimp.xml';
}


/**
 * Add navigation for CiviMailchimp under "Administer" menu
 *
 * @param $params associated array of navigation menus
 */
function civimailchimp_civicrm_navigationMenu( &$params ) {
  // get the id of Administer Menu
  $administerMenuId = CRM_Core_DAO::getFieldValue('CRM_Core_BAO_Navigation', 'Administer', 'id', 'name');

  // skip adding menu if there is no administer menu
  if ($administerMenuId) {
    // get the maximum key under adminster menu
    $maxKey = max( array_keys($params[$administerMenuId]['child']));
    $params[$administerMenuId]['child'][$maxKey+1] =  array (
      'attributes' => array (
        'label'      => 'CiviMailchimp',
        'name'       => 'CiviMailchimp',
        'url'        => 'civicrm/civimailchimp&reset=1',
        'permission' => 'administer CiviCRM',
        'operator'   => NULL,
        'separator'  => TRUE,
        'parentID'   => $administerMenuId,
        'navID'      => $maxKey+1,
        'active'     => 1
      )
    );
  }
}

