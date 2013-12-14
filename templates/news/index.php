<!DOCTYPE html>
<html>
<head>
    <meta charset=utf-8 />
    <title>news</title>
    <link rel="stylesheet" type="text/css" media="screen" href="/styles/reset.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="/styles/sidebar.css" />
    <script type="text/javascript" src="/scripts/jquery.js"></script>
    <script type="text/javascript" src="/scripts/frames.js"></script>
    <script type="text/javascript" src="/scripts/sidebar.js"></script>
    <script type="text/javascript" src="/scripts/steve.js"></script>
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

    <div class="section">
      <? if ($numberOnlinePlayers > 0): ?>
      
      <div id="onlineplayers">
      <h2>Jogadores Online (<?= $numberOnlinePlayers ?>)</h2>
      <? foreach($onlinePlayers as $r): ?>
        <div class="stevegrid">
          <? $id = getUserIdByName($r['name'])['id'] ?>
          <a data-online="<?= in_array($r['name'], $flatOnlinePlayers) ? 'true' : 'false' ?>"
             class="<?= $id == null ? 'notregistered' : '' ?>" 
             title="<?= $r['name'] ?> <?= $id == null ? '(not registered)' : '' ?>" 
             href="<?= $id != null ? '/profile?id='.$id : '#' ?>">
            <? $head_url = "http://s3.amazonaws.com/MinecraftSkins/".$r['name'].".png"; ?>
            <span class="stevehead">
              <img class="pixels" src="/images/steve.png" data-src="<?= $head_url ?>" alt="Skin" />
            </span>
          </a>
        </div>
      <? endforeach; ?>
      </div>
      <? else: ?>
      <div style="text-align: center; margin-top: 10px;">
        <img src="/images/bed.png" alt="IT'S A BED" title="O servidor está vazio... :(">
      </div>
      <? endif; ?>
      <div style="clear: both;"></div>
    </div>

    <div class="section pushd">
      <div class="section-left extra-padding-left">
        <h2 title="Time Wasters ;)">Mais Activos</h2>
        <ul class="player-list">
        <? foreach(getTopPlayers() as $r): ?>
          <li class="link clear">
            <? $id = getUserIdByName($r['name'])['id'] ?>
            <a data-online="<?= in_array($r['name'], $flatOnlinePlayers) ? 'true' : 'false' ?>"
               href="<?= $id != null ? '/profile?id='.$id : '#' ?>"
               style="<?= $id == null ? 'text-decoration: line-through;' : '' ?>">
              <? $head_url = "http://s3.amazonaws.com/MinecraftSkins/".$r['name'].".png"; ?>
              <span class="stevehead">
                <img class="pixels" src="/images/steve.png" data-src="<?= $head_url ?>" alt="Skin" />
              </span>
              <span class="name-label pull-left"><?= $r["name"] ?></span>
              <span class="online pull-left" title="O jogador está online!"></span>
            </a>
          </li>
        <? endforeach; ?>
        </ul>
      </div>
      <div class="section-right extra-padding-left">
        <h2><?= m("L_NEWEST") ?></h2>
        <ul class="player-list">
        <? foreach(getNewest() as $r): ?>
          <li class="link clear">
            <a data-online="<?= in_array($r['playername'], $flatOnlinePlayers) ? 'true' : 'false' ?>"
               title="@ <?= $r["registerdate"] ?>"
               href="/profile?id=<?= $r['id'] ?>">
              <? $head_url = "http://s3.amazonaws.com/MinecraftSkins/".$r['playername'].".png"; ?>
              <span class="stevehead">
                <img class="pixels" src="/images/steve.png" data-src="<?= $head_url ?>" alt="Skin" />
              </span>
              <span class="name-label pull-left"><?= $r["playername"] ?></span>
              <span class="online pull-left" title="O jogador está online!"></span>
            </a>
          </li>
        <? endforeach; ?>
        </ul>
      </div>
      <div style="clear: both;"></div>
    </div>

    <? if ($cfg_wp_enabled): ?>
    <div id="news" class="section">
    <h2>Notícias</h2>
    <?
      $posts = get_posts('numberposts=10&order=desc&orderby=post_date');
      foreach ($posts as $post) : setup_postdata( $post );
    ?>
    <div class="section2 pushd2">
    <h3><a href="<?= get_permalink($post->ID) ?>" target="_blank"><?= get_the_time("F j, Y", $post->ID); ?>: <?= get_the_title($post->ID); ?></a></h3>
    <p><?= get_the_excerpt($post->ID); ?></p>
    </div>
    <?
      endforeach;
    ?>
    </div>
    <? endif; ?>
</body>
</html>
