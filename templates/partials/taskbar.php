<div id="widget-button-home-menu" class="widget-context-button widget-home-button" title="Click me!" data-open-menu="div#widget-homemenu" role="toaster-launcher">
    <i class="fa fa-home"></i>
</div>

<span rel="widget-button-home-menu" role="toaster-content">
    Este é o menu Principal. Contém todas as aplicações deste painel.
</span>

<? if ($admin): ?>
    <div id="widget-button-admin-menu" class="widget-context-button widget-admin-button" title="Noo! Click me instead!" data-open-menu="div#widget-adminmenu" role="toaster-launcher">
        <i class="fa fa-gear"></i>
    </div>
<? endif; ?>

<span rel="widget-button-admin-menu" role="toaster-content">
    Este é o menu de administração ;-)
</span>

<div id="widget-button-container-scroll-left" class="widget-button-container-scroll">
</div>

<div id="widget-button-container">
</div>

<div id="widget-button-container-scroll-right" class="widget-button-container-scroll" >
</div>

<div id="widget-button-desktopmenu" class="widget-context-button" data-open-menu="div#widget-desktopmenu" role="toaster-launcher">
  <i class="fa fa-desktop"></i>
</div>

<span rel="widget-button-desktopmenu" role="toaster-content">
    Este menu contém operações sobre o Desktop
</span>

<div id="widget-button-usermenu" class="widget-context-button" data-open-menu="div#widget-usermenu" role="toaster-launcher">
    <a id="usermenu-small" href="#" title="Utilizador" class="bg-icon"
       style="background-image: url('<?= $head_url ?>');">
    </a>
</div>

<span rel="widget-button-usermenu" role="toaster-content">
    Este é o menu do utilizador. Contém cenas do user.
</span>