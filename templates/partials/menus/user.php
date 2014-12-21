<ul>

  <li>
    <i class="bg-icon" style=" background-image: url('<?= $head_url ?>');"></i> <?= $user['playername'] ?>
  </li>

  <li>

    <ul>

      <li>
          <a href="#" data-widget-open="user-options"><i class="fa fa-gear"></i> Opções</a>
      </li>

      <li>
          <a href="/profile/?id=<?= $user['id'] ?>"
             data-widget-action="open"
             data-widget-classes="widget-scrollable-y"
             data-widget-title="<i class='fa fa-user'e></i> <?= $user['playername'] ?>"
             data-widget-name="profile-<?= $user['playername'] ?>"><i class="fa fa-user"></i> Perfil</a>
      </li>

      <li class="separator">
        <a id="menu-logout" href="#">
          <i class="fa fa-sign-out"></i> Sair
        </a>
      </li>

    </ul>

  </li>

</ul>