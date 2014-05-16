<div id="widget-fails">

  <div class="page-panel-header page-panel-left">
    <h1><i class="fa fa-chevron-circle-right"></i> Filtros</h1>
  </div>

  <div class="page-panel-header page-panel-right">
    <h1 class="pull-left">Fail Events (<?= $total ?>)</h1>
    <?= $notices ?>
  </div>

  <div class="page-panel-body page-panel-left page-filters page-panel-scrollable-auto">
    <form name="manage_fails_filters" action="<?= $action_url ?>" method="GET" autocomplete="off">
      <ul>
        <li>
          <h2>Critérios</h2>
        </li>
        <li>
          <input type="submit" value="pesquisa" />
        </li>
        <li>
          <input type="reset" value="reset" />
        </li>
      </ul>
    </form>
  </div>

  <div class="page-panel-body page-panel-right page-panel-scrollable">

    <form name="manage_fails" action="/admin/delete_fails" method="POST" autocomplete="off">
      <table class="alt-rows">

        <?= $table->render_header(); ?>

        <tbody class="font-mono">
        <? foreach((array)$page as $r): ?>
          <tr>

            <td>
                <?= $r["time"] ?>
            </td>

            <td>
                <?= $r["event_type"] ?>
            </td>

            <td>
                <?= $r["ipaddress"] ?>
            </td>

            <td>
                <?= $r["playername"] ?>
            </td>

            <td>
                <?= $r["comment"] ?>
            </td>

            <td class="center">
                <input class="check-delete" name="delete[]" value="<?= $r["id"] ?>" type="checkbox" />
            </td>

          </tr>
        <? endforeach; ?>

        <? if ($total == 0): ?>
          <tr>
            <td colspan="8" class="center">
              <div>
                Não foram encontrados eventos através dos critérios especificados!
              </div>
            </td>
          </tr>
        <? endif; ?>
        
        </tbody>
      </table>

      <div class="separator"></div>

      <div class="center">
        <input type="hidden" name="xsrf_token" value="<?= getXSRFToken() ?>" />
        <input type="submit" value="OK" />
      </div>            
    </form>

    <div class="separator"></div>

    <div class="navigation center">
      <?= $pagination->render() ?>
    </div>

    <div class="separator"></div>
</div>

