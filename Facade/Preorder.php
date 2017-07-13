<?php
namespace Dfe\Moip\Facade;
use Df\API\Operation;
use Dfe\Moip\API\Facade\Order as O;
// 2017-06-12
final class Preorder extends \Df\StripeClone\Facade\Preorder {
	/**
	 * 2017-06-13 [Moip] An example of a response to «POST v2/orders» https://mage2.pro/t/4045
	 * @override
	 * @see \Df\StripeClone\Facade\Preorder::create()
	 * @used-by \Df\StripeClone\Method::chargeNew()
	 * @param array(string => mixed) $p
	 * @return Operation
	 */
	function create(array $p) {return O::s()->create($p);}

	/**
	 * 2017-06-13 [Moip] An example of a response to «POST v2/orders» https://mage2.pro/t/4045
	 * @override
	 * @see \Df\StripeClone\Facade\Preorder::id()
	 * @used-by \Df\StripeClone\Method::chargeNew()
	 * @param Operation $o
	 * @return string «ORD-TKZ1BQOQL69J»
	 */
	function id($o) {return $o['id'];}
}