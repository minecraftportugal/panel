<!DOCTYPE html>
<html>
<head>
    <meta charset=utf-8 />
    <title><?= m("L_TITLE") ?></title>
    <link rel="stylesheet" type="text/css" media="screen" href="/styles/reset.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="/styles/register.css" />
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
      <form name="login" method="post" action="/register">
        
        <span class="center"><input type="text" id="username" name="username" placeholder="<?= m("L_USERNAMEA") ?>" /></span>
        <span class="center"><input type="text" id="email" name="email" placeholder="<?= m("L_EMAILA") ?>" /></span>
        <span class="center"><input type="submit" value="<?= m("L_CREATEACC") ?>"/></span>
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
        </span>
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