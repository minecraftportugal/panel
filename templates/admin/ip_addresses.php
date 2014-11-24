<div id="widget-ip-addresses">

  <div class="page-panel-body page-panel-scrollable">

    <table class="alt-rows">
      
      <?= $table->render_header(); ?>

      <tbody class="font-mono">
      <? foreach((array)$addresses as $r): ?>
        <tr>
        
          <td>
              <a href="/admin/accounts?ipaddress=<?= $r['lastip'] ?>"
                 class="noajax"
                 data-widget-action="open"
                 data-widget-name="admin-accounts"
                 data-widget-title="<i class='fa fa-users'></i> Contas">
                    <?= $r["lastip"] ?>
              </a>
          </td>

          <td>
              <?= $r["total"] ?>
          </td>

          <td>
              <?= $r["playernames"] ?>
          </td>

        </tr>
      <? endforeach; ?>

      <? if ($total == 0): ?>
        <tr>
          <td colspan="3" class="center">
            <div>
              Não foram encontrados jogadores através dos critérios especificados!
            </div>
          </td>

        </tr>
      <? endif; ?>
      
      </tbody>
    </table>

    <div class="separator"></div>

  </div>

</div>