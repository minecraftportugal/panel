<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf8" />
  <meta name="language" content="en" />
  <meta name="author" content="Comunidade Minecraft Portugal" />
  <title></title>
  <script type="text/javascript" src="/scripts/jquery.js"></script>
  <script type="text/javascript" src="/scripts/steve.js"></script>
  <link href='http://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" type="text/css" media="screen" href="/styles/reset.css" />
  <link rel="stylesheet" type="text/css" media="screen" href="/styles/widget_players.css" />
</head>

<body>
<? if ($n > 0): ?>
<div id="onlineplayers">
<h1><?= $n ?> jogadores online!</h1>
<ul>
<? foreach((array)$onlinePlayers as $p): ?>
  <li>
	<? $head_url = "http://s3.amazonaws.com/MinecraftSkins/".$p['name'].".png"; ?>
	<span class="stevehead">
	  <img class="pixels" src="/images/steve.png" data-src="<?= $head_url ?>" alt="Skin" />
	</span>
    <span class="name"><?= $p['name'] ?></span>
  </li>
<? endforeach; ?>
</ul>
</div>
<? endif;?>
<p>Servidor da Comunidade Minecraft Portugal</p>
<p>IP: minecraft.pt</p>
<p><a href="http://www.minecraft.pt" target="_target">Regista-te já!</a></p>
</body>
</html>
