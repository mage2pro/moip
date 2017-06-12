<?php
namespace Dfe\Moip\Facade;
use Dfe\Moip\SDK\Order as O;
// 2017-06-12
final class Preorder extends \Df\StripeClone\Facade\Preorder {
	/**
	 * 2017-06-12
	 * @override
	 * @see \Df\StripeClone\Facade\Preorder::create()
	 * @used-by \Df\StripeClone\Method::chargeNew()
	 * @param array(string => mixed) $p
	 * @return O
	 */
	function create(array $p) {return null;}

	/**
	 * 2017-06-12
	 * @override
	 * @see \Df\StripeClone\Facade\Preorder::id()
	 * @used-by \Df\StripeClone\Method::chargeNew()
	 * @param O $o
	 * @return string
	 */
	function id($o) {return null;}
}