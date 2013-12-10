<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" lang="EN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="xsrf_token" content="<?= getXSRFToken() ?>" />
<title>Comunidade Minecraft Portugal: Servidor Oficial</title>
<link rel="stylesheet" href="/styles/top.css" type="text/css" />
<link rel="alternate" href="<?= $cfg_wp_url ?>?feed=rss2" title="Minecraftia! RSS feed" type="applications/rss+xml" />
<link rel="shortcut icon" href="favicon.ico" />
<script type="text/javascript" src="/scripts/jquery.js"></script>
<script type="text/javascript" src="/scripts/jqueryui.js"></script>
<script type="text/javascript" src="/scripts/cookies.js"></script>
<script type="text/javascript" src="/scripts/top.js"></script>
<script type="text/javascript" src="/scripts/sop.js"></script>
</head> 
<body>

	<div id="sidebar">
	  <iframe id="news" src="/news"></iframe>
	</div>

	<div id="window">
	  <div class="window-drag window-interact" title="drag to move"></div>
	  <iframe id="chat" src="/irc"></iframe>
	  <div class="window-dock window-interact" title="click to dock"></div>
	  <div class="window-minimize window-interact" title="click to minimize"></div>
	  <div class="ui-resizable-handle ui-resizable-se window-resize window-interact" title="drag to resize"></div>
	</div>

	<div id="button-chat" class="button">Chat</div>
	<div id="button-news" class="button">Panel</div>

	<iframe id="map" name="mapa" src="<?= $cfg_dynmap_url ?>" frameborder="0" marginheight="0" marginwidth="0" width="100%" height="100%" scrolling="auto"></iframe> 

</body>
</html>
