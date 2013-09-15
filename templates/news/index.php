<!DOCTYPE html>
<html>
<head>
    <meta charset=utf-8 />
    <title>news</title>
    <link rel="stylesheet" type="text/css" media="screen" href="/styles/reset.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="/styles/sidebar.css" />
    <script type="text/javascript" src="/scripts/jquery.js"></script>
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
      <? $head_url = "http://s3.amazonaws.com/MinecraftSkins/".$_SESSION['username'].".png"; ?>
      <a class="button" id="profile" href="/profile" title="Profile">
         <span class="stevehead pixels"></span>
         <span class="stevehead pixels" style="background-image: url('<?= $head_url ?>')"></span>
        <?= $_SESSION['username'] ?></a>
    </div>
    <div class="section-right aright">
      <? if ($_SESSION['admin'] == 1): ?>
        <a class="button" id="admin" href="/admin" title="Admin"></a>
      <? endif; ?>
      <a class="button" id="logout" href="#" title="Logout"></a>
      <a class="button" id="close" href="#" onclick="javascript:parent.toggleNews();" title="Hide Sidebar"></a>
    </div>
    </div>
    <? endif; ?>

    <div class="section">
    <div class="section-left">
      <h2><?= m("L_LASTACTIVE") ?></h2>
      <ul class="player-list">
      <? foreach(getRecent($_SESSION['id']) as $r): ?>
          <? $head_url = "http://s3.amazonaws.com/MinecraftSkins/".$r['playername'].".png"; ?>
        <li class="link">
          <a title="@ <?= $r["sessiondate"] ?>" href="/profile?id=<?= $r['id'] ?>">
           <span class="stevehead pixels"></span>
           <span class="stevehead pixels" style="background-image: url('<?= $head_url ?>')"></span>
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
        <? $head_url = "http://s3.amazonaws.com/MinecraftSkins/".$r['playername'].".png"; ?>
        <li class="link">
          <a title="@ <?= $r["registerdate"] ?>" href="/profile?id=<?= $r['id'] ?>">
           <span class="stevehead pixels"></span>
           <span class="stevehead pixels" style="background-image: url('<?= $head_url ?>')"></span>
           <?= $r["playername"] ?>
          </a>
        </li>
      <? endforeach; ?>
      </ul>
    </div>
    <div style="clear: both;"></div>
    </div>

    <? if ($cfg_wp_enabled): ?>
    <div id="news" class="section topbump">
    <h2><?= m("L_NEWS") ?></h2>
    <?
      require("$cfg_wp_location/wp-blog-header.php");
      $posts = get_posts('numberposts=10&order=desc&orderby=post_date');
    ?>
    <? foreach ($posts as $post) : start_wp(); ?>
    <div class="section2 pushd2">
    <h3><a href="<?= get_permalink() ?>" target="_blank"><?= the_time("F j, Y"); ?>: <?= the_title(); ?></a></h3>
    <p><?= the_excerpt(); ?></p>
    </div>
    <?
    endforeach;
    ?>
    </div>
    <? endif; ?>
</body>
</html>
