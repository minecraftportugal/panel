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
    <p>Receitas: <?= $revenue ?> &euro;</p>
    <p>Despesas: <?= $expenses ?> &euro;</p>
    <p>Balanço: <?= $balance ?> &euro;</p>
    <p>(desde 09/2013)</p>
</body>
