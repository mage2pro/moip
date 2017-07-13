<?php
namespace Dfe\Moip\API;
use Dfe\Moip\Settings as S;
// 2017-07-13
final class Client extends \Df\API\Client {
	/**
	 * 2017-07-13
	 * @override
	 * @see \Df\API\Client::_construct()
	 * @used-by \Df\API\Client::__construct()
	 */
	protected function _construct() {parent::_construct(); $this->reqJson(); $this->resJson();}

	/**
	 * 2017-07-13
	 * The Moip documentation does not have a dedicated section for common HTTP headers,
	 * and such information is duplicated for each API request. e.g.:
	 * https://dev.moip.com.br/v2.0/reference#criar-um-cliente
	 * @override
	 * @see \Df\API\Client::headers()
	 * @used-by \Df\API\Client::__construct()
	 * @used-by \Df\API\Client::p()
	 * @return array(string => string)
	 */
	protected function headers() {/** @var S $s */$s = dfps($this); return [
		// 2017-07-13 Should be a HTTP Basic access authentication header. Required.
		// https://en.wikipedia.org/wiki/Basic_access_authentication
		// https://github.com/moip/moip-sdk-php/blob/v1.2.0/src/Auth/BasicAuth.php#L66
		'Authorization' => 'Basic ' . base64_encode("{$s->privateToken()}:{$s->privateKey()}")
		// 2017-07-13 Should be «application/json». Required.
		,'Content-Type' => 'application/json'
	];}

	/**
	 * 2017-07-13
	 * @see \Df\API\Client::responseValidatorC()
	 * @used-by \Df\API\Client::p()
	 * @return string
	 */
	final protected function responseValidatorC() {return \Dfe\Moip\API\Validator::class;}

	/**
	 * 2017-07-13
	 * @override
	 * @see \Df\API\Client::uriBase()
	 * @used-by \Df\API\Client::__construct()
	 * @used-by \Df\API\Client::p()
	 * @return string
	 */
	protected function uriBase() {return dfp_url_api(
		$this, 'https://{stage}.moip.com.br/v2', ['sandbox', 'api']
	);}
}