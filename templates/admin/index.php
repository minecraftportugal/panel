<!DOCTYPE html>
<html>
<head>
    <meta charset=utf-8 />
    <title>news</title>
    
    <link rel="stylesheet" type="text/css" media="screen" href="/styles/reset.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="/styles/sidebar.css" />

    <script type="text/javascript" src="/scripts/jquery.js"></script>
    <script type="text/javascript" src="/scripts/frames.js"></script>
    <script type="text/javascript" src="/scripts/steve.js"></script>
    <script type="text/javascript" src="/scripts/sidebar.js"></script>
    <script type="text/javascript" src="/scripts/admin.js"></script>
    <script type="text/javascript" src="/scripts/sop.js"></script>
    <script type="text/javascript" src="/scripts/items.js"></script>

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
    <a href="#accounts"><h1>Utilizadores (<?= $total_accounts ?>)</h1></a>
    <div class="inside">
    <form name="manage_users_filters" action="/admin#accounts" method="GET" autocomplete="off">
      <table class="admin options">
        <thead>
          <tr>
            <th class="center" style="width:35%;"><h2>Nome</h2></th>
            <td><input type="text" name="playername" placeholder="steve" value="<?= $playername ?>"></td>
          </tr>
          <tr>
            <th class="center"><h2>Endereço de Email</h2></th>
            <td><input type="text" name="emailaddress" placeholder="mail@minecraft.pt" value="<?= $emailaddress ?>"></td>
          </tr>
          <tr>
            <th class="center"><h2>Endereço IP</h2></th>
            <td><input type="text" name="ipaddress" placeholder="192.168.0.1" value="<?= $ipaddress ?>"></td>
          </tr>
          <tr>
            <th class="center"><h2>Data de Login</h2></th>
            <td><input type="date" name="login_date_begin" value="<?= $login_date_begin ?>"> <span title="Apenas serão mostradas contas onde houve um login após esta data">(Após)</span></td>
          </tr>
          <tr>
            <td></td>
            <td><input type="date" name="login_date_end" value="<?= $login_date_end ?>"> <span title="Apenas serão mostradas contas onde houve um login até esta data">(Até)</span></td>
          </tr>
          <tr>
            <th class="center"><h2>Data de Registo</h2></th>
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
            <td></td>
            <td>
              <input id="isonline" type="checkbox" name="online" value="1" <?= $online == 1 ? 'checked="checked"' : '' ?> />
              <label class="checkbox" for="isonline">online</label>
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
      <table class="admin alt-rows">
        <thead>
          <tr>
            <th class="cella"><h2 title="Nome do Jogador">Nome<h2></th>
            <th class="cellb"><h2 title="Ultimo IP (não actualizado se entrar não registado/logado)">Ultimo IP</h2></th>
            <th class="cellc"><h2 title="Administrador">@</h2></th>
            <th class="cellc"><h2 id="select-all-active" title="Conta Activa">A</h2></th>
            <th class="cellc"><h2 id="select-all-delete" title="APAGAR A CONTA!">X</h2></th>
            <th class="celld"></th>
          </tr>
        </thead>
        <tbody>
        <? foreach((array)$accounts as $r): ?>
        <? $a = getLastSession($r["id"]); ?>
          <tr>
            <td class="shortcell cella">
              <a data-online="<?= in_array($r['playername'], $flatOnlinePlayers) ? 'true' : 'false' ?>"
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
              <input class="gridy fakecheckbox fake-active" type="checkbox" <?= $r["active"] == 1 ? 'checked="checked"' : '' ?> />
              <input name="active[<?= $r["id"] ?>]" value="<?= $r["active"] ?>" type="hidden" />
            </td>
            <td class="cellc center">
              <input class="gridy check-delete" name="delete[]" value="<?= $r["id"] ?>" type="checkbox" />
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
          <tr><td colspan="5" class="nav"><?= $accounts_page_navigation ?></td></tr>
        </tbody>
      </table>
    </form>
    </div>
  </div>

  <div id="sessions" class="collapsible section">
    <a href="#sessions"><h1>Sessões (<?= $total_sessions ?>)</h1></a>
    <div class="inside">
    <form name="manage_sessions_filters" action="/admin#sessions" method="GET" autocomplete="off">
      <table class="admin options">
        <thead>
          <tr>
            <th class="center" style="width:35%;"><h2>Nome</h2></th>
            <td><input type="text" name="session_playername" placeholder="steve" value="<?= $session_playername ?>"></td>
          </tr>
          <tr>
            <th class="center"><h2>Endereço IP</h2></th>
            <td><input type="text" name="session_ipaddress" placeholder="192.168.0.1" value="<?= $session_ipaddress ?>"></td>
          </tr>
          <tr>
            <th class="center"><h2>Data da Sessão</h2></th>
            <td><input type="date" name="session_date_begin" value="<?= $session_date_begin ?>"> <span title="Apenas serão mostradas sessões após esta data">(Após)</span></td>
          </tr>
          <tr>
            <td></td>
            <td><input type="date" name="session_date_end" value="<?= $session_date_end ?>"> <span title="Apenas serão mostradas sessões até esta data">(Até)</span></td>
          </tr>
          <tr>
            <th class="center"><h2>Critérios</h2></th>
            <td>
              <input id="session_valid" type="checkbox" name="session_valid" value="1" <?= $session_valid == 1 ? 'checked="checked"' : '' ?> />
              <label class="checkbox" for="session_valid" title="sessão não expirada">sessão válida</label>
            </td>
          </tr>
          <tr>
            <td></td>
            <td>
              <input id="session_invalid" type="checkbox" name="session_invalid" value="1" <?= $session_invalid == 1 ? 'checked="checked"' : '' ?> />
              <label class="checkbox" for="session_invalid" title="sessão expirada">sessão inválida</label>
            </td>
          </tr>
          <tr>
            <td></td>
            <td>
              <input id="session_online" type="checkbox" name="session_online" value="1" <?= $session_online == 1 ? 'checked="checked"' : '' ?> />
              <label class="checkbox" for="session_online">online</label>
            </td>
          </tr>
          <tr>
            <td></td>
            <td>
              <input id="session_web" type="checkbox" name="session_web" value="1" <?= $session_web == 1 ? 'checked="checked"' : '' ?> />
              <label class="checkbox" for="session_web">sessão web</label>
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
    <form name="manage_sessions" action="/sessions/configure" method="POST" autocomplete="off">
      <table class="admin alt-rows2">
        <thead>
          <tr>
            <th class="cella" style="width: 90px;"><h2 title="Nome do Jogador">Nome<h2></th>
            <th class="cella" style="width: 80px;"><h2 title="Endereço IP">IP</h2></th>
            <th rowspan="2" class="cellz"><h2 id="select-all-delete-sessions" title="Apagar Sessão!">X</h2></th>
          </tr>
          <tr>
            <th class="cella"><h2 title="Data">Data Sessão<h2></th>
            <th class="cella"><h2 title="Tipo">Tipo Sessão</h2></th>
          </tr>
        </thead>
        <tbody>
        <? foreach((array)$sessions as $r): ?>
        
          <tr>
            <td class="shortcell cella overflowh">
              <a data-online="<?= in_array($r['playername'], $flatOnlinePlayers) ? 'true' : 'false' ?>"
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
        
            <td class="shortcell cella overflowh">
              <a href="/admin?ipaddress=<?= $r["lastloginip"] ?>" class="pull-left" title="<?= $r["lastloginip"] ?>"><?= $r["lastloginip"] ?><span>
            </td>

            <td rowspan="2" class="cellz">
              <input class="check-delete-sessions" name="delete[]" value="<?= $r["id"] ?>" type="checkbox" />
            </td>
        </tr>
        <tr>
            <td class="shortcell cella overflowh">
              <span class="pull-left" title="<?= $r["logintimef"] ?>" style="<?= $r["valid"] == 0 ? "text-decoration:line-through;" : "" ?>"><?= $r["logintimef"] ?></span>
            </td>
            <td class="shortcell cella overflowh">
              <span class="pull-left" title="<?= $r["websession"] == 1 ? "sessão iniciada no site" : "sessão iniciada no jogo" ?>">
                 <?= $r["websession"] == 1 ? "Web" : "Minecraft" ?>
              </span>
            </td>
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
          <tr><td colspan="5" class="nav"><?= $sessions_page_navigation ?></td></tr>
        </tbody>
      </table>
    </form>
    </div>
  </div>

  <div id="drops" class="collapsible section">
    <a href="#drops"><h1>Drops (<?= $total_drops ?>)</h1></a>
    <div class="inside">
    <form name="manage_drops_filters" action="/admin#drops" method="GET" autocomplete="off">
      <table class="admin options">
          <tr>
            <th class="center" style="width:35%;"><h2>Critérios</h2></th>
            <td>
              <input id="drops_undelivered" type="checkbox" name="drops_undelivered" value="1" <?= $drops_undelivered == 1 ? 'checked="checked"' : '' ?> />
              <label class="checkbox" for="drops_undelivered" title="drop não entregue">não entregue</label>
            </td>
          </tr>
          <tr>
            <td></td>
            <td>
              <input id="drops_delivered" type="checkbox" name="drops_delivered" value="1" <?= $drops_delivered == 1 ? 'checked="checked"' : '' ?> />
              <label class="checkbox" for="drops_delivered" title="drop entregue">entregue</label>
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
    <form name="manage_users" action="/admin/delete_drops" method="POST" autocomplete="off">
      <table class="admin alt-rows">
        <thead>
          <tr>
            <th class="cella" style="width: 30px;"><h2 title="Item">Item</h2></th>
            <th class="cella" style="width: 50%;"><h2 title="Nome do Jogador">Nome<h2></th>
            <th class="cella" style="width: 50%;"><h2 title="Data Dropped/Recebido"><i>Dropped</i>/Recebido</h2></th>
            <th class="cellz"><h2 id="select-all-delete-drops" title="Apagar Drops!">X</h2></th>
          </tr>
        </thead>
        <tbody>
        <? foreach((array)$drops as $r): ?>
          <tr>
            <td class="cella" style="width: 30px;" title="Item ID #<?= $r['itemdrop'] ?>">
              <span class="item" data-item="<?= $r['itemdrop'] ?> 0 <?= $r['itemnumber']?>" data-enchantments=""></span>
            </td>
            <td class="shortcell cella">
              <a data-online="<?= in_array($r['playername'], $flatOnlinePlayers) ? 'true' : 'false' ?>"
                 class="button-padded"
                 href="/profile?id=<?= $r['accountid'] ?>"
                 title="<?= $r["email"] ?>">
                <? $head_url = "http://s3.amazonaws.com/MinecraftSkins/".$r['playername'].".png"; ?>
                <span class="stevehead">
                  <img class="pixels" src="/images/steve.png" data-src="<?= $head_url ?>" alt="Skin" />
                </span>
                <span class="name-label pull-left"><?= $r["playername"] ?></span>
                <span class="online pull-left" title="O jogador está online!"></span>
              </a>
            </td>
            <? if (isset($r['takendate'])): ?>
              <td class="cella" title="Dropped a <?= $r['dropdate'] ?>"><span class="pull-left"><?= $r['takendate'] ?></span></td>
            <? else: ?>
              <td class="cella"><span class="pull-left"><i><?= $r['dropdate'] ?></i></span></td>
            <? endif; ?>
            <td class="cellc center">
              <input class="gridy check-delete-drops" name="delete[]" value="<?= $r["id"] ?>" type="checkbox" />
            </td>
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
          <tr><td colspan="5" class="nav"><?= $drops_page_navigation ?></td></tr>
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
