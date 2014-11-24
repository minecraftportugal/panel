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
              <input id="login" type="checkbox" name="login" value="1" <?= $p['login'] == 1 ? 'checked="checked"' : '' ?> />
              <label class="checkbox" for="login" title="apenas logins">login</label>
        </li>
        <li>
              <input id="logout" type="checkbox" name="logout" value="1" <?= $p['logout'] == 1 ? 'checked="checked"' : '' ?> />
              <label class="checkbox" for="logout" title="apenas logouts">logout</label>
        </li>
        <li>
              <input id="session_online" type="checkbox" name="online" value="1" <?= $p['online'] == 1 ? 'checked="checked"' : '' ?> />
              <label class="checkbox" for="session_online">online</label>
        </li>
        <li>
              <input id="session_web" type="checkbox" name="web" value="1" <?=$p['web'] == 1 ? 'checked="checked"' : '' ?> />
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

      <table class="alt-rows">

        <?= $table->render_header(); ?>

        <tbody class="font-mono">
        <? foreach((array)$page as $r): ?>
          <tr>
            <td>
                <span><?= \helpers\minotar\MinotarHelper::head($r['playername'], 24, 3) ?></span>
            </td>
            <td class="">
              <a href="/profile?id=<?= $r['id'] ?>"
                 title="<?= $r["registerdate"] ?>"
                 class="noajax"
                 data-widget-action="open"
                 data-widget-classes="widget-scrollable-y"
                 data-widget-name="profile-<?= $r["playername"] ?>"
                 data-widget-title="<i class='fa fa-user'></i> <?= $r["playername"] ?>"
                 data-online="<?=$r["online"] == "1" ? 'true' : 'false' ?>">
                  <span class="pull-left"><?= $r["playername"] ?></span>
                  <span class="pull-left online" title="O jogador está online!"></span>
                </a>
            </td>

           <td>
                <a href="/admin/sessions?ipaddress=<?= $r["ipaddress"] ?>">
                  <?= $r["ipaddress"] ?>
                </a>
            </td>

            <td>
                <?= $r["time_df"] ?>
            </td>
            <td>
                <?= $r["event"] == 2 ? "<i class='fa fa-sign-out'></i> Logout" : "<i class='fa fa-sign-in'></i> Login" ?> <?= $r["websession"] == 1 ? "(no Site)" : "(In-Game)" ?>
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

    <div class="navigation center">
      <?= $pagination->render() ?>
    </div>

    <div class="separator"></div>
