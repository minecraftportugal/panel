<ul>
 <li>
   <i class="fa fa-trello"></i> Comunidade</li>
 <li>
   <ul>
    <li><a id="menu-item-launcher"
           href="/launcher"
           data-widget-action="open"
           data-widget-name="launcher"
           data-widget-title="<i class='fa fa-money'></i> Launcher"
           data-widget-mode="iframe"
           data-widget-css='{"width" : "854px", "height" : "500px"}'><i class="fa fa-money"></i> Launcher</a></li>
    <li><a id="menu-item-webchat"
           href="/irc"
           data-widget-action="open"
           data-widget-name="irc"
           data-widget-title="<i class='fa fa-keyboard-o'></i> IRC Chat"
           data-widget-mode="iframe"><i class="fa fa-keyboard-o"></i> IRC Chat</a></li>
    <li><a id="menu-item-forum"
             href="//forum.minecraft.pt/"
             data-widget-action="open"
             data-widget-name="forum"
             data-widget-title="<i class='fa fa-institution'></i> Fórum"
             data-widget-mode="iframe"><i class="fa fa-institution"></i> Fórum</a></li>
  </ul>
  </li>
</ul>

<ul>
  <li><i class="fa fa-globe"></i> Servidor</li>
  <li>
  <ul>
    <li><a id="menu-item-news"
           href="/news"
           data-widget-action="open"
           data-widget-name="widget-news"
           data-widget-classes="widget-scrollable-y"
           data-widget-css='{"min-width" : "422px", "max-width" : "422px", "min-height" : "500px"}'
           data-widget-title="<i class='fa fa-newspaper-o'></i> Servidor"><i class="fa fa-newspaper-o"></i> Noticias</a></li>
    <li><a id="menu-item-news"
           href="/status"
           data-widget-action="open"
           data-widget-name="widget-status"
           data-widget-classes="widget-scrollable-y"
           data-widget-css='{"min-width" : "422px", "max-width" : "422px", "min-height" : "500px"}'
           data-widget-title="<i class='fa fa-columns'></i> Servidor"><i class="fa fa-columns"></i> Status</a></li>
    <li><a id="menu-item-dynmap"
           href="//dynmap.minecraft.pt"
           data-widget-action="open-always"
           data-widget-name="Dynmap"
           data-widget-title="<i class='fa fa-picture-o'></i> Dynmap"
           data-widget-mode="iframe"><i class='fa fa-picture-o'></i> Dynmap</a></li>
    <li><a id="menu-item-inquisitor"
           href="//inquisitor.minecraft.pt"
           data-widget-action="open"
           data-widget-mode="iframe"
           data-widget-name="launcher"
           data-widget-title="<i class='fa fa-money'></i> Launcher"
           data-widget-css='{"width" : "854px", "height" : "500px"}'><i class="fa fa-tachometer"></i> Inquisitor</a></li>
    <li><a id="menu-item-directory"
           href="/directory"
           data-widget-action="open"
           data-widget-name="widget-directory"
           data-widget-maximized="true"
           data-widget-title="<i class='fa fa-users'></i> Jogadores"
           data-widget-title="Jogadores"><i class="fa fa-users"></i> Jogadores</a></li>
    <li><a id="menu-item-factions"
           href="/factions"
           data-widget-action="open"
           data-widget-name="widget-factions"
           data-widget-maximized="false"
           data-widget-title="<i class='fa fa-users'></i> Facções"
           data-widget-title="Facções"><i class="fa fa-users"></i> Facções</a></li>

  </ul>
  </li>
</ul>

<? if ($user['admin'] == 1): ?>
<ul>
  <li><i class="fa fa-gears"></i> Admin</li>
  <li>
    <ul>
      <li><a id="menu-item-admin-accounts"
           href="/admin/accounts"
           data-widget-action="open"
           data-widget-title="<i class='fa fa-users'></i> Contas"
           data-widget-name="admin-accounts"><i class="fa fa-users"></i> Contas</a></li>
      <li><a id="menu-item-admin-sessions"
           href="/admin/sessions"
           data-widget-action="open"
           data-widget-title="<i class='fa fa-group'></i> Sessões"
           data-widget-name="admin-sessions"><i class="fa fa-group"></i> Sessões</a></li>
      <li><a id="menu-item-admin-drops"
           href="/admin/drops"
           data-widget-action="open"
           data-widget-title="<i class='fa fa-th-list'></i> Drops"
           data-widget-name="admin-drops"><i class="fa fa-th-list"></i> Drops</a></li>
      <li><a id="menu-item-admin-fails"
           href="/admin/fails"
           data-widget-action="open"
           data-widget-title="<i class='fa fa-warning'></i> Logs"
           data-widget-name="admin-log"><i class="fa fa-warning"></i> Log</a></li>

    </ul>
  </li>
</ul>
<? endif; ?>

<ul>
  <li><i class="fa fa-question-circle"></i> Ajuda</li>
  <li>
    <ul>
      <li><a href="#"><i class="fa fa-help"></i> Iniciantes</a></li>
      <li><a href="#"><i class="fa fa-help"></i> FAQ</a></li>
      <li><a id="menu-item-wiki"
           href="http://minecraft.gamepedia.com/Minecraft_Wiki"
           data-widget-action="open"
           data-widget-name="launcher"
           data-widget-title="<i class='fa fa-money'></i> Minecraft Wiki"
           data-widget-mode="iframe"
           data-widget-css='{"width" : "854px", "height" : "500px"}'><i class="fa fa-money"></i> Wiki</a></li>
    </ul>
  </li>
</ul>

<ul class="pull-right">
  <li>
    <i class="bg-icon" style=" background-image: url('<?= \helpers\minotar\MinotarHelper::url($user['playername'], 16) ?>');"></i>
    <?= $user['playername'] ?>
  </li>
  <li>
    <ul>
      <li><a href="/profile/?id=<?= $user['id'] ?>"
           data-widget-action="open"
           data-widget-title="<i class='fa fa-gear'></i> Opções"
           data-widget-name="options"><i class="fa fa-gear"></i> Opções</a></li>
      <li><a href="/profile/?id=<?= $user['id'] ?>"
           data-widget-action="open"
           data-widget-title="<i class='fa fa-user'e></i> Perfil"
           data-widget-name="profile"><i class="fa fa-user"></i> Perfil</a></li>
      <li class="separator"><a href="#"
           onclick="javascript:top.logout();"><i class="fa fa-sign-out"></i> Sair</a></li>
    </ul>
  </li>
</ul>
