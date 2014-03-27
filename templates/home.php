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
  <link rel="stylesheet" href="/styles/scrollbar.css" media="screen" type="text/css">
  <link rel="stylesheet" href="/styles/font-awesome.min.css" media="screen" type="text/css">
  <link rel="stylesheet" href="/styles/page-presentation.css" media="screen" type="text/css">
  <link rel="stylesheet" href="/styles/page-presentation-forms.css" media="screen" type="text/css">
  
  <link href='http://fonts.googleapis.com/css?family=Overlock:400,700,900' rel='stylesheet' type='text/css'>
  
  <link rel="shortcut icon" href="favicon.ico" >

  <script type="text/javascript" src="/scripts/jquery.js"></script>
  <script type="text/javascript" src="/scripts/jqueryui.js"></script>
  <script type="text/javascript" src="/scripts/ajax.js"></script>
  <script type="text/javascript" src="/scripts/widget.js"></script>
  <script type="text/javascript" src="/scripts/desktop.js"></script>
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

  <div id="widget-container"><div></div></div>
  
  <div id="widget-button-container">
    <div id="widget-button-container-context">
      <div class="widget-context-button" onclick="javascript: Widget.tile();" title="Janelas Maximizadas"><i class="fa fa-th-large"></i></div>
    </div>
    <div id="widget-button-container-context">
      <div class="widget-context-button" onclick="javascript: Widget.cascade();" title="Janelas em Cascata"><i class="fa fa-align-justify"></i></div>
    </div>
    <div id="widget-button-container-context">
      <div class="widget-context-button" onclick="javascript: Widget.embiggen();" title="Janelas Alinhadas"><i class="fa fa-list-alt  "></i></div>
    </div>
  </div>

  <!-- <iframe id="map" name="mapa" src="<?= $dynmap_url ?>" frameborder="0" marginheight="0" marginwidth="0" width="100%" height="100%" scrolling="auto"></iframe> -->

  <? /* /!\ move html templates somewher else ? */ ?>
  <div id="html-templates" style="display: none;">
    <div id="widget-template">
      <div class="widget">
        <div class="widget-titlebar">
          <div class="widget-refresh widget-ui" title="refresh"><i class="fa fa-refresh"></i></div>
          <div class="widget-title widget-drag widget-ui" title="arrastar para mover"><div></div></div>
          <div class="widget-minimize widget-ui" title="minimizar"><i class="fa fa-minus"></i></div>
          <div class="widget-maximize widget-ui" title="maximizar"><i class="fa fa-plus"></i></div>
          <div class="widget-close widget-ui" title="fechar"><i class="fa fa-times"></i></div>
        </div>
        <div class="widget-body">
        </div>
        <div class="ui-resizable-handle ui-resizable-se widget-resize" title="drag to resize"></div>
      </div>
    </div>

    <div id="widget-button-template">
      <div class="widget-button"></div>
    </div>
  </div>

</body>
</html>
