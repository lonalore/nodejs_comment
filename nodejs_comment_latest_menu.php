<?php

/**
 * @file
 * Latest comments menu.
 */

if(!defined('e107_INIT'))
{
	exit;
}

// [PLUGINS]/nodejs_comment/languages/[LANGUAGE]/[LANGUAGE]_front.php
e107::lan('nodejs_comment', false, true);


/**
 * Class nodejs_comment_latest_menu.
 */
class nodejs_comment_latest_menu
{

	/**
	 * Store plugin preferences.
	 *
	 * @var array
	 */
	private $plugPrefs = array();


	/**
	 * Constructor.
	 */
	function __construct()
	{
		if(e107::isInstalled('nodejs_comment'))
		{
			// Get plugin preferences.
			$this->plugPrefs = e107::getPlugConfig('nodejs_comment')->getPref();
			$this->renderMenu();
		}
	}


	/**
	 * Render menu.
	 */
	function renderMenu()
	{
		$tpl = e107::getTemplate('nodejs_comment');
		$sc = e107::getScBatch('nodejs_comment', true);
		$tp = e107::getParser();
		$cm = e107::getComment();

		$amount = (int) vartrue($this->plugPrefs['comment_display'], 10);

		/**
		 * getCommentData() returns with array, which contains:
		 * - comment_datestamp
		 * - comment_author_id
		 * - comment_author
		 * - comment_comment
		 * - comment_subject
		 * - comment_type
		 * - comment_title
		 * - comment_url
		 */
		$items = $cm->getCommentData($amount);

		$text = $tp->parseTemplate($tpl['MENU']['LATEST']['HEADER'], true, $sc);

		foreach($items as $item)
		{
			$sc->setVars($item);
			$text .= $tp->parseTemplate($tpl['MENU']['LATEST']['ITEM'], true, $sc);
		}

		if(empty($items))
		{
			$text .= '<a href="#" class="list-group-item no-posts text-center">' . LAN_PLUGIN_NODEJS_COMMENT_FRONT_05 . '</a>';
		}

		$text .= $tp->parseTemplate($tpl['MENU']['LATEST']['FOOTER'], true, $sc);

		e107::getRender()->tablerender(LAN_PLUGIN_NODEJS_COMMENT_FRONT_04, $text);
		unset($text);
	}

}


new nodejs_comment_latest_menu();
