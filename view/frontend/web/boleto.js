// 2017-07-24
define([
	'./mixin', 'df', 'Df_Payment/custom'
], function(mixin, df, parent) {'use strict'; return parent.extend(df.o.merge(mixin, {
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
	dfData: function() {return df.o.merge(this._super(), {option: this.df.moip.suffix});}
}));});