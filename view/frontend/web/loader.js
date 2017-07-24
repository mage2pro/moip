// 2017-07-24
define([
	'df', 'Magento_Checkout/js/model/payment/renderer-list', 'uiComponent'
], function(df, rendererList, Component) {'use strict';
/** @type {String} */ var code = 'dfe_moip';
/** @type {String} */ var name = 'Dfe_Moip';
if (window.checkoutConfig.payment[code]) {
	// 2017-07-24
	// `rendererList` is an «observable array»: http://knockoutjs.com/documentation/observableArrays.html
	// https://github.com/magento/magento2/blob/2.2.0-RC1.5/app/code/Magento/Checkout/view/frontend/web/js/model/payment/renderer-list.js#L11
	rendererList.push({type: code, component: name + '/card'});
}
return Component.extend({});
});
