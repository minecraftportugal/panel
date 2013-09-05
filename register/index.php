<?php
require('../config.php');
require('../lib.php');
require('../i18n.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['username']) && isset($_POST['email'])) {
    $username = s($_POST['username']);
    $email = s($_POST['email']);

    $result = register($username, $email, $email_ip = true);
    if ($result != "0") {
      header("Location: /register?f=$result");
    } else {
      header("Location: /login?f=3");
    }
  }
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
    <script type="text/javascript" Src="/scripts/register.js"></script>
    <!--[if IE]>
        <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>
<body>
  <div id="content">
    <div id="motd">
      <h1><?= m("L_REGISTER0") ?></h1>
      <p><?= m("L_REGISTER1") ?></p>
      <p><?= m("L_WELCOME3"); ?></p>
    </div>

    <? if ($cfg_enable_registrations): ?>
    <div id="actions">
      <form name="login" method="post" action="index.php">
        
        <span class="center"><input type="text" id="username" name="username" placeholder="<?= m("L_USERNAMEA") ?>" /></span>
        <span class="center"><input type="text" id="email" name="email" placeholder="<?= m("L_EMAILA") ?>" /></span>
        <span class="center"><input type="submit" value="<?= m("L_CREATEACC") ?>"/></span>
        <?php if (isset($_GET['f']) && $_GET['f'] == 1): ?>
          <label class="error">Email address already used</label>
        <?php elseif (isset($_GET['f']) && $_GET['f'] == 2): ?>
          <label class="error">Username already taken</label>
        <?php elseif (isset($_GET['f']) && $_GET['f'] == 3): ?>
          <label class="error">Invalid email address</label>
        <?php elseif (isset($_GET['f']) && $_GET['f'] == 4): ?>
          <label class="error">Invalid username</label>
        <?php elseif (isset($_GET['f'])): ?>
          <label class="error">Someone is being a smartass</label>
        <?php else: ?>
          <label></label>
        <?php endif; ?>
      </form>
    </div>
    <? else: ?>
    <div id="actions">
      <h1>Registrations are currently disabled.</h1>
    </div>
    <? endif; ?>
    <div id="languagebar"><a href="#" class="i18n" data-lang="pt_PT">PT</a> | <a href="#" class="i18n" data-lang="en_GB">EN</a></div>
  </div>
</body>
</html>
