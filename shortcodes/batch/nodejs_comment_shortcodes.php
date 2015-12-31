<?php

/**
 * @file
 * Shortcodes for "nodejs_comment" plugin.
 */

if(!defined('e107_INIT'))
{
	exit;
}

// [PLUGINS]/nodejs_comment/languages/[LANGUAGE]/[LANGUAGE]_front.php
e107::lan('nodejs_comment', false, true);


/**
 * Class nodejs_comment_shortcodes.
 */
class nodejs_comment_shortcodes extends e_shortcode
{

	/**
	 * Store forum plugin preferences.
	 *
	 * @var array
	 */
	private $plugPrefs = array();


	/**
	 * Constructor.
	 */
	function __construct()
	{
		parent::__construct();
		$this->plugPrefs = e107::getPlugConfig('nodejs_comment')->getPref();
	}


	/**
	 *
	 */
	function sc_latest_comment_url()
	{
		$tp = e107::getParser();
		return $tp->toText(vartrue($this->var['comment_url'], ''));
	}


	/**
	 *
	 */
	function sc_latest_comment_title()
	{
		$tp = e107::getParser();
		return $tp->toText(vartrue($this->var['comment_subject'], ''));
	}


	/**
	 *
	 */
	function sc_latest_comment_author()
	{
		$tp = e107::getParser();
		return $tp->toText(vartrue($this->var['comment_author'], ''));
	}


	/**
	 *
	 */
	function sc_latest_comment_time()
	{
		$format = isset($this->plugPrefs['date_format']) ? $this->plugPrefs['date_format'] : 'relative';
		$date = e107::getDate();
		return $date->convert_date($this->var['comment_datestamp'], $format);
	}


	/**
	 *
	 */
	function sc_latest_comment_preview()
	{
		$tp = e107::getParser();

		$entry = vartrue($this->var['comment_comment'], '');

		$post = $tp->toHTML($entry, true, 'emotes_off, no_make_clickable', '', false);
		$post = strip_tags($post);
		$post = $tp->text_truncate($post, 100, '...');

		return $post;
	}

}
