var e107 = e107 || {'settings': {}, 'behaviors': {}};

(function ($) {

	/**
	 * Register Node.js callback function to handle pushed messages.
	 *
	 * @type {{callback: Function}}
	 */
	e107.Nodejs.callbacks.nodejsCommentMenu = {
		callback: function (message) {
			switch (message.type) {
				case 'latestComments':
					var html = message.markup;
					$('.nodejs-comment-latest-comments .no-posts').remove();
					$(html).prependTo('.nodejs-comment-latest-comments .list-group').hide().fadeIn('slow');
					break;
			}
		}
	};

})(jQuery);
