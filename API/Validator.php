<?php
namespace Dfe\Moip\API;
# 2017-07-13
/** @used-by \Dfe\Moip\API\Client::responseValidatorC() */
final class Validator extends \Df\API\Response\Validator {
	/**
	 * 2017-07-13
	 * @override
	 * @see \Df\API\Response\Validator::long()
	 * @used-by \Df\API\Client::_p()
	 */
	function long():string {return $this->error() ?: df_json_encode(array_map('df_clean', $this->errors()));}

	/**
	 * 2017-07-13
	 * 2017-07-20
	 * We should use @uses dfa_deep, not dfa(), because of the «0/description» path.
	 * https://sentry.io/dmitry-fedyuk/mage2pro-moip/issues/313861903
	 * @override
	 * @see \Df\API\Exception::short()
	 * @used-by \Df\API\Client::_p()
	 */
	function short():string {return $this->error() ?: dfa_deep($this->errors(), '0/description');}

	/**
	 * 2017-07-13
	 * @override
	 * @see \Df\API\Response\Validator::valid()
	 * @used-by \Df\API\Client::_p()
	 */
	function valid():bool {return !$this->error() && !$this->errors();}

	/**
	 * 2017-07-06
	 * An error response with the «500 Internal Server Error» HTTP code:
	 * 	{"ERROR": "Ops... We were not waiting for it"}
	 * `A «POST /v2/customers» request with a bank card hash as a «fundingInstruments» parameter leads to an undocumented «{"ERROR": "Ops... We were not waiting for it"}» response with «500 Internal Server Error» HTTP code` https://mage2.pro/t/4174
	 * @used-by self::long()
	 * @used-by self::short()
	 * @used-by self::valid()
	 * @return string|null
	 */
	private function error() {return $this->r('ERROR');}

	/**
	 * 2017-07-13
	 * An usual error response looks like:
	 *	{"errors": [{"code": "PAY-999", "path": "", "description": "Cartão de crédito não foi encontrado"}]}
	 * https://dev.moip.com.br/v2.0/reference#section--error-states-
	 * 2017-07-22
	 * An error response with 2 messages:
	 *	[
	 *		{
	 *			"code": "PAY-033",
	 *			"description": "A data de nascimento do portador do cartão é inválido",
	 *			"path": "fundingInstrument.creditCard.holder.birthdate"
	 *		},
	 *		{
	 *			"code": "PAY-033",
	 *			"description": "A data de nascimento do portador do cartão é inválido",
	 *			"path": "fundingInstrument.creditCard.holder.validBirthdate"
	 *		}
	 *	]
	 * @used-by self::long()
	 * @used-by self::short()
	 * @used-by self::valid()
	 * @return array(array(string => string))|null
	 */
	private function errors() {return $this->r('errors');}
}