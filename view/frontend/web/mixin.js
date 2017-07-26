/**
 * 2017-07-26
 * @see Dfe_Moip/boleto
 * @see Dfe_Moip/card
 */
define([], function() {'use strict'; return {
	/**
	 * 2017-07-25
	 * @override
	 * @see Df_Payment/card.js::getCode():
	 * 		return this.item.method;
 	 * https://github.com/mage2pro/core/blob/2.9.7/Payment/view/frontend/web/card.js#L97-L109
	 * @see Magento_Checkout/js/view/payment/default::getCode():
	 * 		return this.item.method;
	 * https://github.com/magento/magento2/blob/2.1.0/app/code/Magento/Checkout/view/frontend/web/js/view/payment/default.js#L203-L208
	 * @returns {String}
	 */
	getCode: function() {return this._super() + '_' + this.df.moip.suffix;},
	/**
	 * 2017-07-25
	 * @override
	 * @see Magento/Checkout/js/view/payment/default::isRadioButtonVisible():
	 * 		return paymentService.getAvailablePaymentMethods().length !== 1;
 	 * https://github.com/magento/magento2/blob/2.2.0-RC1.5/app/code/Magento/Checkout/view/frontend/web/js/view/payment/default.js#L183-L185
	 * @used-by Df_Payment/main.html:
	 *	<input
	 *		type="radio"
	 *		name="payment[method]"
	 *		class="radio"
	 *		data-bind="
	 *			attr: {id: getCode()},
	 *			value: getCode(),
	 *			checked: dfChosenMethod,
	 *			click: selectPaymentMethod,
	 *			visible: isRadioButtonVisible()
	 *		"
	 *	/>
	 * https://github.com/mage2pro/core/blob/2.9.8/Payment/view/frontend/web/template/main.html#L14-L25
	 * I override this, because the Moip payment methods provides multiple options (card, boleto, ...),
	 * so we need the radio buttons enabled to switch between the options.
	 * @returns {boolean}
	 */
	isRadioButtonVisible: function() {return true;}
};});
