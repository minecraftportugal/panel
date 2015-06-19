<script type="text/javascript"> $(function() { App.Public.load(); }); </script>

<?= $notices ?>

<div id="register">
    <div id="motd">
        <h1>Novo Registo</h1>
        <p>Queres jogar no nosso servidor e ter acesso a todos os conteudos que temos neste painel?</p>
        <p>
            Utiliza o <u>mesmo</u> nome de utilizador que usas para jogar Minecraft e um endereço de email válido onde possas receber a tua password.
            <span class="important">Se tentares jogar com um nome diferente do que utilizaste aqui, não irás conseguir fazer login.</span>
        </p>
    </div>

    <? if (ENABLE_REGISTRATIONS): ?>
    <div id="actions">
        <form name="register" method="post" action="/register">
            <ul>
                <li>
                    <input type="text" id="username" name="username" placeholder="esteves" />
                </li>
                <li>
                    <input type="text" id="email" name="email" placeholder="esteves@minecraft.pt" />
                </li>
                <li>
                    <button id="register" type="submit">Registar!</button>
                </li>
            </ul>
        </form>

        <form name="showLogin" method="get" action="/login">
            <ul>
                <li><button id="show-login" type="submit">Já tenho uma conta!</button></li>
            </ul>
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
