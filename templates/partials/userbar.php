<div>
  <div class="pull-left half-width">
    <a id="profile" href="/profile" title="Profile" data-widget-action="open" data-widget-name="profile">
      <div class="pull-left"> <?= \helpers\minotar\MinotarHelper::head($user['playername'], 30) ?></div>
      <div class="pull-left "><?= $user['playername'] ?></div>
    </a>
  </div>

  <div class="pull-right half-width">
    <div class="userbar pull-right"> 
    <? if ($user['admin'] == 1): ?>
      <a class="button" href="/admin" title="Admin" data-widget-action="open" data-widget-name="admin"></a>
      <a class="button" href="/admin/accounts" title="Acounts" data-widget-action="open" data-widget-name="admin-accounts"></a>
      <a class="button" href="/admin/sessions" title="Sessions" data-widget-action="open" data-widget-name="admin-sessions"></a>
      <a class="button" href="/admin/drops" title="Drops" data-widget-action="open" data-widget-name="admin-drops"></a>
    <? endif; ?>
      <a class="button" href="/maps" title="Mapa" data-widget-action="open" data-widget-name="maps"></a>
      <a class="button" href="/maps" title="Mapa" data-widget-action="open-copy" data-widget-name="maps"></a>    
      <a class="button" href="/directory" data-widget-action="open" data-widget-name="directory"></a>
      <a class="button" href="/news" title="Notícias" data-widget-action="open" data-widget-name="news"></a>
      <a class="button" href="#" title="Logout" data-widget-action="open" data-widget-name="logout"></a>
      <a class="button" href="#" title="Esconder" data-widget-action="open" data-widget-name="close"></a>
    </div>

    <div class="sep pull-right"></div>

    <div id="ajax-indicator" class="pull-right">
    </div>

  </div>
</div>

