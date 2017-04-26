<?php
namespace Dfe\Moip\SDK;
use Dfe\Moip\Method as M;
use Moip\Resource\MoipResource as Sb;
// 2017-04-26
final class Operation extends Sb {
	/**
	 * 2017-04-26
	 * @override
	 * @see Sb::__construct()
	 */
	function __construct() {/** @var M $m */$m = dfpm($this); parent::__construct($m->api());}

	/**
	 * 2017-04-26
	 * @used-by \Dfe\Moip\SDK\Customer::create()
	 * @param string $path
	 * @param string $method
	 * @param array(string => mixed)|\stdClass|null $payload
	 * @return \stdClass
	 */
	function exec($path, $method, $payload = null) {
		$this->_req = new Message($payload);
		/** @var \stdClass $result */
		$this->_res = new Message($result = $this->httpRequest($path, $method, $payload));
		return $result;
	}

	/**
	 * 2017-04-26
	 * @return Message
	 */
	function req() {return $this->_req;}

	/**
	 * 2017-04-26
	 * @used-by \Dfe\Moip\SDK\Entity::a()
	 * @used-by \Dfe\Moip\SDK\Entity::j()
	 * @used-by \Dfe\Moip\SDK\Entity::offsetGet()
	 * @return Message
	 */
	function res() {return $this->_res;}

	/**
	 * 2017-04-26
	 * @override
	 * @see Sb::initialize()
	 * @used-by Sb::__construct()
	 */
	protected function initialize() {}

	/**
	 * 2017-04-26
	 * @override
	 * @see Sb::populate()
	 * @used-by Sb::createResource()
	 * @used-by Sb::getByPath()
	 * @param \stdClass $r
	 * @return void
	 */
	protected function populate(\stdClass $r) {df_should_not_be_here();}

	/**
	 * 2017-04-26
	 * @used-by exec()
	 * @var Message
	 */
	private $_req;

	/**
	 * 2017-04-26
	 * @used-by exec()
	 * @var Message
	 */
	private $_res;
}