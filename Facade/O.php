<?php
namespace Dfe\Moip\Facade;
use Df\API\Operation;
# 2017-07-17
/** @method \Dfe\Paymill\Method m() */
final class O extends \Df\StripeClone\Facade\O {
	/**
	 * 2017-07-17
	 * `[Moip] An example of a response to «POST v2/orders/<order ID>/payments»` https://mage2.pro/t/4048
	 * @override
	 * @see \Df\StripeClone\Facade\O::toArray()
	 * @used-by \Df\StripeClone\Method::transInfo()
	 * @param Operation $o
	 * @return array(string => mixed)
	 */
	function toArray($o) {return $o->a();}
}