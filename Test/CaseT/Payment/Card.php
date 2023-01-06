<?php
namespace Dfe\Moip\Test\CaseT\Payment;
use Dfe\Moip\API\Facade\Order as lO;
use Dfe\Moip\Test\Card as tCard;
use Dfe\Moip\Test\Order as tOrder;
# 2017-06-09
# https://dev.moip.com.br/page/api-reference#section-payments
# https://dev.moip.com.br/v2.0/reference#pagamentos
# 2017-07-23 `[Moip] The available payment options`: https://mage2.pro/t/3851
final class Card extends \Dfe\Moip\Test\CaseT {
	/** 2017-06-09 @test */
	function t00():void {}

	/**
	 * 2017-06-09
	 * https://dev.moip.com.br/v2.0/reference#criar-pagamento
	 * https://dev.moip.com.br/page/api-reference#section-create-a-payment-post-
	 * [Moip] An example of a response to «POST v2/orders/<order ID>/payments» https://mage2.pro/t/4048
	 */
	function t01_create() {
		try {
			print_r(lO::s()->payment((new tOrder)->create()['id'], $this->pPayment())->j());
		}
		catch (\Exception $e) {
			if (function_exists('xdebug_break')) {
				xdebug_break();
			}
			throw $e;
		}
	}

	/**
	 * 2017-06-09
	 * @used-by self::t01_create()
	 * @return array(string => mixed)
	 */
	private function pPayment() {return [
		# 2017-06-09
		# «Used if you need to pre-capture a payment. Only available for credit cards.»
		# Optional, Boolean.
		'delayCapture' => true
		# 2017-06-09
		# «Payment method»
		# Required
		,'fundingInstrument' => tCard::s()->get('hash')
		# 2017-06-09
		# «Identification of your store on the buyer's credit card invoice»
		# Optional, String(13).
		,'statementDescriptor' => 'MAGE2.PRO'
	];}
}