<?php
namespace Dfe\Moip\SDK;
// 2017-04-26  A message is a request payload or a response payload.
final class Message implements \ArrayAccess {
	/**
	 * 2017-04-26
	 * @param \stdClass|array(string => mixed)|null $v
	 */
	function __construct($v) {
		$this->_j = df_json_encode_pretty($v ?: []);
		$this->_a = df_json_decode($this->_j);
	}

	/**
	 * 2017-04-26 The API response as an associative array.
	 * @used-by \Dfe\Moip\SDK\Entity::a()
	 * @param string|string[]|null $k [optional]
	 * @param string|null $d [optional]
	 * @return array(string => mixed)|mixed|null
	 */
	function a($k = null, $d = null) {return dfak($this->_a, $k, $d);}

	/**
	 * 2017-04-26 The message as an associative array.
	 * @used-by \Dfe\Moip\SDK\Entity::j()
	 * @return string
	 */
	function j() {return $this->_j;}

	/**
	 * 2017-04-26
	 * @override
	 * @see \ArrayAccess::offsetExists()
	 * @param string $k
	 * @return void
	 */
	function offsetExists($k) {df_should_not_be_here();}

	/**
	 * 2017-04-26
	 * @override
	 * @see \ArrayAccess::offsetGet()
	 * @used-by \Dfe\Moip\SDK\Entity::offsetGet()
	 * @param string $k
	 * @return array(string => mixed)|mixed|null
	 */
	function offsetGet($k) {return $this->a($k);}

	/**
	 * 2017-04-26
	 * @override
	 * @see \ArrayAccess::offsetSet()
	 * @param string $k
	 * @param mixed $v
	 * @return void
	 */
	function offsetSet($k, $v) {df_should_not_be_here();}

	/**
	 * 2017-04-26
	 * @override
	 * @see \ArrayAccess::offsetUnset()
	 * @param string $k
	 * @return void
	 */
	function offsetUnset($k) {df_should_not_be_here();}

	/**
	 * 2017-04-26 The message as an associative array.
	 * @used-by __construct()
	 * @used-by a()
	 * @var array(string => mixed)
	 */
	private $_a;

	/**
	 * 2017-04-26 The API response as JSON.
	 * @used-by __construct()
	 * @used-by j()
	 * @var string
	 */
	private $_j;
}