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
 */
final class Notification extends \Df\API\Facade {
	/**
	 * 2017-08-07
	 * @override
	 * @see \Df\API\Facade::prefix()
	 * @used-by \Df\API\Facade::p()
	 * @return string
	 */
	protected function prefix() {return 'preferences';}
}