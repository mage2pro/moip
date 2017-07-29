// 2017-04-11
// 2017-06-13 https://dev.moip.com.br/docs/criptografia#section--criptografia-no-browser-
define([
	'./mixin', 'df', 'df-lodash', 'Df_Checkout/data', 'Df_Payment/billingAddressChange'
   	,'Df_StripeClone/main', 'ko', 'Magento_Checkout/js/model/quote', 'Df_Ui/validator/cpf', '//assets.moip.com.br/v2/moip.min.js'
], function(mixin, df, _, dfc, baChange, parent, ko, quote) {'use strict'; return parent.extend(df.o.merge(mixin, {
	defaults: {df: {card: {requireCardholder: true}, moip: {suffix: 'card'}}, dob: '', taxID: ''},
	/**
	 * 2017-07-14
	 * @override
	 * @see Df_Payment/card::initialize()
	 * https://github.com/mage2pro/core/blob/2.4.21/Payment/view/frontend/web/card.js#L77-L110
	 * @returns {exports}
	*/
	initialize: function() {
		this._super();
		/**
		 * 2017-07-29
		 * It fixes the issue:
		 * «On the frontend checkout page load one of the payment option is initially selected
		 * but not expanded. The right behaviour: no payment option should be initially preselected.»
		 * https://github.com/mage2pro/moip/issues/16
		 * If a store has only the Moip payment method enabled,
		 * then the following M2 core code automatically set Moip as the selected payment method:
		 *		if (filteredMethods.length === 1) {
		 *			selectPaymentMethod(filteredMethods[0]);
		 *		}
		 * https://github.com/magento/magento2/blob/2.2.0-RC1.5/app/code/Magento/Checkout/view/frontend/web/js/model/payment-service.js#L54-L56
		 * As the Moip module provides multiple payment options, we deselect the Moip payment method
		 * and let customer to choose an option himself.
		 */
		quote.paymentMethod(null);
		/** @type {Number[]} */
		var ia = this.config('installments');
		if (2 > ia.length) {
			ia = [];
		}
		this.installment = ko.observable(!ia.length ? 1 : ia[0]);
		var $t = this.$t;
		this.installments = _.map(ia, function(i) {return {
			label: df.t($t('{0}x {1}'), i, dfc.formatMoneyH(dfc.grandTotal() / i)) + (1 === i ? '' :
				' ' + $t('interest free')
			)
			,period: i
		}});
		// 2017-07-23
		// It solves the task:
		// `Prefill the «CPF do titular deste cartão» bank card payment form field
		// with the value of the standard Magento «VAT Number» address attribute
		// or with the value of the standard Magento «Tax/VAT number» customer attribute`:
		// https://github.com/mage2pro/moip/issues/11
		var _this = this;
		/** @type {Object} */ var c = window.checkoutConfig.customerData;
		// 2017-07-23 The date is already in the proper format: «yyyy-mm-dd».
		this.dob(c.dob);
		baChange(function(a) {
			if (a.vatId && a.vatId.length) {
				_this.taxID(a.vatId);
			}
			else {
				if (c && c.taxvat && c.taxvat.length) {
					_this.taxID(c.taxvat);
				}
			}
		});
		return this;
	},
	/**
	 * 2017-06-13
	 * @override
	 * @see Df_Payment/card::dfCard_customTemplate_afterCardholder()
	 * https://github.com/mage2pro/core/blob/2.8.11/Payment/view/frontend/web/card.js#L56-L66
	 * @used-by https://github.com/mage2pro/core/blob/2.8.11/Payment/view/frontend/web/template/card/new.html#L56-L58
	 *	<!--ko if: dfCard_customTemplate_afterCardholder() -->
	 *		<!-- ko template: {name: dfCard_customTemplate_afterCardholder()} --><!-- /ko -->
	 *	<!--/ko-->
	 * @returns {String}
	 */
	dfCard_customTemplate_afterCardholder: function() {return 'Dfe_Moip/fields';},
	/**
	 * 2017-07-14
	 * @override
	 * @see Df_Payment/card::dfCard_customTemplate_bottom()
	 * https://github.com/mage2pro/core/blob/2.8.11/Payment/view/frontend/web/card.js#L67-L68
	 * @used-by https://github.com/mage2pro/core/blob/2.8.11/Payment/view/frontend/web/template/card.html#L36-L38
	 *	<!--ko if: dfCard_customTemplate_bottom() -->
	 *		<!-- ko template: {name: dfCard_customTemplate_bottom()} --><!-- /ko -->
	 *	<!--/ko-->
	 * @returns {String}
	 */
	dfCard_customTemplate_bottom: function() {return (
		!this.installments.length ? null : 'Dfe_Moip/installments'
	);},
	/**
	 * 2017-06-13
	 * 2017-07-26
	 * These data are submitted to the M2 server part
	 * as the `additional_data` property value on the «Place Order» button click:
	 * @used-by Df_Payment/mixin::getData():
	 *		getData: function() {return {additional_data: this.dfData(), method: this.item.method};},
	 * https://github.com/mage2pro/core/blob/2.8.4/Payment/view/frontend/web/mixin.js#L224
	 * @override
	 * @see Df_Payment/card::dfData()
	 * @returns {Object}
	 */
	dfData: function() {return df.o.merge(this._super(), {
		cardholder: this.cardholder()
		,dob: this.dob()
		,option: this.df.moip.suffix
		,plan: this.installment()
		,taxID: this.taxID()
	});},
	/**
	 * 2017-04-11 The bank card network codes: https://mage2.pro/t/2647
	 * 2017-04-16 [Moip] The available payment options: https://mage2.pro/t/3851
	 * @returns {String[]}
	 */
	getCardTypes: function() {return ['VI', 'MC', 'AE', 'DN', 'Hipercard', 'Hiper', 'Elo'];},
	/**
	 * 2017-07-12
	 * @override
	 * @see Df_Payment/card::initObservable()
	 * https://github.com/mage2pro/core/blob/2.8.4/Payment/view/frontend/web/card.js#L141-L157
	 * @used-by Magento_Ui/js/lib/core/element/element::initialize()
	 * https://github.com/magento/magento2/blob/2.2.0-RC1.3/app/code/Magento/Ui/view/base/web/js/lib/core/element/element.js#L104
	 * @returns {Element} Chainable
	*/
	initObservable: function() {this._super(); this.observe(['dob', 'taxID']); return this;},
	/**
	 * 2017-07-12 «[Moip] What is CPF?» https://mage2.pro/t/3376
	 * @override
	 * @see Df_Payment/card::prefill()
	 * https://github.com/mage2pro/core/blob/2.8.3/Payment/view/frontend/web/card.js#L152-L167
	 * @used-by Df_Payment/card::initialize()
	 * https://github.com/mage2pro/core/blob/2.8.3/Payment/view/frontend/web/card.js#L134-L137
	 * @param {*} d
	 */
	prefill: function(d) {this._super(d); this.dob('1982-07-08'); this.taxID('11438374798');},
    /**
	 * 2017-06-13
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
	 * 2017-06-13
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
	 * 2017-06-13
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
	 * 2017-06-13
	 * @override
	 * @see https://github.com/mage2pro/core/blob/2.0.11/StripeClone/view/frontend/web/main.js?ts=4#L41-L48
	 * @used-by placeOrder()
	 * @param {Object} resp
	 * @returns {String}
	 */
	tokenFromResponse: function(resp) {return resp.hash();},
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
}));});