// 2017-07-24
define([
	'./mixin', 'df', 'Df_Payment/custom'
], function(mixin, df, parent) {'use strict'; return parent.extend(df.o.merge(mixin, {
	/**
	 * 2017-07-25
	 * @override
	 * @see Magento_Checkout/js/view/payment/default::getCode():
	 * 		return this.item.method;
	 * https://github.com/magento/magento2/blob/2.1.0/app/code/Magento/Checkout/view/frontend/web/js/view/payment/default.js#L203-L208
	 * @returns {String}
	 */
	getCode: function() {return this._super() + '_boleto';}
}));});