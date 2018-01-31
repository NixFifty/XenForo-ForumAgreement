<?php

class NixFifty_ForumAgreement_ViewPublic_Forum_Agreement extends XenForo_ViewPublic_Base
{
	public function renderHtml()
	{
		$formatter = XenForo_BbCode_Formatter_Base::create();
		$parser = new XenForo_BbCode_Parser($formatter);

		$this->_params['agreementParsed'] = html_entity_decode($parser->render($this->_params['forum']['forum_agreement_message']));
	}
}