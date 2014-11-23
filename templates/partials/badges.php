<div class="layout-badge-container">
  <? if ($badges['active'] != 1): ?><span title="Conta Desactivada" class="badge badge-deactivated"></span><? endif; ?>
  <? if ($badges['admin'] == 1): ?><span title="Administrador do Servidor" class="badge badge-administrator"></span><? endif; ?>
  <? if ($badges['operator'] == 1): ?><span title="Operador do Servidor" class="badge badge-operator"></span><? endif; ?>
  <? if ($badges['donor'] == 1): ?><span title="Dador" class="badge badge-donor"></span><? endif; ?>
  <? if ($badges['contributor'] == 1): ?><span title="Contribuidor" class="badge badge-contributor"></span><? endif; ?>
  <? if ($badges['premium'] == 1): ?><span title="Premium" class="badge badge-premium"></span><? endif; ?>
  <? if ($badges['member'] == 1): ?><span title="Membro" class="badge badge-member"></span><? endif; ?>
</div>