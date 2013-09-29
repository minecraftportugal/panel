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
      <h1>Comunidade Minecraft Portugal</h1>
      <p>
        Bem vindo ao painel do servidor oficial da Comunidade. Se ainda não fazes parte, <a href="/register">regista-te aqui</a>.
      </p>
      <p>
        Se procuras mais informações sobre o servidor contacta-nos em <u><span class="email">mail[at]minecraft.pt</span></u> 
        ou vem conversar conosco no <a href="//blog.minecraft.pt/webchat/" target="_blank">#minecraft</a> na
        Rede de IRC <a href="http://www.ptnet.org/" target="_blank">PTnet</a>.
      </p>
      <p>
        Para estares a par de todas as novidades, visita o nosso blog em <a href="//blog.minecraft.pt" target="_blank">blog.minecraft.pt</a>
        ou segue-nos no <a href="http://fb.com/MinecraftPT" target="_blank">Facebook</a>.
      </p>
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
        <li><a title="Facebook" href="http://facebook.com/MinecraftPT" class="socialicon" style="background-image: url('<?= $icon_path ?>/social_fb.png');" target="_blank"></a></li>
        <li><a title="Tumblr" class="socialicon" style="background-image: url('<?= $icon_path ?>/social_tumblr.png');" target="_blank"></a></li>
        <li><a title="Blog" href="http://blog.minecraft.pt/" class="socialicon" style="background-image: url('<?= $icon_path ?>/social_wp.png');" target="_blank"></a></li>
        <li><a title="Twitter" href="http://www.twitter.com/oficialmcpt" class="socialicon" style="background-image: url('<?= $icon_path ?>/social_twitter.png');" target="_blank"></a></li>
        <li><a title="Email" href="mailto:mail[at]minecraft.pt" class="socialicon" style="background-image: url('<?= $icon_path ?>/social_email.png');" target="_blank"></a></li>
        <li><a title="Webchat" href="//blog.minecraft.pt/webchat" class="socialicon" style="background-image: url('<?= $icon_path ?>/social_chat.png');" target="_blank"></a></li>
        <li><a title="Youtube" class="socialicon" style="background-image: url('<?= $icon_path ?>/social_yt.png');"></a></li>
      </ul>
    </div>
  </div>
</body>
</html>