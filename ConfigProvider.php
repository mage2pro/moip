<?php
namespace Dfe\Moip;
// 2017-07-14
/** @method Settings s() */
final class ConfigProvider extends \Df\StripeClone\ConfigProvider {
	/**
	 * 2017-07-14
	 * @override
	 * @see \Df\StripeClone\ConfigProvider::config()
	 * @used-by \Df\Payment\ConfigProvider::getConfig()
	 * @return array(string => mixed)
	 */
	protected function config() {return [
		'calendar' => df_asset_create('Magento_Theme::calendar.png')->getUrl()
		,'installments' => $this->s()->installments()
	] + parent::config();}
}