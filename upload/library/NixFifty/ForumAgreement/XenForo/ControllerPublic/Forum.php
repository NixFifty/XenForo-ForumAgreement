<?php

class NixFifty_ForumAgreement_XenForo_ControllerPublic_Forum
	extends XFCP_NixFifty_ForumAgreement_XenForo_ControllerPublic_Forum
{
	public function actionCreateThread()
	{
		$forumId = $this->_input->filterSingle('node_id', XenForo_Input::UINT);
		$forumName = $this->_input->filterSingle('node_name', XenForo_Input::STRING);

		/** @var XenForo_ControllerHelper_ForumThreadPost $ftpHelper */
		$ftpHelper = $this->getHelper('ForumThreadPost');
		$forum = $ftpHelper->assertForumValidAndViewable($forumId ? $forumId : $forumName);

		if ($forum['forum_agreement_enabled'])
		{
			$cookieName = 'forumAgreement_' . $forumId;
			$cookie = XenForo_Helper_Cookie::getCookie($cookieName);
			$showMessage = true;

			if ($cookie AND $forum['forum_agreement_expiry'] != 0)
			{
				$showMessage = false;
			}

			if ($this->isConfirmedPost())
			{
				$time = $forum['forum_agreement_expiry'] > 0 ? (time() + $forum['forum_agreement_expiry'] * 60 * 60 * 24) : 60 * 60 * 24;
				$showMessage = !(XenForo_Helper_Cookie::setCookie($cookieName, $forumId, $time));
			}

			if ($showMessage)
			{
				$viewParams = [
					'forum' => $forum,
					'homeLink' => XenForo_Link::buildPublicLink('full:index')
				];

				return $this->responseView('NixFifty_ForumAgreement_ViewPublic_Forum_Agreement', 'nf_forum_agreement', $viewParams);
			}
		}

		return parent::actionCreateThread();
	}
}