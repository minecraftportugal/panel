<!DOCTYPE html> 
<html>
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" >
<? if (isset($xsrf_token)): ?>
    <meta name="xsrf_token" content="<?= $xsrf_token ?>">
<? endif; ?>
<? if (isset($user)): ?>
    <meta name="username" content="<?= $user["playername"] ?>">
<? endif; ?>
<? if (isset($user["admin"])): ?>
    <meta name="admin" content="<?= $user["admin"] ?>">
<? endif; ?>
<? if (isset($user["donor"])): ?>
    <meta name="donor" content="<?= $user["donor"] ?>">
<? endif; ?>
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

    <div class="show-when-logged-in" id="widget-taskbar">
        <?= $taskbar ?>
    </div>

    <div class="widget-menu" id="widget-home-menu">
        <?= $menu_home ?>
    </div>

    <div class="widget-menu" id="widget-user-menu">
        <?= $menu_user ?>
    </div>
    
    <div class="widget-menu" id="widget-desktop-menu">
        <?= $menu_desktop ?>
    </div>

    <div class="widget-menu" id="widget-admin-menu">
        <?= $menu_admin ?>
    </div>

    <? /* /!\ move html templates somewher else ? */ ?>
    <div id="html-templates">
        <?= $html_templates ?>
    </div>

    <div id="modal-blocker">

    </div>

    <div id="loading-blocker" class="block-enabled">
        <i class="fa fa-spinner fa-spin fa-5x"></i>
    </div>

</body>
</html>
