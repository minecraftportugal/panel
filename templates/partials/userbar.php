<ul class="pull-left">
    <li><a href="#menu1">admin</a>
      <ul id="menu1">
        <li><a href="#">contas</a></li>
        <li><a href="#">sessões</a></li>
        <li><a href="#">item drops</a></li>
      </ul>
    </li>
</ul>

<ul class="pull-left">
  <li><a href="#menu2">ajuda</a>
    <ul id="menu2">
      <li><a href="#">como jogar</a></li>
      <li><a href="#">it's a trap</a></li>
    </ul>
  </li>
</ul>

<ul class="pull-right">
    <li>
      <a id="profile" href="#menu3" title="Profile"
      class="bg-icon" style="background-image: url('<?= \helpers\minotar\MinotarHelper::url($user['playername'], 20) ?>');"
      >
        <?= $user['playername'] ?>
      </a>
    <ul id="menu3">
      <li><a href="#">opções</a></li>
      <li><a href="#"  data-widget-action="open" data-widget-name="profile">perfil</a></li>
      <li><a href="#">sair</a></li>
      </ul>
    </li>
</ul>











<? /*
<div>

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
*/?>
