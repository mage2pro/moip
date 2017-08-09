// 2017-08-09
define(['df-lodash', 'jquery', 'domReady!'], function(_, $) {return (
	/**
	 * 2017-08-09
	 * @param {Object} config
	 * @param {String} config.id
	 * @param {String[]} config.urls
	 */
	function(config) {
		/** @type {jQuery} HTMLDivElement */ var $c = $(document.getElementById(config.id));
		var $ul = $('<ul/>');
		_.each(config.urls, function(v){
			$ul.append($('<li>').html(v));
		});
		$c.append($ul);
	}
);});