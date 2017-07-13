<?php
namespace Dfe\Moip\T\CaseT;
use Dfe\Moip\API\Facade\Customer as lC;
use Dfe\Moip\T\Card as tCard;
// 2017-04-26
final class Card extends \Dfe\Moip\T\CaseT {
	/** @test 2017-04-26 */
	function t00() {}

	/**
	 * 2017-04-26
	 * https://dev.moip.com.br/page/api-reference#section-add-a-credit-card-post-
	 * https://dev.moip.com.br/v2.0/reference#adicionar-cartao-de-credito
	 * [Moip] An example of a response to «POST v2/customers/<customer ID>/fundinginstruments»
	 * https://mage2.pro/t/4050
	 */
	function t01_add() {
		try {
			echo lC::s()->addCard('CUS-UKXT2RQ2TULX', tCard::s()->get(1))->j();
		}
		catch (\Exception $e) {
			if (function_exists('xdebug_break')) {
				xdebug_break();
			}
			throw $e;
		}
	}
}