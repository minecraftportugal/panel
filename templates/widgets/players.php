<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf8" />
  <meta name="language" content="en" />
  <meta name="author" content="Comunidade Minecraft Portugal" />
  <script type="text/javascript" src="/scripts/jquery.js"></script>
  <script type="text/javascript" src="/scripts/widget_players.js"></script>
  <link href='//fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" type="text/css" media="screen" href="/styles/reset.css" />
  <link rel="stylesheet" type="text/css" media="screen" href="/styles/widget_players.css" />
</head>

<body>

<? if ($total_online_players > 0): ?>

<div id="onlineplayers">
  <h1><?= $total_online_players ?> jogadores online!</h1>

  <ul>

  <? foreach((array)$online_players as $r): ?>
    <li>
  	<span class="stevehead">
      <?= \helpers\minotar\MinotarHelper::head($r['playername'], 32) ?>
  	</span>
    <span class="name">
      <?= $r['playername'] ?>
    </span>
    </li>
  <? endforeach; ?>

  </ul>
</div>

<? endif;?>
<p>Servidor da Comunidade Minecraft Portugal</p>
<p>IP: minecraft.pt</p>
<p><a href="//www.minecraft.pt" target="_blank">Regista-te já!</a></p>

</body>
</html>
