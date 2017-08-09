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
		var $ul = $('<ul/>');
		/** @type {jQuery} HTMLDivElement */
		var $delete = $('<div>').addClass('df-delete fa fa-trash-o').click(function() {
			console.log('delete');
		});
		_.each(config.urls, function(v) {
			$ul.append($('<li>').html(v).append($delete.clone(true)));
		});
		$c.append($ul);
	}
);});