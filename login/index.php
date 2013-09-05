<?php
require('../config.php');
require('../lib.php');
require('../i18n.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['logout']) && $_POST['logout'] == 1) {
    if (isset($_SESSION['id'])) {
      terminatexAuthSession($_SESSION['id']);
    }
    session_destroy();
    header('Location: /login?f=2');
  } else {

      $username = s($_POST['username']);
      $password = s($_POST['password']);

      $session = validateLogin($username, $password);
      if ($session == NULL) {
        header('Location: /login?f=1');
      } else {
        header('Location: /');
      }
  }
  return;
} else {
  if (isLoggedIn()) {
    header('Location: /');
    exit();
  }
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset=utf-8 />
    <title><?= m("L_TITLE") ?></title>
    <link rel="stylesheet" type="text/css" media="screen" href="/styles/reset.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="style.css" />
    <link rel="alternate" href="/blog/?feed=rss2" title="Minecraftia! RSS feed" type="applications/rss+xml" />
    <link rel="shortcut icon" href="../favicon.ico" />
    <script type="text/javascript" src="/scripts/jquery.js"></script>
    <script type="text/javascript" src="/scripts/cookies.js"></script>
    <script type="text/javascript" src="/scripts/i18n.js"></script>
    <script type="text/javascript" Src="/scripts/login.js"></script>
    <!--[if IE]>
        <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>
<body>
  <div id="content">
    <div id="motd">
      <h1><?= m("L_WELCOME") ?></h1>
      <p><?= m("L_WELCOME1") ?></p>
      <p><?= m("L_WELCOME2") ?> </p>
      <p><?= m("L_WELCOME3"); ?> </p>
    </div>
    <div id="actions">
      <form name="login" method="post" action="index.php">
        <span class="center"><input type="text" name="username" autofocus="true" placeholder="username" /></span>
        <span class="center"><input type="password" name="password" placeholder="password" /></span>
        <span class="center"><input type="submit" value="Login!"/></span>
        <?php if (isset($_GET['f']) && $_GET['f'] == 1): ?>
          <label class="error"><?= m("L_INVALID") ?></label>
        <?php elseif (isset($_GET['f']) && $_GET['f'] == 2): ?>
          <label class="ok"><?= m("L_GOODBYE") ?></label>
        <?php elseif (isset($_GET['f']) && $_GET['f'] == 3): ?>
          <label class="ok"><?= m("L_PLEASELOGIN") ?></label>
        <?php else: ?>
          <label></label>
        <?php endif; ?>
      </form>
    </div>
    <div id="social">
      <ul>
        <? $icon_path = "/images/icons"; ?>
        <li><a title="Webchat" href="//blog.minecraft.pt/webchat" class="socialicon" style="background-image: url('<?= $icon_path ?>/social_chat.png');"></a></li>
        <li><a title="Facebook" href="http://facebook.com/MinecraftPT" class="socialicon" style="background-image: url('<?= $icon_path ?>/social_fb.png');"></a></li>
        <li><a title="Blog" href="http://blog.minecraft.pt/" class="socialicon" style="background-image: url('<?= $icon_path ?>/social_wp.png');"></a></li>
        <li><a title="Email" href="mailto:mail[at]minecraft.pt" class="socialicon" style="background-image: url('<?= $icon_path ?>/social_email.png');"></a></li>
        <li><a title="Youtube" class="socialicon" style="background-image: url('<?= $icon_path ?>/social_yt.png');"></a></li>
      </ul>
    </div>
    <div id="languagebar"><a href="#" class="i18n" data-lang="pt_PT">PT</a> | <a href="#" class="i18n" data-lang="en_GB">EN</a></div>
  </div>
</body>
</html>
