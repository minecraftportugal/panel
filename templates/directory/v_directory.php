<div id="widget-directory">

  <div class="page-panel-header page-panel-left">
    <h1><i class="fa fa-chevron-circle-right"></i> Filtros</h1>
  </div>


  <div class="page-panel-header page-panel-right">
    <h1>Jogadores</h1>
  </div>

  <div class="page-panel-body page-panel-left page-filters page-panel-scrollable-auto">
    <form name="directory_users_filters" action="/directory" method="GET" autocomplete="off">
      <ul>
        <li>
          <h2>Nome</h2>
        </li>
        <li>
          <input type="text" name="playername" placeholder="steve" value="<?= $p['playername']; ?>">
        </li>
        <li>
          <h2>Critérios</h2>
        </li>
        <li>
          <input id="chk-staff" type="checkbox" name="staff" value="1" <?= $p['staff'] == 1 ? 'checked="checked"' : '' ?> />
          <label for="chk-staff">staff</label>
        </li>
        <li>
          <input id="chk-contributor" type="checkbox" name="contributor" value="1" <?= $p['contributor'] == 1 ? 'checked="checked"' : '' ?> />
          <label for="chk-contributor">contribuidor</label>
        </li>
        <li>
          <input id="chk-donor" type="checkbox" name="donor" value="1" <?= $p['donor'] == 1 ? 'checked="checked"' : '' ?> />
          <label for="chk-donor">dador</label>
        </li>
        <li>
          <input id="chk-premium" type="checkbox" name="premium" value="1" <?= $p['premium'] == 1 ? 'checked="checked"' : '' ?> />
          <label for="chk-premium">premium</label>
        </li>
        <li>
          <input id="chk-isonline" type="checkbox" name="online" value="1" <?= $p['online'] == 1 ? 'checked="checked"' : '' ?> />
          <label for="chk-isonline">online</label>
        </li>
        <li>
          <input type="submit" value="pesquisar" />
        </li>
        <li>
          <input type="reset" value="limpar" />
        </li>
      </ul>
    </form>
  </div>


  <div class="page-panel-body page-panel-right page-panel-scrollable">

    <? foreach((array)$pages as $r): ?>

      <div class="player-cell pull-left">
        <a href="/profile?id=<?= $r['id'] ?>"
           title="<?= $r["registerdate"] ?>"
           class="noajax"
           data-widget-action="open"
           data-widget-classes="widget-scrollable-y"
           data-widget-name="profile-<?= $r["playername"] ?>"
           data-widget-title="<i class='fa fa-user'></i> <?= $r["playername"] ?>">

        <div class="section-1">
          <span>
            <?= $r["playername"] ?>
          </span>
        </div>
        
        <div class="section-2 font-mono">
            <?= \helpers\minotar\MinotarHelper::head($r['playername'], 64) ?>
        </div>


        <div class="section-3">
          <?
            $badges = \models\account\AccountModel::badges($r['id']);
            require(__DIR__."/../partials/badges.php"); 
          ?>
        </div>

      </a>
    </div>

    <? endforeach; ?>

      <? if ($total == 0): ?>
        <div class="center">
          Não foram encontrados jogadores através dos critérios especificados!
        </div>
      <? endif; ?>

    <div class="separator"></div>

    <div class="pagination center">
      <?= $pagination->render() ?>
    </div>

    <div class="separator"></div>

  </div>

</div>
