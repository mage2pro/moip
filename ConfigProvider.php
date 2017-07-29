<?php
namespace Dfe\Moip;
use Magento\Payment\Model\Checks\TotalMinMax as T;
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
	protected function config() {$s = $this->s(); return [
		'boleto' => [
			'enable' => $s->v('boleto/enable') && $this->applicableForQuote('boleto')
			,'title' => $s->v('boleto/title')
		]
		,'card' => [
			'calendar' => df_asset_create('Magento_Theme::calendar.png')->getUrl()
			,'cards' => parent::cards()
			,'enable' => $s->v('card/enable') && $this->applicableForQuote('card')
			,'installments' => $s->installments()
			,'title' => $s->v('card/title')
			,'prefill' => $s->prefill()
			// 2017-07-22
			// It implements the feature:
			// `Add a new option «Prefill the cardholder's name from the billing address?»
			// to the payment modules which require (or accept) the cardholder's name`
			// https://github.com/mage2pro/core/issues/14
			,'prefillCardholder' => $s->prefillCardholder()
		]
		,'common' => [
			'isTest' => $s->test()
			,'publicKey' => $s->publicKey()
			,'titleBackend' => $this->m()->titleB()
		]
	];}

	/**
	 * 2017-07-29
	 * It is implemented by analogy with @see \Magento\Payment\Model\Checks\TotalMinMax::isApplicable()
	 * @used-by config()
	 * @param string $option
	 * @return boolean
	 */
	private function applicableForQuote($option) {
		$a = df_quote()->getBaseGrandTotal(); /** @var float $a */
        $max = $this->s()->v("$option/" . T::MAX_ORDER_TOTAL); /** @var float $max */
		$min = $this->s()->v("$option/" . T::MIN_ORDER_TOTAL); /** @var float $min */
		return !($min && $a < $min || $max && $a > $max);
	}
}