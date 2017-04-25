<?php
namespace Dfe\Moip\SDK;
use Moip\Exceptions\UnautorizedException as leUnautorized;
use Moip\Exceptions\UnexpectedException as leUnexpected;
use Moip\Exceptions\ValidationException as leValidation;
use Moip\Resource\Customer as Sb;
// 2017-04-25
final class Customer extends Sb {
	/**
	 * 2017-04-25
	 * @param array(string => mixed) $a
	 * @return self
	 * @throws leUnautorized|leUnexpected|leValidation
	 */
	function createA(array $a) {
		/** @var \stdClass $resO */
		$resO = $this->httpRequest('/v2/customers/', 'POST', $a);
		/** @var self $result */
		$result = $this->populate($resO);
		$result->_resJ = df_json_encode_pretty($resO);
		$result->_resA = df_json_decode($result->_resJ);
		return $result;
	}

	/**
	 * 2017-04-25 The API response as an associative array.
	 * @return array(string => mixed)
	 */
	function resA() {return $this->_resA;}

	/**
	 * 2017-04-25 The API response as an associative array.
	 * @return array(string => mixed)
	 */
	function resJ() {return $this->_resJ;}

	/**
	 * 2017-04-25 The API response as an associative array.
	 * @used-by createA()
	 * @used-by resA()
	 * @var array(string => mixed)
	 */
	private $_resA;

	/**
	 * 2017-04-25 The API response as JSON.
	 * @used-by createA()
	 * @used-by resJ()
	 * @var string
	 */
	private $_resJ;
}