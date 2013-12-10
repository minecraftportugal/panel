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

 
  <div id="accounts" class="collapsible section default">
    <a href="#accounts"><h1>Gerir Utilizadores (<?= $total ?>)</h1></a>
    <div class="inside">
    <form name="manage_users_filters" action="/admin" method="GET" autocomplete="off">
      <table class="admin options">
        <thead>
          <tr>
            <th class="center" style="width:25%;"><h2>Nome</h2></th>
            <td><input type="text" name="playername" placeholder="steve" value="<?= $playername ?>"></td>
          </tr>
          <tr>
            <th class="center"><h2>End. Email</h2></th>
            <td><input type="text" name="emailaddress" placeholder="mail@minecraft.pt" value="<?= $emailaddress ?>"></td>
          </tr>
          <tr>
            <th class="center"><h2>End. IP</h2></th>
            <td><input type="text" name="ipaddress" placeholder="192.168.0.1" value="<?= $ipaddress ?>"></td>
          </tr>
          <tr>
            <th class="center"><h2>Data Login</h2></th>
            <td><input type="date" name="login_date_begin" value="<?= $login_date_begin ?>"> <span title="Apenas serão mostradas contas onde houve um login após esta data">(Após)</span></td>
          </tr>
          <tr>
            <td></td>
            <td><input type="date" name="login_date_end" value="<?= $login_date_end ?>"> <span title="Apenas serão mostradas contas onde houve um login até esta data">(Até)</span></td>
          </tr>
          <tr>
            <th class="center"><h2>Data Registo</h2></th>
            <td><input type="date" name="register_date_begin" value="<?= $register_date_begin ?>"> <span title="Apenas serão mostradas contas registadas após esta data">(Após)</span></td>
          </tr>
          <tr>
            <td></td>
            <td><input type="date" name="register_date_end" value="<?= $register_date_end ?>"> <span title="Apenas serão mostradas registadas até esta data">(Até)</span></td>
          </tr>
          <tr>
            <th class="center"><h2>Critérios</h2></th>
            <td>
              <input id="nologin" type="checkbox" name="nologin" value="1" <?= $nologin == 1 ? 'checked="checked"' : '' ?> />
              <label class="checkbox" for="nologin">nunca fez login</label>
            </td>
          </tr>
          <tr>
            <td></td>
            <td>
              <input id="inactive" type="checkbox" name="inactive" value="1" <?= $inactive == 1 ? 'checked="checked"' : '' ?> />
              <label class="checkbox" for="inactive">inactivo</label>
            </td>
          </tr>
          <tr>
            <td></td>
            <td>
              <input id="admin" type="checkbox" name="admin" value="1" <?= $admin == 1 ? 'checked="checked"' : '' ?> />
              <label class="checkbox" for="admin">admin</label>
            </td>
          </tr>
          <tr>
            <td></td>
            <td>
              <input id="operator" type="checkbox" name="operator" value="1" <?= $operator == 1 ? 'checked="checked"' : '' ?> />
              <label class="checkbox" for="operator">operador</label>
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
            <td colspan="2" class="center">
              <input type="submit" value="pesquisa" />
              <input type="reset" value="reset" />
            </td>
          </tr>
        </thead>
      </table>
    </form>
    <div class="meh">
    <form name="manage_users" action="/admin/configure" method="POST" autocomplete="off">
      <table class="admin">
        <thead>
          <tr>
            <th class="cella"><h2 title="Player Name">Player<h2></th>
            <th class="cellb"><h2 title="Ultimo IP (não actualizado se entrar não registado/logado)">Ultimo IP</h2></th>
            <th class="cellc"><h2 title="Administrador">@</h2></th>
            <th class="cellc"><h2 title="Conta Activa"><a id="select-all-active" href="#">A</a></h2></th>
            <th class="cellc"><h2 title="APAGAR A CONTA!"><a id="select-all-delete" href="#">X</a></h2></th>
            <th class="celld"></th>
          </tr>
        </thead>
        <tbody>
        <? foreach((array)$userlist as $r): ?>
        <? $a = getLastSession($r["id"]); ?>
          <tr>
            <td class="shortcell cella">
              <a data-dynmap-gotoplayer="<?= $r['playername'] ?>"
                 data-online="<?= in_array($r['playername'], $flatOnlinePlayers) ? 'true' : 'false' ?>"
                 class="button-padded"
                 href="/profile?id=<?= $r['id'] ?>"
                 title="<?= $r["email"] ?>">
                <? $head_url = "http://s3.amazonaws.com/MinecraftSkins/".$r['playername'].".png"; ?>
                <span class="stevehead">
                  <img class="pixels" src="/images/steve.png" data-src="<?= $head_url ?>" alt="Skin" />
                </span>
                <span class="name-label pull-left"><?= $r["playername"] ?></span>
                <span class="online pull-left" title="O jogador está online!"></span>
              </a>
            </td>
            
            <td class="shortcell cellb">
              <a href="/admin?ipaddress=<?= $r["lastloginip"] != NULL ? $r["lastloginip"] : $r["registerip"] ?>" title="<?= $r["lastlogindate"] ? $r["lastlogindate"] : $r["registerdate"] . "*" ?>">
                <span class="pull-left"><?= $r["lastloginip"] != NULL ? $r["lastloginip"] : "<i>".$r["registerip"]."</i>" ?></span>
              </a>
            </td>
            <td class="cellc center">
              <input class="gridy fakecheckbox" type="checkbox" <?= $r["admin"] == 1 ? 'checked="checked"' : '' ?> />
              <input name="admin[<?= $r["id"] ?>]" value="<?= $r["admin"] ?>" type="hidden" />
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
      <table>
        <tbody>
          <tr>
            <td class="center">
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
            <td><?= substr($a['playernames'], 0, 21) ?>&hellip;</td>
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
