<?php

/**
 * @file
 * Describes Extended User Fields to display them on the global notification settings
 * form of nodejs_notify plugin.
 */


/**
 * Class nodejs_comment_nodejs_notify.
 */
class nodejs_comment_nodejs_notify
{

	/**
	 * NodeJS Notify configuration items.
	 *
	 * @return array
	 *    The list of configuration items.
	 */
	public function configurationItems()
	{
		$items = array();

		// "Be notified when someone comments on a post" item.
		$items[] = array(
			// Use global language file.
			'label'       => LAN_PLUGIN_NODEJS_COMMENT_NOTIFY_CONFIG_03,
			// Extended User Field name from plugin.xml to store configuration by user.
			// plugin_nodejs_comment_alert_comment_any
			'field_alert' => 'alert_comment_any',
			// Extended User Field name from plugin.xml to store configuration by user.
			// plugin_nodejs_comment_sound_comment_any
			'field_sound' => 'sound_comment_any',
		);

		// "Be notified when someone replies your comment" item.
		$items[] = array(
			// Use global language file.
			'label'       => LAN_PLUGIN_NODEJS_COMMENT_NOTIFY_CONFIG_04,
			// Extended User Field name from plugin.xml to store configuration by user.
			// plugin_nodejs_comment_alert_comment_own
			'field_alert' => 'alert_comment_own',
			// Extended User Field name from plugin.xml to store configuration by user.
			// plugin_nodejs_comment_sound_comment_own
			'field_sound' => 'sound_comment_own',
		);

		return array(
			'group_title'       => LAN_PLUGIN_NODEJS_COMMENT_NOTIFY_CONFIG_01,
			'group_description' => LAN_PLUGIN_NODEJS_COMMENT_NOTIFY_CONFIG_02,
			'group_items'       => $items,
		);
	}

}
