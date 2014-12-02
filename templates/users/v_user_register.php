<!DOCTYPE html>
<html>
<head>
    <meta charset=utf-8 />
    <meta name="keywords" content="minecraft, Portugal, pt, tuga, blog, server, servidor, notícias, registo">
    <title>Comunidade Minecraft Portugal</title>
    <link rel="stylesheet" type="text/css" media="screen" href="/styles/reset.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="/styles/public.css" />
    <link rel="alternate" href="/blog/?feed=rss2" title="Minecraftia! RSS feed" type="applications/rss+xml" />
    <link rel="shortcut icon" href="/favicon.ico" />
    <script type="text/javascript" src="/scripts/jquery.js"></script>
    <script type="text/javascript" src="/scripts/cookies.js"></script>
    <script type="text/javascript" src="/scripts/register.js"></script>
    <script type="text/javascript" src="/scripts/sop.js"></script>
    <!--[if IE]>
        <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>
<body id="register">
  <div id="content">
    <div id="motd">
      <h1>Novo Registo</h1>
      <p>Utiliza o <u>mesmo</u> nome de utilizador que usas para jogar Minecraft e um endereço de email onde possas receber a tua password.</p>
      <p>Para estares a par de todas as novidades, visita o nosso blog em <a href=\"//blog.minecraft.pt\" target=\"_blank\">blog.minecraft.pt</a>.</p>
    </div>

    <? if (ENABLE_REGISTRATIONS): ?>
    <div id="actions">
      <form name="login" method="post" action="/register">
        <span class="center"><input type="text" id="username" name="username" placeholder="esteves" /></span>
        <span class="center"><input type="text" id="email" name="email" placeholder="esteves@minecraft.pt" /></span>
        <span class="center"><input type="submit" value="Registar!"/></span>
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
    <div id="social">
      <ul class="icons">
        <? $icon_path = "/images/icons"; ?>
        <li><a title="Facebook" href="http://facebook.com/MinecraftPT" class="socialicon" style="background-image: url('<?= $icon_path ?>/social_fb.png');" target="_blank"></a></li>
        <li><a title="Tumblr" href="http://oficialmcpt.tumblr.com" class="socialicon" style="background-image: url('<?= $icon_path ?>/social_tumblr.png');" target="_blank"></a></li>
        <li><a title="Blog" href="http://blog.minecraft.pt/" class="socialicon" style="background-image: url('<?= $icon_path ?>/social_wp.png');" target="_blank"></a></li>
        <li><a title="Twitter" href="http://www.twitter.com/oficialmcpt" class="socialicon" style="background-image: url('<?= $icon_path ?>/social_twitter.png');" target="_blank"></a></li>
        <li><a title="Email" href="mailto:mail[ a t ]minecraft.pt" class="socialicon" style="background-image: url('<?= $icon_path ?>/social_email.png');" target="_blank"></a></li>
        <li><a title="Webchat" href="//blog.minecraft.pt/webchat" class="socialicon" style="background-image: url('<?= $icon_path ?>/social_chat.png');" target="_blank"></a></li>
        <li><a title="Youtube" href="http://www.youtube.com/user/oficialmcpt" class="socialicon" style="background-image: url('<?= $icon_path ?>/social_yt.png');"></a></li>
      </ul>
    </div>
  </div>
</body>
</html>
