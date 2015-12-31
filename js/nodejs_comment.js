var e107 = e107 || {'settings': {}, 'behaviors': {}};

(function ($)
{

	/**
	 * Register a NodeJS Callback to handle messages with type "newCommentAny" and "newCommentOwn".
	 *
	 * @type {{callback: Function}}
	 */
	e107.Nodejs.callbacks.nodejsComments = {
		callback: function (message)
		{
			var msgData = {
				playsound: false,
				data: {
					subject: '',
					body: message.markup
				}
			};

			var currenUser = parseInt(e107.settings.nodejs_comment.current_user);
			var excluded = parseInt(message.exclude);

			if(currenUser == excluded)
			{
				return;
			}

			switch(message.type)
			{
				case 'newCommentAny':
					if(parseInt(e107.settings.nodejs_comment.alert_comment_any) === 1)
					{
						e107.Nodejs.callbacks.nodejsNotify.callback(msgData);
					}

					if(parseInt(e107.settings.nodejs_comment.sound_comment_any) === 1)
					{
						e107.Nodejs.callbacks.nodejsNotifySoundAlert.callback();
					}
					break;

				case 'newCommentOwn':
					if(parseInt(e107.settings.nodejs_comment.alert_comment_own) === 1)
					{
						e107.Nodejs.callbacks.nodejsNotify.callback(msgData);
					}

					if(parseInt(e107.settings.nodejs_comment.sound_comment_own) === 1)
					{
						e107.Nodejs.callbacks.nodejsNotifySoundAlert.callback();
					}
					break;
			}

		}
	};

}(jQuery));
