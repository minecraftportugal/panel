<script type="text/javascript"> $(function() { App.Public.load(); }); </script>

<?= $notices ?>

<div id="login">

    <div id="title">
        <h1>Comunidade Minecraft Portugal</h1>
    </div>

    <div id="motd">
        <p>
            Bem vindo ao painel do servidor oficial da Comunidade. Se ainda não fazes parte, <a href="/register">regista-te aqui</a>.
        </p>
        <p>
            Se precisares de ajuda contacta-nos em <u><span class="email">mail[at]minecraft.pt</span></u>
            ou vem conversar connosco no <a href="//blog.minecraft.pt/webchat/" target="_blank">#minecraft</a> na
            Rede de IRC <a href="http://www.ptnet.org/" target="_blank">PTnet</a>.
        </p>
        <p>
            Se procuras mais informações sobre o servidor ou para te manteres a par de todas as novidades, visita o nosso site em <a href="//www.minecraft.pt" target="_blank">www.minecraft.pt</a>
            ou segue-nos no <a href="http://fb.com/MinecraftPT" target="_blank">Facebook</a> e no <a href="http://twitter.com/oficialmcpt" target="_blank">Twitter</a>.
        </p>
    </div>

    <div id="actions">
        <form name="login" method="post" action="/login">
            <ul>
                <li><input type="text" name="username" autofocus="true" placeholder="username" /></li>
                <li><input type="password" name="password" placeholder="password" /></li>
                <li><button id="login" type="submit">Login</button></li>

            </ul>
        </form>

        <form name="showRegister" method="get" action="/register">
            <ul>
                <li><button id="show-register" type="submit">Quero Registar-me!</button></li>
            </ul>
        </form>
    </div>

    <div id="social">
        <ul class="icons">
            <li>
                <a title="Site" href="http://www.minecraft.pt/" class="socialicon" style="background-image: url('<?= $icon_path ?>/social_wp.png');" target="_blank"></a>
            </li>
            <li>
                <a title="Facebook" href="http://facebook.com/MinecraftPT" class="socialicon" style="background-image: url('<?= $icon_path ?>/social_fb.png');" target="_blank"></a>
            </li>
            <li>
                <a title="Tumblr" href="http://oficialmcpt.tumblr.com" class="socialicon" style="background-image: url('<?= $icon_path ?>/social_tumblr.png');" target="_blank"></a>
            </li>
            <li>
                <a title="Twitter" href="http://www.twitter.com/oficialmcpt" class="socialicon" style="background-image: url('<?= $icon_path ?>/social_twitter.png');" target="_blank"></a>
            </li>
            <li>
                <a title="Email" href="mailto:mail[ a t ]minecraft.pt" class="socialicon" style="background-image: url('<?= $icon_path ?>/social_email.png');" target="_blank"></a>
            </li>
            <li>
                <a title="Webchat" href="//www.minecraft.pt/webchat" class="socialicon" style="background-image: url('<?= $icon_path ?>/social_chat.png');" target="_blank"></a>
            </li>
            <li>
                <a title="Youtube" href="http://www.youtube.com/user/oficialmcpt" class="socialicon" style="background-image: url('<?= $icon_path ?>/social_yt.png');" target="_blank"></a>
            </li>
        </ul>
    </div>
</div>

