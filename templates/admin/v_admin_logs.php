<div id="widget-logs">

  <?= $notices ?>

    <? //var_dump($parameters); die(); ?>

  <div class="page-panel-body page-panel-left page-filters page-panel-scrollable-auto">
    <form name="manage_logs_filters" action="<?= $action_url ?>" method="GET" autocomplete="off">
      <ul>
        <li>
          Events (<?= $total ?>)
        </li>
        <li>
          <h2>Critérios</h2>
        </li>
      <? foreach($event_types as $event_type): ?>
        <li>
          <input id="chk_<?= $event_type ?>" type="checkbox" name="event_type[<?= $event_type ?>]" value="1" <?= /*$parameters["event_type[" . $event_type . "]"]*/ 1  == 1 ? 'checked="checked"' : '' ?> />
          <label class="checkbox" for="chk_<?= $event_type ?>" title="<?= $event_type ?>"><?= $event_type ?></label>
        </li>
      <? endforeach; ?>
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

    <form name="manage_logs" action="<?= $form_url ?>" method="POST" autocomplete="off">
      <table class="listing alt-rows">

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
        <input type="hidden" name="xsrf_token" value="<?= $xsrf_token ?>">
        <input type="submit" value="OK">
      </div>            
    </form>

    <div class="separator"></div>

    <div class="navigation center">
      <?= $pagination->render() ?>
    </div>

    <div class="separator"></div>
</div>

