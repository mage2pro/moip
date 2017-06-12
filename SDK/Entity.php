<?php
namespace Dfe\Moip\SDK;
/**
 * 2017-04-26
 * @see \Dfe\Moip\SDK\Customer
 * @see \Dfe\Moip\SDK\Order
 */
abstract class Entity implements \ArrayAccess {
	/**
	 * 2017-04-26 The last API response as an associative array (or its part).
	 * @param string|string[]|null $k [optional]
	 * @param string|null $d [optional]
	 * @return array(string => mixed)|mixed|null
	 */
	final function a($k = null, $d = null) {return $this->_op->res()->a($k, $d);}

	/**
	 * 2017-04-26 The last API response as JSON.
	 * @return string
	 */
	final function j() {return $this->_op->res()->j();}

	/**
	 * 2017-04-26
	 * @override
	 * @see \ArrayAccess::offsetExists()
	 * @param string $k
	 * @return void
	 */
	final function offsetExists($k) {df_should_not_be_here();}

	/**
	 * 2017-04-26
	 * @override
	 * @see \ArrayAccess::offsetGet()
	 * @used-by \Dfe\Moip\Facade\Charge::cardData()
	 * @used-by \Dfe\Moip\Facade\Charge::create()
	 * @used-by \Dfe\Moip\Facade\Customer::id()
	 * @used-by \Dfe\Moip\T\CaseT\Payment::t01_create()
	 * @param string $k
	 * @return array(string => mixed)|mixed|null
	 */
	final function offsetGet($k) {return $this->_op->res()->offsetGet($k);}

	/**
	 * 2017-04-26
	 * @override
	 * @see \ArrayAccess::offsetSet()
	 * @param string $k
	 * @param mixed $v
	 * @return void
	 */
	final function offsetSet($k, $v) {df_should_not_be_here();}

	/**
	 * 2017-04-26
	 * @override
	 * @see \ArrayAccess::offsetUnset()
	 * @param string $k
	 * @return void
	 */
	final function offsetUnset($k) {df_should_not_be_here();}

	/**
	 * 2017-04-26
	 * @used-by \Dfe\Moip\SDK\Customer::exec()
	 * @param Operation $op
	 */
	final protected function __construct(Operation $op) {$this->_op = $op;}

	/**
	 * 2017-04-26 The last API operation.
	 * @used-by a()
	 * @used-by createA()
	 * @used-by j()
	 * @used-by offsetGet()
	 * @used-by op()
	 * @var Operation
	 */
	private $_op;
}