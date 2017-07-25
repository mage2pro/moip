// 2017-07-24
define(['Df_Payment/custom'], function(parent) {'use strict'; return parent.extend({
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
	 *			checked: isChecked,
	 *			click: selectPaymentMethod,
	 *			visible: isRadioButtonVisible()
	 *		"
	 *	/>
	 * https://github.com/mage2pro/core/blob/2.9.5/Payment/view/frontend/web/template/main.html#L7-L18
	 * I override this, because the Moip payment methods provides multiple options (card, boleto, ...),
	 * so we need the radio buttons enabled to switch between the options.
	 * @returns {boolean}
	 */
	isRadioButtonVisible: function() {return true;},
});});