<!DOCTYPE html>
<html>

<head>
    <meta charset=utf-8 />
    <meta name="keywords" content="minecraft, Portugal, pt, tuga, blog, server, servidor, notícias, login">
    <title>Comunidade Minecraft Portugal</title>

    <link rel="shortcut icon" href="favicon.ico" >

<? foreach ($styles as $style): ?>
    <link rel="stylesheet" href="/css/<?= $style ?>.css" media="screen" type="text/css">
<? endforeach; ?>

<? foreach ($scripts as $script): ?>
    <script type="text/javascript" src="js/<?= $script ?>.js"></script>
<? endforeach; ?>

    <style type="text/css">
        body#login {
            background: #000 url('/images/backgrounds/bg<?= rand(5,8) ?>.jpg') no-repeat top center;
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
                ou vem conversar connosco no <a href="//blog.minecraft.pt/webchat/" target="_blank">#minecraft</a> na
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
                <? if ($error != false): ?>
                    <label class="error"><?= $error ?></label>
                <? endif; ?>

                <? if ($success != false): ?>
                    <label class="success"><?= $success ?></label>
                <? endif; ?>
                <span>
            </form>
        </div>
        <div id="social">
            <ul class="icons">
                <li><a title="Facebook" href="http://facebook.com/MinecraftPT" class="socialicon" style="background-image: url('<?= $icon_path ?>/social_fb.png');" target="_blank"></a></li>
                <li><a title="Tumblr" href="http://oficialmcpt.tumblr.com" class="socialicon" style="background-image: url('<?= $icon_path ?>/social_tumblr.png');" target="_blank"></a></li>
                <li><a title="Blog" href="http://blog.minecraft.pt/" class="socialicon" style="background-image: url('<?= $icon_path ?>/social_wp.png');" target="_blank"></a></li>
                <li><a title="Twitter" href="http://www.twitter.com/oficialmcpt" class="socialicon" style="background-image: url('<?= $icon_path ?>/social_twitter.png');" target="_blank"></a></li>
                <li><a title="Email" href="mailto:mail[ a t ]minecraft.pt" class="socialicon" style="background-image: url('<?= $icon_path ?>/social_email.png');" target="_blank"></a></li>
                <li><a title="Webchat" href="//www.minecraft.pt/webchat" class="socialicon" style="background-image: url('<?= $icon_path ?>/social_chat.png');" target="_blank"></a></li>
                <li><a title="Youtube" href="http://www.youtube.com/user/oficialmcpt" class="socialicon" style="background-image: url('<?= $icon_path ?>/social_yt.png');"></a></li>
            </ul>
        </div>
    </div>
</body>

</html>
