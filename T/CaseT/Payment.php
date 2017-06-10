<?php
namespace Dfe\Moip\T\CaseT;
use Dfe\Moip\SDK\Payment as lP;
use Dfe\Moip\T\Card as tCard;
use Dfe\Moip\T\Order as tOrder;
use Moip\Exceptions\UnautorizedException as leUnautorized;
use Moip\Exceptions\UnexpectedException as leUnexpected;
use Moip\Exceptions\ValidationException as leValidation;
// 2017-06-09
// https://dev.moip.com.br/page/api-reference#section-payments
// https://dev.moip.com.br/v2.0/reference#pagamentos
final class Payment extends \Dfe\Moip\T\CaseT {
	/** @test 2017-06-09 */
	function t00() {}

	/**
	 * 2017-06-09
	 * https://dev.moip.com.br/v2.0/reference#criar-pagamento
	 * https://dev.moip.com.br/page/api-reference#section-create-a-payment-post-
	 * [Moip] An example of a response to «POST v2/orders/<order ID>/payments» https://mage2.pro/t/4048
	 */
	function t01_create() {
		try {
			echo lP::create((new tOrder)->create()->a('id'), $this->pPayment())->j();
			//echo df_json_encode_pretty($this->pPayment());
		}
		catch (\Exception $e) {
			if (function_exists('xdebug_break')) {
				xdebug_break();
			}
			/** @var \Exception|leUnautorized|leUnexpected|leValidation $e */
			throw $e;
		}
	}

	/**
	 * 2017-06-09
	 * @used-by t01_create()
	 * @return array(string => mixed)
	 */
	private function pPayment() {return [
		// 2017-06-09
		// «Used if you need to pre-capture a payment. Only available for credit cards.»
		// Optional, Boolean.
		'delayCapture' => true
		// 2017-06-09
		// «Payment method»
		// Required
		,'fundingInstrument' => tCard::s()->get()
		// 2017-06-09
		// «Identification of your store on the buyer's credit card invoice»
		// Optional, String(13).
		,'statementDescriptor' => 'MAGE2.PRO'
	];}
}