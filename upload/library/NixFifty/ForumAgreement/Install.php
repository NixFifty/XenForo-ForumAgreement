<?php

class NixFifty_ForumAgreement_Install
{
	public static function install($installedAddon)
	{
		$db = XenForo_Application::getDb();

		if (XenForo_Application::$versionId < 1030070)
		{
			throw new XenForo_Exception('This add-on requires XenForo 1.3.0 or higher.', true);
		}

		if (!$installedAddon)
		{
			foreach (self::_getAlters() AS $alterSql)
			{
				try
				{
					$db->query($alterSql);
				}
				catch (Zend_Db_Exception $e) {}
			}
		}
		else
		{
			// upgrades
			if ($installedAddon['version_id'] < 1000170)
			{
				$db = XenForo_Application::get('db');
				$db->query("ALTER TABLE `xf_node` CHANGE COLUMN `forum_agreement_message` `forum_agreement_message` TEXT NULL");
			}
		}
	}

	public static function uninstall()
	{
		$db = XenForo_Application::getDb();

		try
		{
			$db->query("ALTER TABLE xf_node DROP forum_agreement_enabled");
		}
		catch (Zend_Db_Exception $e) {}

		try
		{
			$db->query("ALTER TABLE xf_node DROP forum_agreement_message");
		}
		catch (Zend_Db_Exception $e) {}

		try
		{
			$db->query("ALTER TABLE xf_node DROP forum_agreement_expiry");
		}
		catch (Zend_Db_Exception $e) {}

		XenForo_Db::commit($db);
	}

	protected static function _getAlters()
	{
		$alters = [];

		$alters['node'] = "
			ALTER TABLE xf_node	ADD COLUMN `forum_agreement_enabled` INT(10) UNSIGNED NOT NULL DEFAULT '0';
			ALTER TABLE xf_node	ADD COLUMN `forum_agreement_message` TEXT NULL;
			ALTER TABLE xf_node	ADD COLUMN `forum_agreement_expiry` INT(10) UNSIGNED NOT NULL DEFAULT '1';
		";

		return $alters;
	}

}
