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

    <?= $background_css  ?>

</head> 
<body>

    <div id="widget-container">
        <div id="logo"></div>
    </div>
    
    <div id="widget-taskbar">
        <?= $taskbar ?>
    </div>

    <div class="widget-menu" id="widget-homemenu">
        <?= $menu_home ?>
    </div>

    <div class="widget-menu" id="widget-usermenu">
        <?= $menu_user ?>
    </div>
    
    <div class="widget-menu" id="widget-desktopmenu">
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