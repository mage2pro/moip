<?php
namespace Dfe\Moip\Facade;
use Df\API\Operation;
use Dfe\Moip\API\Facade\Order as O;
# 2017-06-12
final class Preorder extends \Df\StripeClone\Facade\Preorder {
	/**
	 * 2017-06-13 [Moip] An example of a response to «POST v2/orders» https://mage2.pro/t/4045
	 * @override
	 * @see \Df\StripeClone\Facade\Preorder::create()
	 * @used-by \Df\StripeClone\Method::chargeNew()
	 * @param array(string => mixed) $p
	 */
	function create(array $p):Operation {return O::s()->create($p);}

	/**
	 * 2017-06-13
	 * [Moip] An example of a response to «POST v2/orders» https://mage2.pro/t/4045
	 * A result: «ORD-TKZ1BQOQL69J».
	 * @override
	 * @see \Df\StripeClone\Facade\Preorder::id()
	 * @used-by \Df\StripeClone\Method::chargeNew()
	 * @param Operation $o
	 */
	function id($o):string {return $o['id'];}
}