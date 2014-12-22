<!DOCTYPE html>
<html>

<head>

    <meta charset=utf-8 />
    <meta name="keywords" content="minecraft, Portugal, pt, tuga, blog, server, servidor, notícias, registo">

    <title>Comunidade Minecraft Portugal</title>

    <link rel="shortcut icon" href="favicon.ico" >

<? foreach ($styles as $style): ?>
    <link rel="stylesheet" href="/css/<?= $style ?>.css" media="screen" type="text/css">
<? endforeach; ?>


<? foreach ($scripts as $script): ?>
    <script type="text/javascript" src="js/<?= $script ?>.js"></script>
<? endforeach; ?>

    <style type="text/css">
        body#register {
            background: #000 url('/images/backgrounds/bg<?= rand(5,8) ?>.jpg') no-repeat top center;
        }
    </style>

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
            <form name="register" method="post" action="/register">
                <span class="center">
                    <input type="text" id="username" name="username" placeholder="esteves" />
                </span>
                <span class="center">
                    <input type="text" id="email" name="email" placeholder="esteves@minecraft.pt" />
                </span>
                <span class="center">
                    <input type="submit" value="Registar!"/></span>
                <span>
                <? if ($error != false): ?>
                    <label class="error"><?= $error ?></label>
                <? endif; ?>

                <? if ($success != false): ?>
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
                <li>
                    <a title="Facebook" href="http://facebook.com/MinecraftPT" class="socialicon" style="background-image: url('<?= $icon_path ?>/social_fb.png');" target="_blank"></a>
                </li>
                <li>
                    <a title="Tumblr" href="http://oficialmcpt.tumblr.com" class="socialicon" style="background-image: url('<?= $icon_path ?>/social_tumblr.png');" target="_blank"></a>
                </li>
                <li>
                    <a title="Blog" href="http://blog.minecraft.pt/" class="socialicon" style="background-image: url('<?= $icon_path ?>/social_wp.png');" target="_blank"></a>
                </li>
                <li>
                    <a title="Twitter" href="http://www.twitter.com/oficialmcpt" class="socialicon" style="background-image: url('<?= $icon_path ?>/social_twitter.png');" target="_blank"></a>
                </li>
                <li>
                    <a title="Email" href="mailto:mail[ a t ]minecraft.pt" class="socialicon" style="background-image: url('<?= $icon_path ?>/social_email.png');" target="_blank"></a>
                </li>
                <li>
                    <a title="Webchat" href="//blog.minecraft.pt/webchat" class="socialicon" style="background-image: url('<?= $icon_path ?>/social_chat.png');" target="_blank"></a>
                </li>
                <li>
                    <a title="Youtube" href="http://www.youtube.com/user/oficialmcpt" class="socialicon" style="background-image: url('<?= $icon_path ?>/social_yt.png');"></a>
                </li>
            </ul>
        </div>
    </div>
</body>
</html>