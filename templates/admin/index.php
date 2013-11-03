<!DOCTYPE html>
<html>
<head>
    <meta charset=utf-8 />
    <title>news</title>
    
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

 
  <div id="accounts" class="collapsible section default">
    <a href="#accounts"><h1>Gerir Utilizadores (<?= $total ?>)</h1></a>
    <div class="inside">
    <form name="manage_users_filters" action="/admin" method="GET" autocomplete="off">
      <table class="admin options">
        <thead>
        <?/* <tr> 
            <th><h2>Filtros</h2></th>
            <td>
              <input id="select_a" type="checkbox" />
              <label class="checkbox" for="select_a">Administrador</label>
            </td>
          </tr>
          <tr> 
            <td></td>
            <td>
              <input id="select_a" type="checkbox" />
              <label class="checkbox" for="select_a">Premium</label>
            </td>
          </tr>*/?>
          <tr>
            <th style="width:25%;"><h2>Nome</h2></th>
            <td><input type="text" name="playername" placeholder="steve" value="<?= $playername ?>"></td>
          </tr>
          <tr>
            <th><h2>Último IP</h2></th>
            <td><input type="text" name="ipaddress" placeholder="192.168.0.1" value="<?= $ipaddress ?>"></td>
          </tr>
          <tr>
            <td colspan="2" class="center">
              <input type="submit" value="filtrar" />
            </td>
          </tr>
        </thead>
      </table>
    </form>
    <div class="meh">
    <form name="manage_users" action="/admin/configure" method="POST" autocomplete="off">
      <table class="alt-rows admin">
        <thead>
          <tr>
            <th class="cella"><h2 title="Player Name">Player<h2></th>
            <th class="cellb"><h2 title="Ultimo IP (não actualizado se entrar não registado/logado)">Ultimo IP</h2></th>
            <th class="cellc"><h2 title="Administrador">@</h2></th>
            <th class="cellc"><h2 title="Conta Activa">A</h2></th>
            <th class="cellc"><h2 title="APAGAR A CONTA!">X</h2></th>
            <th class="celld"></th>
          </tr>
        </thead>
        <tbody>
        <? foreach($userlist as $r): ?>
        <? $a = getLastSession($r["id"]); ?>
          <tr>
            <td class="shortcell cella">
              <a class="button-padded" href="/profile?id=<?= $r['id'] ?>" title="<?= $r["email"] ?>">
                <? $head_url = "http://s3.amazonaws.com/MinecraftSkins/".$r['playername'].".png"; ?>
                <span class="stevehead">
                  <img class="pixels" src="/images/steve.png" data-src="<?= $head_url ?>" alt="Skin" />
                </span><?= $r["playername"] ?>
              </a>
            </td>
            
            <td class="shortcell cellb">
              <a href="/admin?ipaddress=<?= $r['lastloginip'] ?>" title="<?= $r["lastlogindate"] ? $r["lastlogindate"] : $r["registerdate"] . "*" ?>">
                <?= $r["lastloginip"] != NULL ? $r["lastloginip"] : "<i>".$r["registerip"]."</i>" ?>
              </a>
            </td>
            <td class="cellc center">
              <input class="gridy" name="admin[]" value="<?= $r["id"] ?>" type="checkbox" <?= $r["admin"] == 1 ? 'checked="checked"' : '' ?> />
            </td>
            <td class="cellc center">
              <input class="gridy fakecheckbox" type="checkbox" <?= $r["active"] == 1 ? 'checked="checked"' : '' ?> />
              <input name="active[<?= $r["id"] ?>]" value="<?= $r["active"] ?>" type="hidden" />
            </td>
            <td class="cellc center">
              <input class="gridy" name="delete[]" value="<?= $r["id"] ?>" type="checkbox" />
            </td>
            <td class="celld"></td>
          </tr>
        <? endforeach; ?>
        </tbody>
      </table>
      </div>
      <table class="admin">
        <tbody>
          <tr>
            <td colspan="5" class="center">
              <input type="submit" value="OK" />        
              <input type="hidden" name="xsrf_token" value="<?= getXSRFToken() ?>" />
            </td>
          </tr>
          <tr><td colspan="5" class="nav"><?= $page_navigation ?></td></tr>
        </tbody>
      </table>
    </form>
    </div>
  </div>

  <div id="popular" class="collapsible section">
    <a href="#popular"><h1>IPs Populares</h1></a>
    <div class="inside">

      <table class="admin options">
        <thead>
          <tr>
            <th style="width:35%;"><h2>Último IP</h2></th><th style="text-align: right; width:15%;"><h2>Total</h2><th><h2>Utilizadores</h2></th>
          </tr>
        </thead>
        <tbody>
        <? foreach($addresses as $a): ?>
          <tr title="<?= $a['playernames'] ?>">
            <td><a href="/admin?ipaddress=<?= $a['lastip'] ?>"><?= $a['lastip'] ?></a></td>
            <td style="text-align: right;"><?= $a['total'] ?></td>
            <td><?= substr($a['playernames'], 0, 16) ?>&hellip;</td>
          </tr>
        <? endforeach; ?>
        </table>

    </div>
  </div>


<div id="register" class="collapsible section">
  <a href="#register"><h1>Registar Utilizador</h1></a>
  <div class="inside">
    <form name="manage_users" action="/admin/register" method="POST" autocomplete="off">
      <table class="form">
        <tr>
          <th><h2>Username</h2></th>
          <td><input type="text" name="playername" placeholder="username"></td>
        </tr>
        <tr>
          <th><h2>Email</h2></th>
          <td><input type="text" name="email" placeholder="email"></td>
        </tr>
        <tr>
          <td colspan="2" class="center">
            <input type="submit" value="OK" />        
            <input type="hidden" name="xsrf_token" value="<?= getXSRFToken() ?>" />
          </td>
        </tr>
      </table>
    </form>
  </div>
</div>



</div>
</body>
</html>
