<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf8" />
    <meta name="language" content="en" />
    <meta name="author" content="Comunidade Minecraft Portugal" />

<? foreach ($styles as $style): ?>
    <link rel="stylesheet" href="/css/<?= $style ?>.css" media="screen" type="text/css">
<? endforeach; ?>


<? foreach ($scripts as $script): ?>
    <script type="text/javascript" src="/js/<?= $script ?>.js"></script>
<? endforeach; ?>

</head>

<body>

<? if ($total > 0): ?>

    <div id="onlineplayers">
        <h1><?= $total ?> jogadores online!</h1>

        <ul>
        <? foreach((array)$players as $r): ?>
            <li>
                <span class="stevehead">
                    <?= $r['head'] ?>
                </span>
                <span class="name">
                    <?= $r['playername'] ?>
                </span>
            </li>
        <? endforeach; ?>
        </ul>
    </div>

    <? endif;?>

    <p>Servidor da Comunidade Minecraft Portugal</p>
    <p>IP: mcpt.eu</p>
    <p><a href="//www.mcpt.eu/registo" target="_blank">Regista-te já!</a></p>

</body>
</html>
