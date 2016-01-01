<?php

/**
 * @file
 * This file is loaded every time the core of e107 is included. ie. Wherever
 * you see require_once("class2.php") in a script. It allows a developer to
 * modify or define constants, parameters etc. which should be loaded prior to
 * the header or anything that is sent to the browser as output. It may also be
 * included in Ajax calls.
 */

e107::lan('nodejs_comment', false, true);

// Register events.
$event = e107::getEvent();
$event->register('postcomment', 'nodejs_comment_event_postcomment_callback');
$event->register('login', 'nodejs_comment_event_login_callback');

// TODO: send notifications after comment has been approved.

/**
 * Event callback after triggering "postcomment".
 *
 * @param array $comment
 *  Comment item.
 *
 * $comment contains:
 * - comment_pid
 * - comment_item_id
 * - comment_subject
 * - comment_author_id
 * - comment_author_name
 * - comment_author_email
 * - comment_datestamp
 * - comment_comment
 * - comment_blocked
 * - comment_ip
 * - comment_type
 * - comment_lock
 * - comment_share
 * - comment_nick
 * - comment_time
 * - comment_id
 *
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
function nodejs_comment_event_postcomment_callback($comment)
{
	e107_require_once(e_PLUGIN . 'nodejs/nodejs.main.php');

	$tpl = e107::getTemplate('nodejs_comment');
	$sc = e107::getScBatch('nodejs_comment', true);
	$tp = e107::getParser();
	$cm = e107::getComment();

	$cid = (int) vartrue($comment['comment_id'], 0);
	$pid = (int) vartrue($comment['comment_pid'], 0);
	$uid = (int) vartrue($comment['comment_author_id'], 0);

	$commentData = $cm->getCommentData(1, 0, 'comment_id=' . $cid);

	if(!isset($commentData[0]))
	{
		return;
	}

	$authorData = e107::user($uid);

	// Send notification to everyone for updating latest comments menu.
	$sc->setVars($commentData[0]);
	$markup = $tp->parseTemplate($tpl['MENU']['LATEST']['ITEM'], true, $sc);

	$message = (object) array(
		'broadcast' => true,
		'channel'   => 'nodejs_notify',
		'callback'  => 'nodejsCommentMenu',
		'type'      => 'latestComments',
		'markup'    => $markup,
	);
	nodejs_enqueue_message($message);


	// Send notification to everyone for notifying about new comment.
	$sc->setVars(array(
		'account' => $authorData,
		'comment' => $commentData[0],
	));
	$markup = $tp->parseTemplate($tpl['NOTIFICATION']['POST_ALL'], true, $sc);

	$message = (object) array(
		'broadcast' => true,
		'channel'   => 'nodejs_notify',
		'callback'  => 'nodejsComments',
		'type'      => 'newCommentAny',
		'markup'    => $markup,
		'exclude'   => $authorData['user_id'],
	);
	nodejs_enqueue_message($message);

	// Reply on comment.
	if($pid > 0)
	{
		$commentParentData = $cm->getCommentData(1, 0, 'comment_id=' . $pid);
		array_pop($commentParentData);
		$authorParentData = e107::user();

		// Send notification to author of parent comment for notifying about new reply.
		$sc->setVars(array(
			'account' => $authorData,
			'comment' => $commentData[0],
		));
		$markup = $tp->parseTemplate($tpl['NOTIFICATION']['POST_OWN'], true, $sc);

		$message = (object) array(
			'channel'  => 'nodejs_user_' . $authorParentData['user_id'],
			'callback' => 'nodejsComments',
			'type'     => 'newCommentOwn',
			'markup'   => $markup,
			'exclude'  => $authorData['user_id'],
		);
		nodejs_enqueue_message($message);
	}
}

/**
 * Callback function to check EUF defaults.
 */
function nodejs_comment_event_login_callback($data)
{
	$db = e107::getDb();
	$uid = (int) $data['user_id'];

	// Start session.
	$session_started = session_id() === '' ? false : true;
	if($session_started)
	{
		session_start();
	}

	if($uid > 0 && !isset($_SESSION['nodejs_comment_eufs_updated']))
	{
		$_SESSION['nodejs_comment_eufs_updated'] = 1;

		$visits = $db->retrieve('user', 'user_visits', 'user_id = ' . $uid);
		// First time visit.
		if((int) $visits === 0)
		{
			$eufs = array(
				'user_plugin_nodejs_comment_alert_comment_any' => 1,
				'user_plugin_nodejs_comment_sound_comment_any' => 1,
				'user_plugin_nodejs_comment_alert_comment_own' => 1,
				'user_plugin_nodejs_comment_sound_comment_own' => 1,
				'WHERE'                                        => 'user_extended_id = ' . $uid,
			);

			$db->update('user_extended', $eufs);
		}
	}
}
