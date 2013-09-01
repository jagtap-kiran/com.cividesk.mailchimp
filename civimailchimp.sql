DROP TABLE IF EXISTS `civicrm_mailchimp_setting`;
DROP TABLE IF EXISTS `civicrm_mailchimp_sync_log`;
DROP TABLE IF EXISTS `civicrm_mailchimp_sync_log_contacts`;
DROP TABLE IF EXISTS `civicrm_mailchimp_sync_log_contacts_added`;
DROP TABLE IF EXISTS `civicrm_mailchimp_sync_log_contacts_removed`;
DROP TABLE IF EXISTS `civicrm_mailchimp_sync_log_groups`;
DROP TABLE IF EXISTS `civicrm_mailchimp_sync_log_groups_added`;
DROP TABLE IF EXISTS `civicrm_mailchimp_sync_log_removes`;
DROP TABLE IF EXISTS `civicrm_mailchimp_sync_log_runkey`;

-- /*******************************************************
-- *
-- * CiviDesk Mailchimp Setting
-- *
-- * A setting entry.
-- *
-- *******************************************************/
CREATE TABLE `civicrm_mailchimp_setting` (
     `id` int unsigned NOT NULL AUTO_INCREMENT  COMMENT 'account ID',
     `base_url` text   COMMENT 'Base Url.',
     `api_key` text NOT NULL   COMMENT 'api key to connect mailchimp.',
     `list_id` varchar(255) NOT NULL   COMMENT 'List ID from mailchimp account',
     `is_active` tinyint    COMMENT 'Is webhook added?',
    PRIMARY KEY ( `id` )
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE TABLE `civicrm_mailchimp_sync_log_runkey` (
     `id` int unsigned NOT NULL AUTO_INCREMENT  COMMENT 'run key ID',
     `runkey` text   COMMENT 'mailchimp run key.',
     `runtime` date NOT NULL   COMMENT 'sync date.',
     `webhook_added` tinyint    COMMENT 'is webhook added',
    PRIMARY KEY ( `id` )
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;


--
-- Seed entry for setting.
-- NSERT INTO civicrm_mailchimp_setting (base_url, api_key, list_id, is_active )
-- VALUES ( 'http://localhost/civideskmailchimp',  '279649a599ac7543a7162043e1161d6a-us5', '665e9d4811', 1);
--
-- Seed entry for runkey
-- 
-- INSERT INTO civicrm_mailchimp_sync_log_runkey (runkey, runtime, webhook_added )
-- VALUES ('279649a599ac7543a7162043e1161d6a-us5', '2013-08-28', 1); 
--
--