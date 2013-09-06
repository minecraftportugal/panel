<?
require('config.php');
require('lib.php');
session_start();
validateSession();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" lang="EN"> 
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="xsrf_token" content="<?= $_SESSION['xsrf_token'] ?>" />
<title>Minecraftia!</title>
<link rel="stylesheet" href="/styles/style.css" type="text/css" />
<link rel="stylesheet" href="/styles/jqueryui.css" type="text/css" />
<link rel="alternate" href="<?= $cfg_wp_url ?>?feed=rss2" title="Minecraftia! RSS feed" type="applications/rss+xml" />
<link rel="shortcut icon" href="favicon.ico" />
<script type="text/javascript" src="scripts/jquery.js"></script>
<script type="text/javascript" src="scripts/jqueryui.js"></script>
<script type="text/javascript" src="scripts/cookies.js"></script>
<script type="text/javascript" src="scripts/top.js"></script>
</head> 
<body>

<div id="sitenews">
  <iframe id="news" src="/news"></iframe>
</div>

<div id="sitechat">
<!--  <div id="close" class="nointeraction" onclick="javascript:toggleChat();"></div> -->
  <div id="drag" title="drag to move"></div>
  <iframe id="chat" src="/irc"></iframe>
  <div id="dock" title="click to dock"></div>
  <div id="minimize" title="click to minimize"></div>
  <div class="ui-resizable-handle ui-resizable-se" id="resize" title="drag to resize"></div>
</div>

<div id="button-chat" class="button">Chat</div>
<div id="button-news" class="button">News</div>

<iframe id="map" name="mapa" src="//dynmap.minecraft.pt/" frameborder="0" marginheight="0" marginwidth="0" width="100%" height="100%" scrolling="auto"></iframe> 

</body> 
</html>
