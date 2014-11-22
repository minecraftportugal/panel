<div id="widget-accounts">

  <div class="page-panel-header page-panel-left">
    <h1><i class="fa fa-chevron-circle-right"></i> Filtros</h1>
  </div>

  <div class="page-panel-header page-panel-right">
    <h1 class="pull-left">Sessões (<?= $total ?>)</h1>
    <?= $notices ?>
  </div>

    <div class="page-panel-body page-panel-left page-filters page-panel-scrollable-auto">
    <form name="manage_sessions_filter" action="<?= $action_url ?>" method="GET" autocomplete="off">
      <ul>
        <li>
          <h2>Nome</h2>
        </li>
        <li>
          <input type="text" name="playername" placeholder="steve" value="<?= $p['playername'] ?>">
        </li>
        <li>
          <h2>Endereço IP</h2>
        </li>
        <li>
          <input type="text" name="ipaddress" placeholder="192.168.0.1" value="<?= $p['ipaddress'] ?>">
        </li>
        <li>
          <h2 title="Apenas serão sessões iniciadas após esta data">Iniciada desde</h2>
        </li>
        <li>
          <input type="date" name="date_begin" value="<?= $p['date_begin'] ?>">
        </li>
        <li>
          <h2 title="Apenas serão sessões iniciadas até esta data">Iniciada até</h2>
        </li>
        <li>
          <input type="date" name="date_end" value="<?= $p['date_end'] ?>">
        </li>
        <li>
          <h2>Critérios</h2>
        </li>
        <li>
              <input id="session_valid" type="checkbox" name="session_valid" value="1" <?= $session_valid == 1 ? 'checked="checked"' : '' ?> />
              <label class="checkbox" for="session_valid" title="sessão não expirada">sessão válida</label>
        </li>
        <li>
              <input id="session_invalid" type="checkbox" name="session_invalid" value="1" <?= $session_invalid == 1 ? 'checked="checked"' : '' ?> />
              <label class="checkbox" for="session_invalid" title="sessão expirada">sessão inválida</label>
        </li>
        <li>
              <input id="session_online" type="checkbox" name="session_online" value="1" <?= $session_online == 1 ? 'checked="checked"' : '' ?> />
              <label class="checkbox" for="session_online">online</label>
        </li>
        <li>
              <input id="session_web" type="checkbox" name="session_web" value="1" <?= $session_web == 1 ? 'checked="checked"' : '' ?> />
              <label class="checkbox" for="session_web">sessão web</label>
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

    <form name="manage_users" action="/sessions/configure" method="POST" autocomplete="off">
      <table class="alt-rows">
        
        <?= $table->render_header(); ?>

        <tbody class="font-mono">
        <? foreach((array)$page as $r): ?>
          <tr>
            <td>
                <span><?= \helpers\minotar\MinotarHelper::head($r['playername'], 24, 3) ?></span>
            </td>
            <td class="">
                <a data-online="<?= $r['online'] ? 'true' : 'false' ?>"
                   href="/profile?id=<?= $r['id'] ?>"
                   title="<?= $r["email"] ?>"
                   class="noajax"
                   data-widget-action="open"
                   data-widget-name="profile-<?= $r['playername'] ?>">
                  <span class="pull-left"><?= $r["playername"] ?></span>
                  <span class="pull-left online" title="O jogador está online!"></span>
                </a>
            </td>

           <td>
                <a href="/sessions?ipaddress=<?= $r["ipaddress"] ?>">
                  <?= $r["ipaddress"] ?>
                </a>
            </td>

            <td>
                <?= $r["logintime"] ?>
            </td>

            <td>
                <?= $r["websession"] ?>
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
                Não foram encontradas sessões através dos critérios especificados!
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
