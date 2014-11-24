<!DOCTYPE html> 
<html>
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" >
    <meta name="xsrf_token" content="<?= getXSRFToken() ?>" >

    <title>Comunidade Minecraft Portugal: Servidor Oficial</title>

    <link rel="stylesheet" href="/styles/reset.css" media="screen" type="text/css">
    <link rel="stylesheet" href="/styles/fonts.css" media="screen" type="text/css">
    <link rel="stylesheet" href="/styles/desktop.css" media="screen" type="text/css">
    <link rel="stylesheet" href="/styles/widget.css" media="screen" type="text/css">
    <link rel="stylesheet" href="/styles/scrollbar.css" media="screen" type="text/css">
    <link rel="stylesheet" href="/styles/items.css" media="screen" type="text/css">
    <link rel="stylesheet" href="/styles/font-awesome.min.css" media="screen" type="text/css">
    <link rel="stylesheet" href="/styles/page-presentation.css" media="screen" type="text/css">
    <link rel="stylesheet" href="/styles/page-presentation-forms.css" media="screen" type="text/css">
    <link rel="stylesheet" href="/styles/page-presentation-profile.css" media="screen" type="text/css">
    
    <link href='//fonts.googleapis.com/css?family=Overlock:400,700,900' rel='stylesheet' type='text/css'>
    
    <link rel="shortcut icon" href="favicon.ico" >

    <script type="text/javascript" src="/scripts/jquery.js"></script>
    <script type="text/javascript" src="/scripts/jquery.scrollto.js"></script>
    <script type="text/javascript" src="/scripts/jqueryui.js"></script>
    <script type="text/javascript" src="/scripts/Three.js"></script>
    <script type="text/javascript" src="/scripts/ajax.js"></script>
    <script type="text/javascript" src="/scripts/behaviour.js"></script>
    <script type="text/javascript" src="/scripts/widget.js"></script>
    <script type="text/javascript" src="/scripts/desktop.js"></script>
    <script type="text/javascript" src="/scripts/widgets-definition.js"></script>
    <script type="text/javascript" src="/scripts/cookies.js"></script>
    <script type="text/javascript" src="/scripts/sop.js"></script>
    <script type="text/javascript" src="/scripts/top.js"></script>
    <script type="text/javascript" src="/scripts/dynmap.js"></script>

    <style>
        body {
            background: url(<?= $background_image ?>);
            background-size: 100% auto;
        }

    </style>

</head> 
<body>


    <div id="widget-container">
        <div></div>
    </div>
    
    <div id="widget-taskbar">
        <? require("partials/taskbar.php"); ?>
    </div>

    <div class="widget-menu" id="widget-homemenu">
        <? require("partials/homemenu.php") ?>
    </div>

    <div class="widget-menu" id="widget-usermenu">
        <? require("partials/usermenu.php") ?>
    </div>

    <!-- <iframe id="map" name="mapa" src="<?= $dynmap_url ?>" frameborder="0" marginheight="0" marginwidth="0" width="100%" height="100%" scrolling="auto"></iframe> -->

    <? /* /!\ move html templates somewher else ? */ ?>
    <div id="html-templates">
    <? require("partials/htmltemplates.php") ?>
    </div>

</body>
</html>