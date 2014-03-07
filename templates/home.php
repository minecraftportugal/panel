<!DOCTYPE html> 
<html>
<head>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" >
  <meta name="xsrf_token" content="<?= getXSRFToken() ?>" >

  <title>Comunidade Minecraft Portugal: Servidor Oficial</title>

  <link rel="stylesheet" href="/styles/reset.css" media="screen" type="text/css">
  <link rel="stylesheet" href="/styles/fonts.css" media="screen" type="text/css">
  <link rel="stylesheet" href="/styles/style.css" media="screen" type="text/css">
  <link rel="stylesheet" href="/styles/desktop.css" media="screen" type="text/css">
  <link rel="stylesheet" href="/styles/widget.css" media="screen" type="text/css">
  <link rel="alternate" href="<?= $cfg_wp_url ?>?feed=rss2" title="Minecraftia! RSS feed" type="applications/rss+xml" >
  <link rel="shortcut icon" href="favicon.ico" >

  <script type="text/javascript" src="/scripts/jquery.js"></script>
  <script type="text/javascript" src="/scripts/jqueryui.js"></script>
  <script type="text/javascript" src="/scripts/ajax.js"></script>
  <script type="text/javascript" src="/scripts/lib/widget.js"></script>
  <script type="text/javascript" src="/scripts/widgets-definition.js"></script>
  <script type="text/javascript" src="/scripts/cookies.js"></script>
  <script type="text/javascript" src="/scripts/sop.js"></script>
  <script type="text/javascript" src="/scripts/top.js"></script>
  <script type="text/javascript" src="/scripts/sidebar.js"></script>
  <script type="text/javascript" src="/scripts/profile.js"></script>
  <script type="text/javascript" src="/scripts/items.js"></script>

</head> 
<body>

  <div id="top-bar">
    <? require("partials/userbar.php"); ?>
  </div>


  <div id="widget-container"></div>
  <div id="widget-button-container"></div>

  <!-- <iframe id="map" name="mapa" src="<?= $dynmap_url ?>" frameborder="0" marginheight="0" marginwidth="0" width="100%" height="100%" scrolling="auto"></iframe> -->

  <? /* /!\ move html templates somewher else ? */ ?>
  <div id="html-templates" style="display: none;">
    <div id="widget-template">
      <div class="widget">
        <div class="widget-titlebar">
          <div class="widget-title widget-drag widget-ui" title="drag to move"><div></div></div>
          <div class="widget-dock widget-ui" title="click to dock"><div></div></div>
          <div class="widget-minimize widget-ui" title="click to minimize"><div></div></div>
        </div>
        <div class="widget-body">
        </div>
        <div class="ui-resizable-handle ui-resizable-se widget-resize widget-interact widget-resize" title="drag to resize"></div>
      </div>
    </div>

    <div id="widget-button-template">
      <div class="widget-button"></div>
    </div>
  </div>

</body>
</html>