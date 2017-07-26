// 2017-07-24
define([
	'./mixin', 'df', 'Df_Payment/custom'
], function(mixin, df, parent) {'use strict'; return parent.extend(df.o.merge(mixin, {
	defaults: {df: {formTemplate: 'Dfe_Moip/boleto', moip: {suffix: 'boleto'}}}
}));});