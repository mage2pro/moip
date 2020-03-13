// 2017-08-09
define(['df', 'df-lodash', 'jquery', 'domReady!'], function(df, _, $) {return (
	/**
	 * 2017-08-09
	 * @param {Object} config
	 * @param {String} config.id
	 * @param {Boolean} config.down
	 * @param {Boolean} config.enabled
	 * @param {String[]} config.urls
	 */
	function(config) {
		/** @type {jQuery} HTMLDivElement */ var $c = $(document.getElementById(config.id));
		if (!config.enabled) {
			// 2017-10-19
			// We need not say "Check the «Enable?» checkbox",
			// because the controls are only visible when the «Enable?» checkbox is already checked.
			$c.html(df.t('Please save the settings first (press the «<b>Save Config</b>» button).'));
		}
		else if (config.down) {
			$c.html(df.t("The Moip API server <a href='https://mage2.pro/t/4721' target='_blank'>is down now</a>."));
		}
		else if (!_.isArray(config.urls)) {
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