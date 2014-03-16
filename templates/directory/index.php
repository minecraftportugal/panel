<div id="widget-directory">

  <h1>Jogadores</h1>
  <div class="page-filters">
    <div class="page-filters-tab">Filtros</div>
    <div class="page-filters-body">
      <form name="directory_users_filters" action="/directory" method="GET" autocomplete="off">

        <h2>Nome</h2>
        <input type="text" name="playername" placeholder="steve" value="<?= $p['playername']; ?>">

        <h2>Critérios</h2>
        <input id="staff" type="checkbox" name="staff" value="1" <?= $p['staff'] == 1 ? 'checked="checked"' : '' ?> />
        <label class="checkbox" for="staff">staff</label>
        <input id="contributor" type="checkbox" name="contributor" value="1" <?= $p['contributor'] == 1 ? 'checked="checked"' : '' ?> />
        <label class="checkbox" for="contributor">contribuidor</label>
        <input id="donor" type="checkbox" name="donor" value="1" <?= $p['donor'] == 1 ? 'checked="checked"' : '' ?> />
        <label class="checkbox" for="donor">dador</label>
        <input id="premium" type="checkbox" name="premium" value="1" <?= $p['premium'] == 1 ? 'checked="checked"' : '' ?> />
        <label class="checkbox" for="premium">premium</label>
        <input id="isonline" type="checkbox" name="online" value="1" <?= $p['online'] == 1 ? 'checked="checked"' : '' ?> />
        <label class="checkbox" for="isonline">online</label>
        <input type="submit" value="pesquisar" />
      </form>
    </div>
  </div>

  <div class="page-body">
  <? if (!empty($pages)): ?>

    <? foreach((array)$pages as $r): ?>

      <? $badges = getUserBadges($r["id"]); ?>

      <div class="directory-player pull-left">
        <a href="/profile?id=<?= $r['id'] ?>" title="<?= $r["registerdate"] ?>">
        <div class="pull-clear sep"></div>
        
          <?= \helpers\minotar\MinotarHelper::head($r['playername'], 40) ?>

         <div class="pull-clear sep"></div>

        <span data-online="<?=$r["online"] == "1" ? 'true' : 'false' ?>">
          <?= $r["playername"] ?>
        </span>

        <div class="pull-clear sep"></div>

        <div class="badges">

          <? if ($badges['member'] == 1): ?>
            <span title="Membro" class="badge2 badge-member"></span>
          <? endif; ?>  
          
          <? if ($badges['admin'] == 1): ?>
            <span title="Administrador do Servidor" class="badge2 badge-administrator"></span>
          <? endif; ?>
         
          <? if ($badges['operator'] == 1): ?>
            <span title="Operador do Servidor" class="badge2 badge-operator"></span>
          <? endif; ?>
         
          <? if ($badges['donor'] == 1): ?>
            <span title="Dador" class="badge2 badge-donor"></span>
          <? endif; ?>
         
          <? if ($badges['contributor'] == 1): ?>
            <span title="Contribuidor" class="badge2 badge-contributor"></span>
          <? endif; ?>
          
          <? if ($badges['premium'] == 1): ?>
            <span title="Premium" class="badge2 badge-premium"></span>
          <? endif; ?>
        
          <? if ($badges['active'] != 1): ?>
            <span title="Conta Desactivada" class="badge2 badge-deactivated"></span>
          <? endif; ?>

          <? if (($badges['premium'] == 1)
          or  ($badges['admin'] == 1)
          or  ($badges['operator'] == 1)
          or  ($badges['donor'] == 1)
          or  ($badges['contributor'] == 1)
          or  ($badges['active'] != 1)
          or  ($badges['member'] == 1)):
          ?>
            <div style="height:10px;clear:both;"></div>
          <? endif; ?>

        </div>

      <div class="pull-clear sep"></div>

      </a>
    </div>

    <? endforeach; ?>

    

  <? endif; ?>
  </div>

  <div class="nav"><?= $page_navigation ?></div>

</div>
