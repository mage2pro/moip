<?php
namespace Dfe\Moip\Backend;
use Dfe\Moip\API\Facade\Notification as N;
use Dfe\Moip\Method as M;
use Dfe\Moip\Settings as S;
use Magento\Store\Model\Store;
# 2017-08-07
/** @final Unable to use the PHP «final» keyword here because of the M2 code generation. */
class Enable extends \Df\Config\Backend\Checkbox {
	/**
	 * 2017-08-07
	 * @override
	 * @see \Df\Config\Backend::dfSaveAfter()
	 * @used-by \Df\Config\Backend::save()
	 */
	final protected function dfSaveAfter() {
		parent::dfSaveAfter();
		df_cache_clean();
		$m = dfpm($this); /** @var M $m */
		foreach (df_scope_stores() as $store) { /** @var Store $store */
			$m->setStore($store->getId());
			if ($m->s()->enable()) {
				$target = df_webhook($this, '', false, $store); /** @var string) $target */
				$n = new N; /** @var N $n */
				if (!in_array($target, $n->targets())) {
					$n->create([
						# 2017-08-07
						# In Portugese:
						# «Eventos configurados para serem enviados.
						# Exemplo: PAYMENT.AUTHORIZED. Valores possíveis: ver lista de webhooks.
						# String list, obrigatório»
						# In English:
						# «Events that will be notified.
						# Examples: PAYMENT.AUTHORIZED. Possible values: see Webhooks list.
						# String list, required»
						'events' => ['PAYMENT.*', 'REFUND.*']
						# 2017-08-07
						# In Portugese: «Tipo da notificação. Valores possíveis: WEBHOOK. String, obrigatório»
						# In English: «Notification type. Valores possíveis: WEBHOOK. String, required»
						,'media' => 'WEBHOOK'
						# 2017-08-07
						# In Portugese: «URL de notificação. String, obrigatório»
						# In English: «URL. String, required»
						,'target' => $target
					]);
				}
			}
		}
	}
}