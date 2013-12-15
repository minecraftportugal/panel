<!DOCTYPE html>
<html>
<head>
    <meta charset=utf-8 />
    <title>maps</title>
    
    <link rel="stylesheet" type="text/css" media="screen" href="/styles/reset.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="/styles/sidebar.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="/styles/dynmap.css" />

    <script type="text/javascript" src="/scripts/jquery.js"></script>
    <script type="text/javascript" src="/scripts/frames.js"></script>
    <script type="text/javascript" src="/scripts/autoreload.js"></script>
    <script type="text/javascript" src="/scripts/sidebar.js"></script>
    <script type="text/javascript" src="/scripts/dynmap.js"></script>
    <script type="text/javascript" src="/scripts/sop.js"></script>


    <!--[if IE]>
        <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

</head>
<body>
 <div id="conteudo">

  <? 
    if (isLoggedIn()) {
      require __DIR__.'/../partials/userbar.php';
    }
  ?>

  <? 
    $error = getFlash('error');
    if ($error != false):
  ?>
    <div class="section error"><?= $error ?></div>
  <? endif; ?>

  <? 
    $success = getFlash('success');
    if ($success != false):
  ?>
    <div class="section success"><?= $success ?></div>
  <? endif; ?>

  <div id="playerlist" class="collapsible section">
    <a href="#playerlist"><h1>Jogadores Online</h1></a>
    <div class="inside">
      <div data-dynmap-copy="playerlist" data-dynmap-fix-images="true" data-dynmap-set-anchor="#playerlist"></div>
    </div>
  </div>

  <div id="maplist" class="collapsible section default">
    <a href="#maplist"><h1>Mapas</h1></a>
    <div class="inside">
      <div data-dynmap-copy="worldlist" data-dynmap-set-anchor="#maplist"></div>
    </div>
  </div>

</div>



</div>
</body>
</html>
