<!DOCTYPE html> 
<html>
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" >
    <meta name="xsrf_token" content="<?= $xsrf_token ?>" >
    <meta name="username" content="<?= $user["playername"] ?>" >

    <title>minecraft.pt | MinePanel 3.0</title>

    <link rel="shortcut icon" href="favicon.ico" >

<? foreach ($styles as $style): ?>
    <link rel="stylesheet" href="/css/<?= $style ?>.css" media="screen" type="text/css">
<? endforeach; ?>


<? foreach ($scripts as $script): ?>
    <script type="text/javascript" src="js/<?= $script ?>.js"></script>
<? endforeach; ?>

    <?= /* $background_css */ false ?>

</head> 
<body>

    <div id="widget-container">
        <?= $desktop_logo ?>
    </div>
    
    <div id="widget-taskbar">
        <?= $taskbar ?>
    </div>

    <div class="widget-menu" id="widget-home-menu">
        <?= $menu_home ?>
    </div>

    <? if ($admin): ?>
        <div class="widget-menu" id="widget-admin-menu">
            <?= $menu_admin ?>
        </div>
    <? endif; ?>


    <div class="widget-menu" id="widget-user-menu">
        <?= $menu_user ?>
    </div>
    
    <div class="widget-menu" id="widget-desktop-menu">
        <?= $menu_desktop ?>
    </div>
    
    <? /* /!\ move html templates somewher else ? */ ?>
    <div id="html-templates">
        <?= $html_templates ?>
    </div>

    <div id="modal-blocker">

    </div>

    <div id="loading-blocker">
        <i class="fa fa-spinner fa-spin fa-5x"></i>
    </div>

</body>
</html>
