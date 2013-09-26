<!DOCTYPE html>
<html>
<head>
    <meta charset=utf-8 />
    <title><?= m("L_TITLE") ?></title>
    <link rel="stylesheet" type="text/css" media="screen" href="/styles/reset.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="/styles/public.css" />
    <link rel="alternate" href="/blog/?feed=rss2" title="Minecraftia! RSS feed" type="applications/rss+xml" />
    <link rel="shortcut icon" href="/images/favicon.ico" />
    <script type="text/javascript" src="/scripts/jquery.js"></script>
    <script type="text/javascript" src="/scripts/cookies.js"></script>
    <script type="text/javascript" src="/scripts/i18n.js"></script>
    <script type="text/javascript" Src="/scripts/login.js"></script>
    <!--[if IE]>
        <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <style type="text/css">
      body#login {
        background: #000 url('/images/backgrounds/login/bg<?= rand(1,4) ?>.png') no-repeat top center;
      }
    </style>
</head>
<body id="login">
  <div id="content">
    <div id="motd">
      <h1><?= m("L_WELCOME") ?></h1>
      <p><?= m("L_WELCOME1") ?></p>
      <p><?= m("L_WELCOME2") ?> </p>
      <p><?= m("L_WELCOME3"); ?> </p>
    </div>
    <div id="actions">
      <form name="login" method="post" action="/login">
        <span class="center"><input type="text" name="username" autofocus="true" placeholder="username" /></span>
        <span class="center"><input type="password" name="password" placeholder="password" /></span>
        <span class="center"><input type="submit" value="Login"/></span>
        <span>
        <? 
          $error = getFlash('error');
          if ($error != false):
        ?>
          <label class="error"><?= $error ?></label>
        <? endif; ?>
        
        <? 
          $success = getFlash('success');
          if ($success != false):
        ?>
          <label class="success"><?= $success ?></label>
        <? endif; ?>
        <span>
      </form>
    </div>
    <div id="social">
      <ul class="icons">
        <? $icon_path = "/images/icons"; ?>
        <li><a title="Facebook" href="http://facebook.com/MinecraftPT" class="socialicon" style="background-image: url('<?= $icon_path ?>/social_fb.png');"></a></li>
        <li><a title="Tumblr" class="socialicon" style="background-image: url('<?= $icon_path ?>/social_tumblr.png');"></a></li>
        <li><a title="Blog" href="http://blog.minecraft.pt/" class="socialicon" style="background-image: url('<?= $icon_path ?>/social_wp.png');"></a></li>
        <li><a title="Twitter" href="http://www.twitter.com/oficialmcpt" class="socialicon" style="background-image: url('<?= $icon_path ?>/social_twitter.png');"></a></li>
        <li><a title="Email" href="mailto:mail[at]minecraft.pt" class="socialicon" style="background-image: url('<?= $icon_path ?>/social_email.png');"></a></li>
        <li><a title="Webchat" href="//blog.minecraft.pt/webchat" class="socialicon" style="background-image: url('<?= $icon_path ?>/social_chat.png');"></a></li>
        <li><a title="Youtube" class="socialicon" style="background-image: url('<?= $icon_path ?>/social_yt.png');"></a></li>
      </ul>
    </div>
    <!--<div id="languagebar">
      <ul class="icons">
        <li><a href="#" class="i18n" data-lang="pt_PT"></a></li>
        <li><a href="#" class="i18n" data-lang="en_GB"></a></li>
      </ul>
    </div>-->
  </div>
</body>
</html>