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
	 */
	final protected function msgCheckoutSuccess():string {return !$this->m()->isBoleto() ? '' : $this->rCustomerAccount();}

	/**
	 * 2017-07-30
	 * @override
	 * @see \Df\Payment\Block\Info::prepare()
	 * @used-by \Df\Payment\Block\Info::prepareToRendering()
	 * @used-by \Dfe\Moip\Block\Info\Card::prepare()
	 */
	final protected function prepare():void {$this->si(...(!$this->extended()
		? [null, df_tag_ab(__('Print the boleto'), $this->url())]
		: [['Payment Option' => 'Boleto bancário', 'Payment Slip' => df_tag_ab($this->tm()->res0('id'), $this->url(false))]]
	));}

	/**
	 * 2017-08-05
	 * @override
	 * @see \Df\Payment\Block\Info::rCustomerAccount()
	 * @used-by self::msgCheckoutSuccess()
	 * @used-by \Df\Payment\Block\Info::_toHtml()
	 */
	final protected function rCustomerAccount():string {return df_tag('div', 'df-payment-info moip boleto',
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
	 */
	private function url($print = true):string {
		$r = $this->tm()->res0('_links/payBoleto/redirectHref'); /** @var string $r */
		return !$print ? $r : "$r/print";
	}
}