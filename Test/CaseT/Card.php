<?php
namespace Dfe\Moip\Test\CaseT;
use Dfe\Moip\API\Facade\Customer as lC;
use Dfe\Moip\Test\Card as tCard;
# 2017-04-26
final class Card extends \Dfe\Moip\Test\CaseT {
	/** 2017-04-26 @test */
	function t00():void {}

	/**
	 * 2017-04-26
	 * https://dev.moip.com.br/page/api-reference#section-add-a-credit-card-post-
	 * https://dev.moip.com.br/v2.0/reference#adicionar-cartao-de-credito
	 * [Moip] An example of a response to «POST v2/customers/<customer ID>/fundinginstruments»
	 * https://mage2.pro/t/4050
	 * 2017-07-16
	 * Note 1.
	 * Unable to use a card hash here:
	 * `A «POST /v2/customers/<customer ID>/fundinginstruments» request
	 * with a bank card hash as a «fundingInstruments» parameter
	 * leads to an undocumented «{"ERROR": "Ops... We were not waiting for it"}» response
	 * with «500 Internal Server Error» HTTP code`: https://mage2.pro/t/4175
	 * Note 2.
	 * There is a similar error on a customer's registration:
	 * `A «POST /v2/customers» request with a bank card hash as a «fundingInstruments» parameter
	 * leads to an undocumented «{"ERROR": "Ops... We were not waiting for it"}» response`:
	 * https://mage2.pro/t/4174
	 * https://suporte.moip.com.br/hc/pt-br/requests/1458451
	 * @see \Dfe\Moip\Test\CaseT\Customer::pCustomer()
	 * https://github.com/mage2pro/moip/blob/0.7.0/T/CaseT/Customer.php#L94-#L106
	 * @see \Dfe\Moip\P\Reg::k_CardId()
	 * https://github.com/mage2pro/moip/blob/0.7.0/P/Reg.php#L24-L29
	 * @see \Df\StripeClone\Payer::newCard()
	 * https://github.com/mage2pro/core/blob/2.8.19/StripeClone/Payer.php#L103-L109
	 */
	function t01_add() {
		try {
			print_r(lC::s()->addCard('CUS-UKXT2RQ2TULX', tCard::s()->get(1))->j());
		}
		catch (\Exception $e) {
			if (function_exists('xdebug_break')) {
				xdebug_break();
			}
			throw $e;
		}
	}
}