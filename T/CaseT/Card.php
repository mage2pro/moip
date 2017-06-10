<?php
namespace Dfe\Moip\T\CaseT;
use Dfe\Moip\SDK\Customer as lC;
use Dfe\Moip\T\Card as tCard;
use Moip\Exceptions\UnautorizedException as leUnautorized;
use Moip\Exceptions\UnexpectedException as leUnexpected;
use Moip\Exceptions\ValidationException as leValidation;
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
			echo lC::addCard('CUS-UKXT2RQ2TULX', tCard::s()->get(1))->j();
		}
		catch (\Exception $e) {
			if (function_exists('xdebug_break')) {
				xdebug_break();
			}
			/** @var \Exception|leUnautorized|leUnexpected|leValidation $e */
			throw $e;
		}
	}
}