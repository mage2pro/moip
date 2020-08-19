<?php
namespace Dfe\Moip;
/**
 * 2017-07-14
 * @method Method m()
 * @method Settings s()
 */
final class ConfigProvider extends \Df\StripeClone\ConfigProvider {
	/**
	 * 2017-07-14
	 * @override
	 * @see \Df\StripeClone\ConfigProvider::config()
	 * @used-by \Df\Payment\ConfigProvider::getConfig()
	 * @return array(string => mixed)
	 */
	protected function config() {$m = $this->m(); $s = $this->s(); return [
		'boleto' => [
			'enable' => $s->b('boleto/enable') && $s->applicableForQuoteByMinMaxTotal('boleto')
			,'title' => $m->optionTitle('boleto')
		]
		,'card' => [
			'calendar' => df_asset_create('Magento_Theme::calendar.png')->getUrl()
			,'cards' => parent::cards()
			,'enable' => $s->b('card/enable') && $s->applicableForQuoteByMinMaxTotal('card')
			,'installments' => $s->installments()
			,'prefill' => $s->prefill()
			# 2017-07-22
			# It implements the feature:
			# `Add a new option «Prefill the cardholder's name from the billing address?»
			# to the payment modules which require (or accept) the cardholder's name`
			# https://github.com/mage2pro/core/issues/14
			,'prefillCardholder' => $s->prefillCardholder()
			,'title' => $m->optionTitle('card')
		]
		,'common' => ['isTest' => $s->test(), 'publicKey' => $s->publicKey(), 'titleBackend' => $m->titleB()]
	];}
}