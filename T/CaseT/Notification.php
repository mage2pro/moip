<?php
namespace Dfe\Moip\T\CaseT;
use Dfe\Moip\API\Facade\Notification as N;
/**
 * 2017-08-07 
 * «Preferências de notificação» (in Portugese)
 * https://dev.moip.com.br/v2.0/reference#preferências-de-notificação
 * «Notification preferences» (in English)
 * https://dev.moip.com.br/page/api-reference#section-notification-preferences
 */
final class Notification extends \Dfe\Moip\T\CaseT {
	/** 2017-08-07 */
	function t00() {}

	/**
	 * @test 2017-08-07
	 * «Listar Todas Preferências de Notificação» (in Portugese)
	 * https://dev.moip.com.br/v2.0/reference#listar-todas-preferências-de-notificação
	 * «List all notification preferences» (in English)
	 * https://dev.moip.com.br/page/api-reference#section-list-all-notification-preferences-get-
	 */
	function t01_all() {
		try {
			echo (new N)->all()->j();
			//echo df_json_encode($this->pOrder());
		}
		catch (\Exception $e) {
			if (function_exists('xdebug_break')) {
				xdebug_break();
			}
			throw $e;
		}
	}
}