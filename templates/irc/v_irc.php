<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">

    <head>

        <meta http-equiv="Content-Type" content="text/html; charset=utf8" />
        <meta name="language" content="de" />
        <meta name="author" content="Valentin Manthei - lightIRC.com" />

<? foreach ($styles as $style): ?>
    <link rel="stylesheet" href="/css/<?= $style ?>.css" media="screen" type="text/css">
<? endforeach; ?>

<? foreach ($scripts as $script): ?>
    <script type="text/javascript" src="js/<?= $script ?>.js"></script>
<? endforeach; ?>

    </head>

    <body>
        <div id="lightIRC">
            <p>
                <a href="//www.adobe.com/go/getflashplayer">
                    <img src="//www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" />
                </a>
            </p>
        </div>

        <script type="text/javascript">

            params.realname = "Minecraftia User: <?= $_SESSION['username'] ?>";
            params.wmode = "transparent";

        <? if ($user['ircnickname'] != NULL): ?>

            params.nick = "<?= $user['ircnickname'] ?>";
            params.identifyPassword = "<?= $user['ircpassword'] ?>";
            params.ident = "<?=dechex(ip2long($_SERVER['REMOTE_ADDR']))?>X";

        <? else: ?>

            params.nick = "<?= $_SESSION['username'] ?>";
            params.nickAlternate = "<?= $_SESSION['username'] ?>_";
            params.ident = "<?=dechex(ip2long($_SERVER['REMOTE_ADDR']))?>O";
            params.identifyMessage = "NickServ:Nick registado e protegido";

        <? endif; ?>

        <? if ($user['ircauto'] != 1): ?>

            params.showNickSelection = "true";

        <? else: ?>

            params.showNickSelection = "false";

        <? endif; ?>

        <? if ($user['admin'] == 1): ?>

            params.autojoin = "#minecraft,#minecraft-dev,#minecraft-log adminlogchan";

        <? endif; ?>

            var x = swfobject.embedSWF("<?= LIGHTIRC_PATH ?>", "lightIRC", "100%", "100%", "10.0.0", "expressInstall.swf", params, {wmode:"transparent"});

        </script>
    </body>
</html>
