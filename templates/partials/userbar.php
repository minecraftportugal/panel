
      


<ul class="pull-left">
  <li><a href="#"><i class="fa fa-question-circle"></i> ajuda</a>
    <ul>
      <li><a href="#">como jogar</a></li>
      <li><a href="#">it's a trap</a></li>
    </ul>
  </li>
</ul>

<ul class="pull-left">
  <li><a href="#"><i class="fa fa-trello"></i> apps/crap</a>
    <ul>
      <li><a href="//inquisitor.minecraft.pt" data-widget-action="open" data-widget-name="inquisitor" data-widget-mode="iframe">inquisitor</a></li>
      <li><a href="//dynmap.minecraft.pt" data-widget-action="open" data-widget-name="dynmap" data-widget-mode="iframe">dynmap</a></li>
      <li><a href="//minecraft.pt/webchat" data-widget-action="open" data-widget-name="irc" data-widget-mode="iframe">irc/chat</a></li>
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
      <li><a href="/profile/?id=<?= $user['id'] ?>" data-widget-action="open" data-widget-name="options">opções</a></li>
      <li><a href="/profile/?id=<?= $user['id'] ?>" data-widget-action="open" data-widget-name="profile">perfil</a></li>
      <li><a href="#">sair</a></li>
      </ul>
    </li>
</ul>


<ul class="pull-right">
    <li><a href="#"><i class="fa fa-gears"></i> área de admin</a>
      <ul id="menu1">
        <li><a href="/admin/accounts" data-widget-action="open" data-widget-name="admin-accounts"><i class="fa fa-users"></i> contas</a></li>
        <li><a href="/admin/sessions" data-widget-action="open" data-widget-name="admin-sessions"><i class="fa fa-group"></i> sessões</a></li>
        <li><a href="/admin/drops" data-widget-action="open" data-widget-name="admin-drops"><i class="fa fa-th-list"></i> item drops</a></li>
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
