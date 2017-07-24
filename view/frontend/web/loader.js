// 2017-07-24
define([
	'df', 'Magento_Checkout/js/model/payment/renderer-list', 'uiComponent'
], function(df, rendererList, Component) {'use strict';
/** @type {String} */ var code = 'dfe_moip';
/** @type {String} */ var name = 'Dfe_Moip';
if (window.checkoutConfig.payment[code]) {
	rendererList.push({type: code, component: name + '/main'});
}
return Component.extend({});
});
