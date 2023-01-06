<?php
namespace Dfe\Moip\Test\CaseT\Payment;
use Dfe\Moip\API\Facade\Order as lO;
use Dfe\Moip\API\Option;
use Dfe\Moip\Test\Order as tOrder;
# 2017-07-21
# https://dev.moip.com.br/page/api-reference#section-payments
# https://dev.moip.com.br/v2.0/reference#pagamentos
# 2017-07-23 `[Moip] The available payment options`: https://mage2.pro/t/3851
final class OnlineBanking extends \Dfe\Moip\Test\CaseT {
	/** 2017-07-21 @test */
	function t00():void {}

	/**
	 * 2017-07-21
	 * https://dev.moip.com.br/v2.0/reference#criar-pagamento
	 * https://dev.moip.com.br/page/api-reference#section-create-a-payment-post-
	 * [Moip] An example of a response to «POST v2/orders/<order ID>/payments» https://mage2.pro/t/4048
	 */
	function t01_create():void {
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
	 * 2017-07-21
	 * @used-by self::t01_create()
	 * @return array(string => mixed)
	 */
	private function pPayment():array {return [
		# 2017-06-09
		# «Payment method»
		# Required
		'fundingInstrument' => [
			# 2017-06-09
			# «Method used. Possible values: CREDIT_CARD, BOLETO, ONLINE_BANK_DEBIT, WALLET»
			# Required, String.
			'method' => Option::ONLINE_BANKING
			,'onlineBankDebit' => [
				'bankNumber' => '001'
				,'expirationDate' => df_today_add(7)->toString('y-MM-dd')
				,'returnUri' => dfp_url_customer_return_remote($this)
			]
		]
	];}
}