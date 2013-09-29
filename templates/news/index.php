<!DOCTYPE html>
<html>
<head>
    <meta charset=utf-8 />
    <title>news</title>
    <link rel="stylesheet" type="text/css" media="screen" href="/styles/reset.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="/styles/sidebar.css" />
    <script type="text/javascript" src="/scripts/jquery.js"></script>
    <script type="text/javascript" src="/scripts/frames.js"></script>
    <script type="text/javascript" src="/scripts/news.js"></script>
    <!--[if IE]>
        <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

</head>
<body>
    <div id="conteudo">

    <? if (isLoggedIn()): ?>
    <div class="section status userbar">
    <div class="section-left">
      <a class="button" id="profile" href="/profile" title="Profile">
        <? $head_url = "http://s3.amazonaws.com/MinecraftSkins/".$_SESSION['username'].".png"; ?>
        <span class="stevehead">
          <img class="pixels" src="/images/steve.png" data-src="<?= $head_url ?>" alt="Skin" />
        </span><?= $_SESSION['username'] ?></a>
    </div>
    <div class="section-right aright">
      <? if ($_SESSION['admin'] == 1): ?>
        <a class="button" id="admin" href="/admin" title="Admin"></a>
      <? endif; ?>
      <a class="button" id="news" href="/news" title="News"></a>
      <a class="button" id="logout" href="#" title="Logout"></a>
      <a class="button" id="close" href="#" onclick="javascript:parent.toggleNews();" title="Hide Sidebar"></a>
    </div>
    </div>
    <? endif; ?>

    <div class="section">
    <div class="section-left">
      <h2 title="Time Wasters ;)">Top Jogadores</h2>
      <ul class="player-list">
      <? foreach(getTopPlayers() as $r): ?>
        <li class="link">
          <? $id = getUserIdByName($r['name'])['id'] ?>
          <a href="<?= $id != null ? '/profile?id='.$id : '#' ?>" style="<?= $id == null ? 'text-decoration: line-through;' : '' ?>">
            <? $head_url = "http://s3.amazonaws.com/MinecraftSkins/".$r['name'].".png"; ?>
            <span class="stevehead">
              <img class="pixels" src="/images/steve.png" data-src="<?= $head_url ?>" alt="Skin" />
            </span>
            <?= $r["name"] ?>
          </a>
        </li>
      <? endforeach; ?>
      </ul>
    </div>
    <? 
      $o = getOnlinePlayers();
      $len = $o == null ? 0 : count($o);
    ?>
    <div class="section-right">
      <h2>Jogadores Online (<?= $len ?>)</h2>
      <ul class="player-list">
      <? foreach($o as $r): ?>
        <li class="link">
          <? $id = getUserIdByName($r['name'])['id'] ?>
          <a href="<?= $id != null ? '/profile?id='.$id : '#' ?>" style="<?= $id == null ? 'text-decoration: line-through;' : '' ?>">
            <? $head_url = "http://s3.amazonaws.com/MinecraftSkins/".$r['name'].".png"; ?>
            <span class="stevehead">
              <img class="pixels" src="/images/steve.png" data-src="<?= $head_url ?>" alt="Skin" />
            </span>
            <?= $r["name"] ?>
          </a>
        </li>
      <? endforeach; ?>
      </ul>
    </div>
    <div style="clear: both;"></div>
    </div>
    

    <div class="section pushd">
    <div class="section-left">
      <h2><?= m("L_LASTACTIVE") ?></h2>
      <ul class="player-list">
      <? foreach(getRecent($_SESSION['id']) as $r): ?>
        <li class="link">
          <a title="@ <?= $r["sessiondate"] ?>" href="/profile?id=<?= $r['id'] ?>">
            <? $head_url = "http://s3.amazonaws.com/MinecraftSkins/".$r['playername'].".png"; ?>
            <span class="stevehead">
              <img class="pixels" src="/images/steve.png" data-src="<?= $head_url ?>" alt="Skin" />
            </span>
            <?= $r["playername"] ?>
          </a>
        </li>
      <? endforeach; ?>
      </ul>
    </div>
    <div class="section-right">
      <h2><?= m("L_NEWEST") ?></h2>
      <ul class="player-list">
      <? foreach(getNewest() as $r): ?>
        <li class="link">
          <a title="@ <?= $r["registerdate"] ?>" href="/profile?id=<?= $r['id'] ?>">
            <? $head_url = "http://s3.amazonaws.com/MinecraftSkins/".$r['playername'].".png"; ?>
            <span class="stevehead">
              <img class="pixels" src="/images/steve.png" data-src="<?= $head_url ?>" alt="Skin" />
            </span>
           <?= $r["playername"] ?>
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
