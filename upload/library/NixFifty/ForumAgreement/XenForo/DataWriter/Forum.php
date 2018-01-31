<?php

class NixFifty_ForumAgreement_XenForo_DataWriter_Forum extends XFCP_NixFifty_ForumAgreement_XenForo_DataWriter_Forum
{
	/**
	 * Gets the fields that are defined for the table. See parent for explanation.
	 *
	 * @return array
	 */
	protected function _getFields()
	{
		$fields = parent::_getFields();

		$fields['xf_node']['forum_agreement_enabled'] = ['type' => self::TYPE_BOOLEAN, 'default' => 0];
		$fields['xf_node']['forum_agreement_message'] = ['type' => self::TYPE_STRING, 'default' => ''];
		$fields['xf_node']['forum_agreement_expiry'] = ['type' => self::TYPE_UINT, 'default' => 0];

		return $fields;
	}

	protected function _preSave()
	{
		parent::_preSave();

		if (!is_null(NixFifty_ForumAgreement_Globals::$enabled))
		{
			$this->set('forum_agreement_enabled', NixFifty_ForumAgreement_Globals::$enabled);
		}

		if (!is_null(NixFifty_ForumAgreement_Globals::$message))
		{
			$this->set('forum_agreement_message', NixFifty_ForumAgreement_Globals::$message);
		}

		if (!is_null(NixFifty_ForumAgreement_Globals::$expiry))
		{
			$this->set('forum_agreement_expiry', NixFifty_ForumAgreement_Globals::$expiry);
		}
	}
}