// 2017-08-09
define(['df', 'df-lodash', 'jquery', 'domReady!'], function(df, _, $) {return (
	/**
	 * 2017-08-09
	 * @param {Object} config
	 * @param {String} config.id
	 * @param {String[]} config.urls
	 */
	function(config) {
		/** @type {jQuery} HTMLDivElement */ var $c = $(document.getElementById(config.id));
		if (!_.isArray(config.urls)) {
			$c.html(df.t('Please set your Moip private keys first to the fields above.'));
		}
		else if (!config.urls.length) {
			$c.html(df.t('The proper webhook will be automatically set up on the config saving.<br/>Please press the «<b>Save Config</b>» button for it.'));
		}
		else {
			var $ul = $('<ul/>');
			/** @type {jQuery} HTMLDivElement */
			var $delete = $('<span>').addClass('df-delete fa fa-trash-o').click(function() {
				console.log('delete');
			});
			_.each(config.urls, function(v) {
				$ul.append(
					$('<li>')
						.append($('<span>').html(v))
						.append($delete.clone(true))
				);
			});
			$c.append($ul);
		}
	}
);});