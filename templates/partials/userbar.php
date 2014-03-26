<ul class="pull-left">
  <li><a href="#"><i class="fa fa-trello"></i> apps/crap</a>
    <ul>
      <li><a id="menu-item-launcher"
             href="/launcher"
             data-widget-action="open"
             data-widget-name="launcher"
             data-widget-title="Minecraft Launcher"
             data-widget-mode="iframe"
             data-widget-css='{"width" : "854px", "height" : "500px"}'><i class="fa fa-money"></i> launcher</a></li>
      <li><a id="menu-item-inquisitor"
             href="//inquisitor.minecraft.pt"
             data-widget-action="open"
             data-widget-name="inquisitor"
             data-widget-mode="iframe"
             data-widget-css='{"width" : "854px", "height" : "500px"}'><i class="fa fa-tachometer"></i> inquisitor</a></li>
      <li><a id="menu-item-dynmap"
             href="//dynmap.minecraft.pt"
             data-widget-action="open-always"
             data-widget-name="dynmap"
             data-widget-mode="iframe"><i class="fa fa-picture-o"></i> dynmap</a></li>
      <li><a id="menu-item-webchat"
             href="//minecraft.pt/webchat"
             data-widget-action="open"
             data-widget-name="irc"
             data-widget-mode="iframe"><i class="fa fa-keyboard-o"></i> irc/chat</a></li>
    </ul>
  </li>
</ul>

<ul class="pull-left">
  <li><a href="#"><i class="fa fa-globe"></i> servidor</a>
    <ul>
      <li><a id="menu-item-news"
             href="/news" 
             data-widget-action="open"
             data-widget-name="widget-news"
             data-widget-title="Notícias"><i class="fa fa-columns"></i> notícias</a></li>
      <li><a id="menu-item-directory"
             href="/directory"
             data-widget-action="open"
             data-widget-name="widget-directory"
             data-widget-maximized="true"
             data-widget-title="Jogadores"><i class="fa fa-users"></i> jogadores</a></li>
    </ul>
  </li>
</ul>

<? if ($user['admin'] == 1): ?>
<ul class="pull-left">
    <li><a href="#"><i class="fa fa-gears"></i> admin</a>
      <ul>
        <li><a id="menu-item-admin-accounts"
               href="/admin/accounts" 
               data-widget-action="open"
               data-widget-name="admin-accounts"><i class="fa fa-users"></i> contas</a></li>
        <li><a id="menu-item-admin-sessions"
               href="/admin/sessions"
               data-widget-action="open"
               data-widget-name="admin-sessions"><i class="fa fa-group"></i> sessões</a></li>
        <li><a id="menu-item-admin-drops"
               href="/admin/drops"
               data-widget-action="open"
               data-widget-name="admin-drops"><i class="fa fa-th-list"></i> item drops</a></li>
      </ul>
    </li>
</ul>
<? endif; ?>

<ul class="pull-left">
  <li><a href="#"><i class="fa fa-question-circle"></i> ajuda</a>
    <ul>
      <li><a href="#">como jogar</a></li>
      <li><a href="#">it's a trap</a></li>
      <li><a id="menu-item-wiki"
             href="http://minecraft.gamepedia.com/Minecraft_Wiki"
             data-widget-action="open"
             data-widget-name="launcher"
             data-widget-title="Minecraft Wiki"
             data-widget-mode="iframe"
             data-widget-css='{"width" : "854px", "height" : "500px"}'><i class="fa fa-money"></i> minecraft wiki</a></li>
    </ul>
  </li>
</ul>

<ul class="pull-right">
    <li>
      <a id="profile" href="#" title="Profile"
      class="bg-icon" style="background-image: url('<?= \helpers\minotar\MinotarHelper::url($user['playername'], 20) ?>');"
      >
        <?= $user['playername'] ?>
      </a>
    <ul id="menu3">
      <li><a href="/profile/?id=<?= $user['id'] ?>"
             data-widget-action="open"
             data-widget-name="options"><i class="fa fa-gear"></i> opções</a></li>
      <li><a href="/profile/?id=<?= $user['id'] ?>"
             data-widget-action="open" data-widget-name="profile"><i class="fa fa-user"></i> perfil</a></li>
      <li class="separator"></li>
      <li><a href="#"
             onclick="javascript:top.logout();"><i class="fa fa-sign-out"></i> sair</a></li>
      </ul>
    </li>
</ul>



<div class="pull-right" id="ajax-indicator"></div>








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
