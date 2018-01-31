<?php

class NixFifty_ForumAgreement_XenForo_ControllerAdmin_Forum
	extends XFCP_NixFifty_ForumAgreement_XenForo_ControllerAdmin_Forum
{
	public function actionSave()
	{
		NixFifty_ForumAgreement_Globals::$enabled = $this->_input->filterSingle(
			'forum_agreement_enabled', XenForo_Input::BOOLEAN
		);

		NixFifty_ForumAgreement_Globals::$message = $this->_input->filterSingle(
			'forum_agreement_message', XenForo_Input::STRING
		);

		NixFifty_ForumAgreement_Globals::$expiry = $this->_input->filterSingle(
			'forum_agreement_expiry', XenForo_Input::INT
		);

		return parent::actionSave();
	}
}