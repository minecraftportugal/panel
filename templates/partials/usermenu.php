<li>
    <a id="profile" href="#" title="Profile"
       class="bg-icon" style="background-image: url('<?= \helpers\minotar\MinotarHelper::url($user['playername'], 20) ?>');">
        <?= $user['playername'] ?>
    </a>
    <ul id="menu3">
        <li><a href="/profile/?id=<?= $user['id'] ?>"
               data-widget-action="open"
               data-widget-title="<i class='fa fa-gear'></i> Opções"
               data-widget-name="options"><i class="fa fa-gear"></i> Opções</a></li>
        <li><a href="/profile/?id=<?= $user['id'] ?>"
               data-widget-action="open"
               data-widget-title="<i class='fa fa-user'e></i> Perfil"
               data-widget-name="profile"><i class="fa fa-user"></i> Perfil</a></li>
        <li class="separator"></li>
        <li><a href="#"
               onclick="javascript:top.logout();"><i class="fa fa-sign-out"></i> Sair</a></li>
    </ul>
</li>