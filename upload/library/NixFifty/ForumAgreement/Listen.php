<?php

class NixFifty_ForumAgreement_Listen
{
	public static function loadClass($class, array &$extend)
	{
		$extend[] = 'NixFifty_ForumAgreement_' . $class;
	}
}