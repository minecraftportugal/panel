<ul>

  <li class="header">
    <i class="bg-icon" style=" background-image: url('<?= $head_url ?>');"></i> <?= $user['playername'] ?>
  </li>

  <li>
     <a id="menu-options" href="#" data-widget-open="user-options" role="toaster-launcher">
         <i class="fa fa-gear"></i> Opções
     </a>
     <span rel="menu-options" role="toaster-content">
         Configuração das opções deste utilizador
     </span>
  </li>

  <li>
      <a id="menu-profile" href="/profile/?id=<?= $user['id'] ?>"
         data-widget-action="open"
         data-widget-classes="widget-scrollable-y"
         data-widget-title="<i class='fa fa-user'e></i> <?= $user['playername'] ?>"
         data-widget-name="profile-<?= $user['playername'] ?>"
         role="toaster-launcher">
          <i class="fa fa-user"></i> Perfil
      </a>
     <span rel="menu-profile" role="toaster-content">
         Ver o Perfil deste utilizador
     </span>
  </li>


  <li>
      <a id="menu-tickets" href="/tickets"
         data-widget-action="open"
         data-widget-classes="widget-scrollable-y"
         data-widget-title="<i class='fa fa-ticket'></i> User Tickets"
         data-widget-name="user-tickets"
         role="toaster-launcher">
          <i class="fa fa-ticket"></i> User Tickets
      </a>
   <span rel="menu-tickets" role="toaster-content">
       Ver os Tickets deste utilizador
   </span>
  </li>

  <li class="separator">
    <a id="menu-logout" href="#" role="toaster-launcher">
      <i class="fa fa-sign-out"></i> Sair
    </a>
     <span rel="menu-logout" role="toaster-content">
         Terminar a sessão no MinePanel 3.0
     </span>
  </li>

</ul>