<?php
namespace Dfe\Moip\Block\Info;
use Dfe\Moip\Method as M;
/**
 * 2017-07-30
 * 2017-08-06
 * [Moip] An example of a response to «POST v2/orders/<order ID>/payments» for a boleto bancário payment
 * https://mage2.pro/t/4210
 * @final Unable to use the PHP «final» keyword here because of the M2 code generation.
 * @used-by \Dfe\Moip\Method::getInfoBlockType()
 * @method M m()
 */
class Boleto extends \Df\Payment\Block\Info {
	/**
	 * 2017-08-06
	 * @override
	 * @see \Df\Payment\Block\Info::msgCheckoutSuccess()
	 * @used-by \Df\Payment\Block\Info::rCheckoutSuccess()
	 * @return string
	 */
	final protected function msgCheckoutSuccess() {return !$this->m()->isBoleto() ? null :
		$this->rCustomerAccount()
	;}

	/**
	 * 2017-07-30
	 * @override
	 * @see \Df\Payment\Block\Info::prepare()
	 * @used-by \Df\Payment\Block\Info::prepareToRendering()
	 * @used-by \Dfe\Moip\Block\Info\Card::prepare()
	 */
	final protected function prepare() {
		if ($this->extended()) {
			$res0 = $this->tm()->res0(); /** @var array(string => mixed) */
			$this->si([
				'Payment Option' => 'Boleto bancário'
				,'Payment Slip' => df_tag_ab($res0['id'], $this->url(false))
			]);
		}
		else {
			$this->si(null, df_tag_ab(__('Print the boleto'), $this->url()));
		}
	}

	/**
	 * 2017-08-05
	 * @override
	 * @see \Df\Payment\Block\Info::rCustomerAccount()
	 * @used-by self::msgCheckoutSuccess()
	 * @used-by \Df\Payment\Block\Info::_toHtml()
	 * @return string
	 */
	final protected function rCustomerAccount() {return df_tag('div', 'df-payment-info moip boleto',
		df_block_output($this, 'boleto', [
			'code' => $this->tm()->res0('fundingInstrument/boleto/lineCode')
			,'title' => $this->m()->getTitle()
			,'url' => $this->url()
		])
	);}

	/**
	 * 2017-08-05
	 * @used-by self::prepare()
	 * @used-by self::rCustomerAccount()
	 * @param bool $print [optional]
	 * @return string
	 */
	private function url($print = true) {
		$r = $this->tm()->res0('_links/payBoleto/redirectHref'); /** @var string $r */
		return !$print ? $r : "$r/print";
	}
}