<!DOCTYPE html>
<html>
<head>
    <meta charset=utf-8 />
    <title>directory</title>
    
    <link rel="stylesheet" type="text/css" media="screen" href="/styles/reset.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="/styles/sidebar.css" />

    <script type="text/javascript" src="/scripts/jquery.js"></script>
    <script type="text/javascript" src="/scripts/frames.js"></script>
    <script type="text/javascript" src="/scripts/admin.js"></script>

    <!--[if IE]>
        <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

</head>
<body>
 <div id="conteudo">

  <? 
    if (isLoggedIn()) {
      require __DIR__.'/../partials/userbar.php';
    }
  ?>

  <? 
    $error = getFlash('error');
    if ($error != false):
  ?>
    <div class="section error"><?= $error ?></div>
  <? endif; ?>

  <? 
    $success = getFlash('success');
    if ($success != false):
  ?>
    <div class="section success"><?= $success ?></div>
  <? endif; ?>



  <div id="playerlist" class="collapsible section default">
    <a href="#playerlist"><h1>Jogadores</h1></a>
    <div class="inside">
      <div class="meh"> 
      <table class="alt-rows">
        <tbody>
          <tr <?= $r["lastloginip"] == NULL ? 'data-no-login="true"' : '' ?> >
            <td class="shortcell cella">

        <? foreach($userlist as $r): ?>
          <? $badges = getUserBadges($r["id"]); ?>
          <? $a = getLastSession($r["id"]); ?>
              
              <div class="player">
                <div style="width: 95px; margin-left:23.5px;">
                <a class="button-padded" href="/profile?id=<?= $r['id'] ?>" title="<?= $r["email"] ?>" title="<?= $r["playername"] ?>">
                  <? $head_url = "http://s3.amazonaws.com/MinecraftSkins/".$r['playername'].".png"; ?>
                  <span class="stevehead large">
                    <img class="pixels" src="/images/steve.png" data-src="<?= $head_url ?>" alt="Skin" />
                  </span>
                  </a>
                </div>
                <div style="height:10px;clear:both;"></div>

              <div class="badges">
                <? if ($badges['member'] == 1): ?>
                  <span title="Membro" class="badge2 badge-member"></span>
                <? endif; ?>  
                <? if ($badges['admin'] == 1): ?>
                  <span title="Administrador do Servidor" class="badge2 badge-administrator"></span>
                <? endif; ?>
                <? if ($badges['operator'] == 1): ?>
                  <span title="Operador do Servidor" class="badge2 badge-operator"></span>
                <? endif; ?>
                <? if ($badges['donor'] == 1): ?>
                  <span title="Dador" class="badge2 badge-donor"></span>
                <? endif; ?>
                <? if ($badges['contributor'] == 1): ?>
                  <span title="Contribuidor" class="badge2 badge-contributor"></span>
                <? endif; ?>
                <? if ($badges['premium'] == 1): ?>
                  <span title="Premium" class="badge2 badge-premium"></span>
                <? endif; ?>
                <? if (($badges['premium'] == 1)
                   or  ($badges['admin'] == 1)
                   or  ($badges['operator'] == 1)
                   or  ($badges['donor'] == 1)
                   or  ($badges['contributor'] == 1)
                   or  ($badges['member'] == 1)):
                ?>
                  <div style="height:10px;clear:both;"></div>
                <? endif; ?>
              </div>
              
              <div style="text-overflow: ellipsis; overflow: hidden;text-align:center;">
                <a href="/profile?id=<?= $r['id'] ?>" title="<?= $r["email"] ?>" title="<?= $r["playername"] ?>">
                  <?= $r["playername"] ?>
                </a>
              </div>
            </div>

             <? endforeach; ?>
            </td>
          </tr>
          <tr><td class="nav2"><?= $page_navigation ?></td></tr>
        </tbody>
      </table>
      </div>
    </div>
  </div>
</div>



</div>
</body>
</html>
