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
	 * Comment URL.
	 */
	function sc_latest_comment_url()
	{
		$tp = e107::getParser();
		return $tp->toText(vartrue($this->var['comment_url'], ''));
	}


	/**
	 * Comment subject.
	 */
	function sc_latest_comment_title()
	{
		$tp = e107::getParser();
		return $tp->toText(vartrue($this->var['comment_subject'], ''));
	}


	/**
	 * Comment author.
	 */
	function sc_latest_comment_author()
	{
		$tp = e107::getParser();
		return $tp->toText(vartrue($this->var['comment_author'], ''));
	}


	/**
	 * Comment created time.
	 */
	function sc_latest_comment_time()
	{
		$format = isset($this->plugPrefs['date_format']) ? $this->plugPrefs['date_format'] : 'relative';
		$date = e107::getDate();
		return $date->convert_date($this->var['comment_datestamp'], $format);
	}


	/**
	 * Comment preview.
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


	/**
	 * Render avatar for post author used in notification message.
	 *
	 * @return string
	 */
	function sc_comment_all_avatar()
	{
		$tp = e107::getParser();

		// TODO: provide the ability to set dimensions on Admin UI.
		$tp->thumbWidth = 50;
		$tp->thumbHeight = 50;

		return $tp->toAvatar($this->var['account']);
	}


	/**
	 * Render title for notification message.
	 *
	 * @return string
	 */
	function sc_comment_all_title()
	{
		// TODO: use e107::url().
		$href = e107::getUrl()->create('user/profile/view', $this->var['account']);
		return '<a href="' . $href . '">' . $this->var['account']['user_name'] . '</a>';
	}


	/**
	 * Render body for notification message.
	 *
	 * @return mixed
	 */
	function sc_comment_all_message()
	{
		$author = $this->var['account'];

		$search = array('[x]', '[y]');
		$replace = array($author['user_name'], $this->var['comment']['comment_subject']);

		return str_replace($search, $replace, LAN_PLUGIN_NODEJS_COMMENT_FRONT_02);
	}


	/**
	 * Render navigation link(s) for notification message.
	 *
	 * @return string
	 */
	function sc_comment_all_links()
	{
		$tp = e107::getParser();
		$url = $tp->toText(vartrue($this->var['comment']['comment_url'], ''));
		return '<a href="' . $url . '">' . LAN_PLUGIN_NODEJS_COMMENT_FRONT_01 . '</a>';
	}


	/**
	 * Render avatar for post author used in notification message.
	 *
	 * @return string
	 */
	function sc_comment_own_avatar()
	{
		$tp = e107::getParser();

		// TODO: provide the ability to set dimensions on Admin UI.
		$tp->thumbWidth = 50;
		$tp->thumbHeight = 50;

		return $tp->toAvatar($this->var['account']);
	}


	/**
	 * Render title for notification message.
	 *
	 * @return string
	 */
	function sc_comment_own_title()
	{
		// TODO: use e107::url().
		$href = e107::getUrl()->create('user/profile/view', $this->var['account']);
		return '<a href="' . $href . '">' . $this->var['account']['user_name'] . '</a>';
	}


	/**
	 * Render body for notification message.
	 *
	 * @return mixed
	 */
	function sc_comment_own_message()
	{
		$author = $this->var['account'];

		$search = array('[x]', '[y]');
		$replace = array($author['user_name'], $this->var['comment']['comment_subject']);

		return str_replace($search, $replace, LAN_PLUGIN_NODEJS_COMMENT_FRONT_03);
	}


	/**
	 * Render navigation link(s) for notification message.
	 *
	 * @return string
	 */
	function sc_comment_own_links()
	{
		$tp = e107::getParser();
		$url = $tp->toText(vartrue($this->var['comment']['comment_url'], ''));
		return '<a href="' . $url . '">' . LAN_PLUGIN_NODEJS_COMMENT_FRONT_01 . '</a>';
	}

}
