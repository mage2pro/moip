<?php
namespace Dfe\Moip\API\Facade;
/**
 * 2017-08-07
 * «Preferências de notificação» (in Portugese)
 * https://dev.moip.com.br/v2.0/reference#preferências-de-notificação
 *
 * «Notification preferences» (in English)
 * https://dev.moip.com.br/page/api-reference#section-notification-preferences
 *
 * «Criar Preferência de Notificação» (in Portugese)
 * https://dev.moip.com.br/v2.0/reference#criar-preferência-de-notificação
 *
 * «Create notification preference» (in English)
 * https://dev.moip.com.br/page/api-reference#section-create-notification-preference-post-
 *
 * [Moip] An example of a response to «POST v2/preferences/notifications»: https://mage2.pro/t/4248
 *
 * «Listar Todas Preferências de Notificação» (in Portugese)
 * https://dev.moip.com.br/v2.0/reference#listar-todas-preferências-de-notificação
 *
 * «List all notification preferences» (in English)
 * https://dev.moip.com.br/page/api-reference#section-list-all-notification-preferences-get-
 *
 * [Moip] An example of a response to «GET v2/preferences/notifications» https://mage2.pro/t/4250
 *
 * «Webhooks» (in English)
 * https://dev.moip.com.br/page/api-reference#section-webhooks
 *
 * «List of webhooks available» (in English)
 * https://dev.moip.com.br/page/api-reference#section-list-of-webhooks-available
 *
 * @used-by \Dfe\Moip\FE\Webhooks::onFormInitialized()
 */
final class Notification extends \Df\API\Facade {
	/**
	 * 2017-08-10
	 * 2017-10-19
	 * `The GET «https://sandbox.moip.com.br/v2/preferences/notifications» API endpoint
	 * is down today (2017-10-19):
	 * «502 Proxy Error: The proxy server received an invalid response from an upstream server».
	 * We should handle this in a proper way`: https://github.com/mage2pro/moip/issues/21
	 * @used-by \Dfe\Moip\Backend\Enable::dfSaveAfter()
	 * @used-by \Dfe\Moip\FE\Webhooks::onFormInitialized()
	 * @return string[]
	 */
	function targets() {return array_column($this->all()->a(), 'target');}

	/**
	 * 2017-08-07
	 * @override
	 * @see \Df\API\Facade::prefix()
	 * @used-by \Df\API\Facade::path()
	 * @return string
	 */
	protected function prefix() {return 'preferences';}

	/**
	 * 2017-10-19
	 * `The GET «https://sandbox.moip.com.br/v2/preferences/notifications» API endpoint
	 * is down today (2017-10-19):
	 * «502 Proxy Error: The proxy server received an invalid response from an upstream server».
	 * We should handle this in a proper way`: https://github.com/mage2pro/moip/issues/21
	 * @override
	 * @see \Df\API\Facade::zfConfig()
	 * @used-by \Df\API\Facade::p()
	 * @return array(string => mixed)
	 */
	protected function zfConfig() {return ['timeout' => 15] + parent::zfConfig();}
}