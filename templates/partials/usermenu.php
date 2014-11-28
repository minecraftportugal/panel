<ul>
  <li>
    <i class="bg-icon" style=" background-image: url('<?= \helpers\minotar\MinotarHelper::url($user['playername'], 16) ?>');"></i>
    <?= $user['playername'] ?>
  </li>
  <li>
    <ul>
      <li>
          <a href="/options"
             data-widget-action="open"
             data-widget-title="<i class='fa fa-gear'></i> Opções"
             data-widget-name="options"><i class="fa fa-gear"></i> Opções</a>
      </li>
      <li>
          <a href="/profile/?id=<?= $user['id'] ?>"
             data-widget-action="open"
             data-widget-classes="widget-scrollable-y"
             data-widget-title="<i class='fa fa-user'e></i> <?= $user['playername'] ?>"
             data-widget-name="profile-<?= $user['playername'] ?>"><i class="fa fa-user"></i> Perfil</a>
      </li>
      <li class="separator">
          <a href="#" onclick="javascript:Widget.clearState();"><i class="fa fa-sign-out"></i> Reset Widgets</a>
      </li>
      <li class="separator">
          <a href="#"
            onclick="javascript:top.logout();"><i class="fa fa-sign-out"></i> Sair</a>
      </li>
    </ul>
  </li>
</ul>