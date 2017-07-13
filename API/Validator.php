<?php
namespace Dfe\Moip\API;
/**
 * 2017-07-13
 * An error response looks like:
 *	{"errors": [{"code": "PAY-999", "path": "", "description": "Cartão de crédito não foi encontrado"}]}
 * https://dev.moip.com.br/v2.0/reference#section--error-states-
 * Some examples of successfull responses: https://mage2.pro/tags/moip-api
 * @used-by \Dfe\Moip\API\Client::responseValidatorC()
 */
final class Validator extends \Df\API\Response\Validator {
	/**
	 * 2017-07-13
	 * @override
	 * @see \Df\API\Exception::long()
	 * @used-by \Df\API\Client::p()
	 * @return string
	 */
	function long() {return df_json_encode(array_map('df_clean', $this->r()['errors']));}

	/**
	 * 2017-07-13
	 * @override
	 * @see \Df\API\Exception::short()
	 * @used-by \Df\API\Client::p()
	 * @return string
	 */
	function short() {return dfa_deep($this->r(), 'errors/0/description');}

	/**
	 * 2017-07-13
	 * @override
	 * @see \Df\API\Response\Validator::valid()
	 * @used-by \Df\API\Response\Validator::validate()
	 * @return bool
	 */
	function valid() {return !dfa($this->r(), 'errors');}
}