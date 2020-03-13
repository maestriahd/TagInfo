<?php
class TagInfoPlugin extends Omeka_Plugin_AbstractPlugin
{
    protected $_filters = array(
        'admin_navigation_main'
    );

        // Define Hooks
    protected $_hooks = array(
            'install',
            'uninstall',
        );

    public function hookInstall()
	{
		set_option("can_admins_edit", 0);
		$db = $this->_db;
        $sql = "            
            CREATE TABLE IF NOT EXISTS `$db->TagInfo` (
		`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
		`tag_id` int(10) UNSIGNED NOT NULL,
		`text` mediumtext COLLATE utf8_unicode_ci NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB ; ";
        $db->query($sql);
    }
    
    /**
     * Drops database table on uninstall
    **/
    public function hookUninstall()
    {
	$db = $this->_db;
        $sql = "DROP TABLE IF EXISTS `$db->TagInfo`; ";
        $db->query($sql);
    }

    public function filterAdminNavigationMain($nav)
    {
        $nav[] = array(
            'label' => __('Tag Info'),
            'uri' => url('tag-info')
        );
        return $nav;
    }
}
