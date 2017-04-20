<?php
namespace Dfe\Moip\T;
use DateTime as DT;
use Moip\Moip as API;
use Moip\Resource\Customer as C;
// 2017-04-20
final class Basic extends TestCase {
	/** 2017-04-20 */
	function t01() {echo df_dump([
		$this->s()->publicKey(), $this->s()->privateToken(), $this->s()->privateKey()
	]);}

	/** @test 2017-04-20 */
	function t02() {
		/** @var API $api */
		$api = $this->api();
		/** @var C $c */
		$c = $api->customers();
		$c
			->setOwnId(uniqid('CUS-'))
			->setBirthDate(DT::createFromFormat('Y-m-d', '1982-07-08'))
			->setFullname('Dmitry Fedyuk')
			->setEmail('admin@mage2.pro')
			->setTaxDocument('22222222222', 'CPF')
			->setPhone(11, 66778899, 55)
			->addAddress(
				C::ADDRESS_SHIPPING, 'Avenida Faria Lima', '2927', 'Itaim'
				, 'Sao Paulo', 'SP', '01234000', '8'
			)
		;
		$c2 = $c->create();
		xdebug_break();
	}
}