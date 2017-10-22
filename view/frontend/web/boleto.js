// 2017-07-24
define([
	'./mixin', 'df', 'df-lodash', 'Df_Payment/custom'
], function(mixin, df, _, parent) {'use strict';
/** 2017-09-06 @uses Class::extend() https://github.com/magento/magento2/blob/2.2.0-rc2.3/app/code/Magento/Ui/view/base/web/js/lib/core/class.js#L106-L140 */	
return parent.extend(df.o.merge(mixin, {
	defaults: {df: {formTemplate: 'Dfe_Moip/boleto', moip: {suffix: 'boleto'}}},
	/**
	 * 2017-07-26
	 * These data are submitted to the M2 server part
	 * as the `additional_data` property value on the «Place Order» button click:
	 * @used-by Df_Payment/mixin::getData():
	 *		getData: function() {return {additional_data: this.dfData(), method: this.item.method};},
	 * https://github.com/mage2pro/core/blob/2.8.4/Payment/view/frontend/web/mixin.js#L224
	 * @override
	 * @see Df_Payment/mixin::dfData()
	 * @returns {Object}
	 */
	dfData: function() {return _.assign(this._super(), {option: this.df.moip.suffix});}
}));});