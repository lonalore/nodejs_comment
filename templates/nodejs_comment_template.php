<?php

/**
 * @file
 * Templates for "nodejs_comment" plugin.
 */

// Template for popup message with type "Be notified when someone comments on a post".
$NODEJS_COMMENT_TEMPLATE['NOTIFICATION']['POST_ALL'] = '
<div class="nodejs-forum-notification">
  <div class="picture">
    {COMMENT_ALL_AVATAR}
  </div>
  <div class="body">
    <span class="title">
      {COMMENT_ALL_TITLE}
    </span>
    <div class="message">
        {COMMENT_ALL_MESSAGE}
    </div>
    <div class="links">
      {COMMENT_ALL_LINKS}
    </div>
  </div>
</div>
';

// Template for popup message with type "Be notified when someone replies your comment".
$NODEJS_COMMENT_TEMPLATE['NOTIFICATION']['POST_OWN'] = '
<div class="nodejs-forum-notification">
  <div class="picture">
    {COMMENT_OWN_AVATAR}
  </div>
  <div class="body">
    <span class="title">
      {COMMENT_OWN_TITLE}
    </span>
    <div class="message">
        {COMMENT_OWN_MESSAGE}
    </div>
    <div class="links">
      {COMMENT_OWN_LINKS}
    </div>
  </div>
</div>
';

// Template for latest comments menu.
$NODEJS_COMMENT_TEMPLATE['MENU']['LATEST']['HEADER'] = '
<div class="nodejs-comment-latest-comments">
    <div class="list-group">
';

// Template for latest comments menu.
$NODEJS_COMMENT_TEMPLATE['MENU']['LATEST']['ITEM'] = '
    <a href="{LATEST_COMMENT_URL}" class="list-group-item">
	    <h5 class="list-group-item-heading">{LATEST_COMMENT_TITLE}</h5>
		<p class="list-group-item-text">
		    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> <strong>{LATEST_COMMENT_AUTHOR}</strong>
		    <span class="glyphicon glyphicon-time" aria-hidden="true"></span> {LATEST_COMMENT_TIME}
		</p>
	</a>
';

// Template for latest comments menu.
$NODEJS_COMMENT_TEMPLATE['MENU']['LATEST']['FOOTER'] = '
    </div>
</div>
';
