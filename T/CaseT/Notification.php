<?php
namespace Dfe\Moip\T\CaseT;
use Df\API\Operation as O;
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
	 * 2017-08-07
	 * «Listar Todas Preferências de Notificação» (in Portugese)
	 * https://dev.moip.com.br/v2.0/reference#listar-todas-preferências-de-notificação
	 * «List all notification preferences» (in English)
	 * https://dev.moip.com.br/page/api-reference#section-list-all-notification-preferences-get-
	 * [Moip] An example of a response to «GET v2/preferences/notifications» https://mage2.pro/t/4250
	 */
	function t01_all() {
		try {
			echo (new N)->all()->j();
		}
		catch (\Exception $e) {
			if (function_exists('xdebug_break')) {
				xdebug_break();
			}
			throw $e;
		}
	}

	/**
	 * 2017-08-07
	 * «Criar Preferência de Notificação» (in Portugese)
	 * https://dev.moip.com.br/v2.0/reference#criar-preferência-de-notificação
	 * «Create notification preference» (in English)
	 * https://dev.moip.com.br/page/api-reference#section-create-notification-preference-post-
	 * [Moip] An example of a response to «POST v2/preferences/notifications»: https://mage2.pro/t/4248
	 */
	function t02_create() {
		try {
			echo $this->create()->j();
			//echo df_json_encode($this->pOrder());
		}
		catch (\Exception $e) {
			if (function_exists('xdebug_break')) {
				xdebug_break();
			}
			throw $e;
		}
	}

	/**
	 * 2017-08-08
	 * «Remover Preferência de Notificação» (in Portugese)
	 * https://dev.moip.com.br/v2.0/reference#remover-preferência-de-notificação
	 * «Delete notification preference» (in English)
	 * https://dev.moip.com.br/page/api-reference#section-delete-notification-preference-delete-
	 */
	function t03_delete() {
		try {
			echo (new N)->delete($this->create()['id'])->j();
			//echo df_json_encode($this->pOrder());
		}
		catch (\Exception $e) {
			if (function_exists('xdebug_break')) {
				xdebug_break();
			}
			throw $e;
		}
	}

	/** @test 2017-08-10 */
	function t04_delete_all() {
		try {
			$n = new N; /** @var N $n */
			array_map(function($id) use($n) {
				$n->delete($id);
				echo "Deleted: $id\n";
			}, array_column($n->all()->a(), 'id'));
		}
		catch (\Exception $e) {
			if (function_exists('xdebug_break')) {
				xdebug_break();
			}
			throw $e;
		}
	}

	/**
	 * 2017-08-08
	 * @used-by t02_create()
	 * @used-by t03_delete()
	 * @return O
	 */
	private function create() {return (new N)->create([
		// 2017-08-07
		// In Portugese:
		// «Eventos configurados para serem enviados.
		// Exemplo: PAYMENT.AUTHORIZED. Valores possíveis: ver lista de webhooks.
		// String list, obrigatório»
		// In English:
		// «Events that will be notified.
		// Examples: PAYMENT.AUTHORIZED. Possible values: see Webhooks list.
		// String list, required»
		'events' => ['PAYMENT.*', 'REFUND.*']
		// 2017-08-07
		// In Portugese: «Tipo da notificação. Valores possíveis: WEBHOOK. String, obrigatório»
		// In English: «Notification type. Valores possíveis: WEBHOOK. String, required»
		,'media' => 'WEBHOOK'
		// 2017-08-07
		// In Portugese: «URL de notificação. String, obrigatório»
		// In English: «URL. String, required»
		,'target' => df_webhook($this, df_uid(6))
	]);}
}