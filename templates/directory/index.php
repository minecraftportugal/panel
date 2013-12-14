<!DOCTYPE html>
<html>
<head>
    <meta charset=utf-8 />
    <title>directory</title>
    
    <link rel="stylesheet" type="text/css" media="screen" href="/styles/reset.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="/styles/sidebar.css" />

    <script type="text/javascript" src="/scripts/jquery.js"></script>
    <script type="text/javascript" src="/scripts/frames.js"></script>
    <script type="text/javascript" src="/scripts/steve.js"></script>
    <script type="text/javascript" src="/scripts/sidebar.js"></script>
    <script type="text/javascript" src="/scripts/dynmap.js"></script>
    <script type="text/javascript" src="/scripts/sop.js"></script>


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
    <form name="directory_users_filters" action="/directory" method="GET" autocomplete="off">
      <table class="admin options">
        <thead>
          <tr>
            <th class="center" style="width:35%;"><h2>Nome</h2></th>
            <td><input type="text" name="playername" placeholder="steve" value="<?= $playername ?>"></td>
          </tr>
          <tr>
             <th class="center"><h2>Critérios</h2></th>
            <td>
              <input id="staff" type="checkbox" name="staff" value="1" <?= $staff == 1 ? 'checked="checked"' : '' ?> />
              <label class="checkbox" for="staff">staff</label>
            </td>
          </tr>
          <tr>
            <td></td>
            <td>
              <input id="contributor" type="checkbox" name="contributor" value="1" <?= $contributor == 1 ? 'checked="checked"' : '' ?> />
              <label class="checkbox" for="contributor">contribuidor</label>
            </td>
          </tr>
          <tr>
            <td></td>
            <td>
              <input id="donor" type="checkbox" name="donor" value="1" <?= $donor == 1 ? 'checked="checked"' : '' ?> />
              <label class="checkbox" for="donor">dador</label>
            </td>
          </tr>
          <tr>
            <td></td>
            <td>
              <input id="premium" type="checkbox" name="premium" value="1" <?= $premium == 1 ? 'checked="checked"' : '' ?> />
              <label class="checkbox" for="premium">premium</label>
            </td>
          </tr>
          <tr>
            <td></td>
            <td>
              <input id="isonline" type="checkbox" name="online" value="1" <?= $online == 1 ? 'checked="checked"' : '' ?> />
              <label class="checkbox" for="isonline">online</label>
            </td>
          </tr>
          <tr>
            <td colspan="2" class="center">
              <input type="submit" value="pesquisar" />
            </td>
          </tr>
        </thead>
      </table>
    </form>
    <? if (!empty($userlist)): ?>
      <div class="meh"> 
      <table>
        <tbody>
          <tr <?= $r["lastloginip"] == NULL ? 'data-no-login="true"' : '' ?> >
            <td class="shortcell cella">

        <? foreach((array)$userlist as $r): ?>
          <? $badges = getUserBadges($r["id"]); ?>
              <div class="player">
                <div style="width: 95px; margin-left:31px;">
                <a data-dynmap-gotoplayer="<?= $r['playername'] ?>"
                   class="button-padded"
                   href="/profile?id=<?= $r['id'] ?>"
                   title="<?= $r["registerdate"] ?>">
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
                <? if ($badges['active'] != 1): ?>
                  <span title="Conta Desactivada" class="badge2 badge-deactivated"></span>
                <? endif; ?>
                <? if (($badges['premium'] == 1)
                   or  ($badges['admin'] == 1)
                   or  ($badges['operator'] == 1)
                   or  ($badges['donor'] == 1)
                   or  ($badges['contributor'] == 1)
                   or  ($badges['active'] != 1)
                   or  ($badges['member'] == 1)):
                ?>
                  <div style="height:10px;clear:both;"></div>
                <? endif; ?>
              </div>
              
              <div style="text-overflow: ellipsis; overflow: hidden;text-align:center;">
                <a href="/profile?id=<?= $r['id'] ?>"
                    title="<?= $r["registerdate"] ?>"
                    data-online="<?= in_array($r['playername'], $flatOnlinePlayers) ? 'true' : 'false' ?>">
                  <span class=""><?= $r["playername"] ?></span> <br>
                  <span class="online no-margin-left"></span>
                </a>
              </div>
            </div>

             <? endforeach; ?>
            </td>
          </tr>
          <tr><td class="nav"><?= $page_navigation ?></td></tr>
        </tbody>
      </table>
      </div>
    <? endif; ?>
    </div>
  </div>
</div>



</div>
</body>
</html>
