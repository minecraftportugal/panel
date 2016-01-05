<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf8" />
    <meta name="language" content="en" />
    <meta name="author" content="Comunidade Minecraft Portugal" />

    <? foreach ($styles as $style): ?>
        <link rel="stylesheet" href="/css/<?= $style ?>.css" media="screen" type="text/css">
    <? endforeach; ?>

    <link href="//fonts.googleapis.com/css?family=Lato%3A400%2C700%2C400italic%2C700italic%7CRaleway%3A700%2C400&#038;ver=4.4" rel="stylesheet" type="text/css">

    <? foreach ($scripts as $script): ?>
        <script type="text/javascript" src="/js/<?= $script ?>.js"></script>
    <? endforeach; ?>

</head>

<body>

    <p>
        Queres jogar no nosso servidor e ter acesso a todos os conteudos que oferecemos?
        Para poderes jogar conosco não necessitas de uma conta mojang, podendo utilizar qualquer nome disponível,
        bastando que te registes aqui.
    </p>

    <? if (ENABLE_REGISTRATIONS): ?>
    <form id="register" name="register" method="post" action="/register">
        <ul>
            <li>
                <input type="text" id="username" name="username" placeholder="esteves" />
            </li>
            <li>
                <input type="text" id="email" name="email" placeholder="esteves@mcpt.eu" />
            </li>
            <li>
                <button id="register" type="submit">Registar!</button>
            </li>
            <li>
                <div id="status"></div>
            </li>
            <li>
                <div id="waiting"><i class="fa fa-spinner fa-2x fa-spin"></i></div>
            </li>
        </ul>
    </form>
    <? else: ?>
    <p>
        <h1>Registrations are currently disabled.</h1>
    </p>
    <? endif; ?>

    <p>
        Utiliza o <u>mesmo</u> nome de utilizador que usas para jogar Minecraft e um endereço de email válido onde possas receber a tua password.
        <span class="important">Se tentares jogar com um nome diferente do que utilizaste aqui, não irás conseguir fazer login.</span>
    </p>

    <p>
        Receberás um email com a tua password e com alguns detalhes importantes. Não te esqueças de o ler com atenção!
    </p>


</body>
</html>
