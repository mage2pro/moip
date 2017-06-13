// 2017-04-11
define([
	// 2017-06-13 https://dev.moip.com.br/docs/criptografia#section--criptografia-no-browser-
	'Df_StripeClone/main', '//assets.moip.com.br/v2/moip.min.js'
], function(parent) {'use strict'; return parent.extend({
	defaults: {df: {card: {requireCardholder: true}}},
	/**
	 * 2017-04-11 The bank card network codes: https://mage2.pro/t/2647
	 * 2017-04-16 [Moip] The available payment options: https://mage2.pro/t/3851
	 * @returns {String[]}
	 */
	getCardTypes: function() {return ['VI', 'MC', 'AE', 'DN', 'Hipercard', 'Hiper', 'Elo'];},
    /**
	 * 2017-04-11
	 * @override
	 * @see Df_StripeClone/main::tokenCheckStatus()
	 * https://github.com/mage2pro/core/blob/2.7.9/StripeClone/view/frontend/web/main.js?ts=4#L8-L15
	 * @used-by Df_StripeClone/main::placeOrder()
	 * https://github.com/mage2pro/core/blob/2.7.9/StripeClone/view/frontend/web/main.js?ts=4#L75
	 * @param {Boolean} status
	 * @returns {Boolean}
	 */
	tokenCheckStatus: function(status) {return status;},
    /**
	 * 2017-04-11
	 * @override
	 * @see https://github.com/mage2pro/core/blob/2.0.11/StripeClone/view/frontend/web/main.js?ts=4#L21-L29
	 * @used-by Df_StripeClone/main::placeOrder()
	 * https://github.com/mage2pro/core/blob/2.7.9/StripeClone/view/frontend/web/main.js?ts=4#L73
	 * @param {Object} params
	 * @param {Function} callback
	 */
	tokenCreate: function(params, callback) {
		/** @type {Object} */
		var card = new Moip.CreditCard(params);
		callback(card.isValid(), card);
	},
    /**
	 * 2017-04-11
	 * @override
	 * @see https://github.com/mage2pro/core/blob/2.0.11/StripeClone/view/frontend/web/main.js?ts=4#L31-L39
	 * @used-by placeOrder()
	 * @param {Boolean} status
	 * @param {Object} resp
	 * @returns {String}
	 */
	tokenErrorMessage: function(status, resp) {return this.$t(
		'Unable to validate your bank card. Please recheck the data entered.'
	);},
    /**
	 * 2017-04-11
	 * @override
	 * @see https://github.com/mage2pro/core/blob/2.0.11/StripeClone/view/frontend/web/main.js?ts=4#L41-L48
	 * @used-by placeOrder()
	 * @param {Object} resp
	 * @returns {String}
	 */
	tokenFromResponse: function(resp) {return null;},
    /**
	 * 2017-06-13
	 * https://dev.moip.com.br/page/english#section-encryption-in-browser
	 * https://dev.moip.com.br/docs/criptografia#section--criptografia-no-browser-
	 * http://moip.github.io/moip-sdk-js
	 * @override
	 * @see Df_StripeClone/main::tokenParams()
	 * https://github.com/mage2pro/core/blob/2.7.9/StripeClone/view/frontend/web/main.js?ts=4#L42-L48
	 * @used-by Df_StripeClone/main::placeOrder()
	 * https://github.com/mage2pro/core/blob/2.7.9/StripeClone/view/frontend/web/main.js?ts=4#L73
	 * @returns {Object}
	 */
	tokenParams: function() {return {
		cvc: this.creditCardVerificationNumber()
		,expMonth: this.creditCardExpMonth()
		,expYear: this.creditCardExpYear()
		,number: this.creditCardNumber()
		,pubKey: this.publicKey()
	};}
});});