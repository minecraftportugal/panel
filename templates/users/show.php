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
    <script type="text/javascript" src="/scripts/Three.js"></script>
    <script type="text/javascript" src="/scripts/profile.js"></script>
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

  <div id="player" class="collapsible section default">
    <a href="#player">
      <h1>
          <span style="float: left; height: 20px; padding-top: 4px;" class="playername">
            <span class="stevehead">
              <img class="pixels" src="/images/steve.png" data-src="<?= $profileSkin ?>" alt="Skin" />
            </span>
            <?= $profile["playername"] ?>
          </span>
          
          <span class="badges">
            
              <? if ($badges['member'] == 1): ?>
                <span title="Membro" class="badge badge-member"></span>
              <? endif; ?>
              <? if ($badges['admin'] == 1): ?>
                <span title="Administrador do Servidor" class="badge badge-administrator"></span>
              <? endif; ?>
              <? if ($badges['operator'] == 1): ?>
                <span title="Operador do Servidor" class="badge badge-operator"></span>
              <? endif; ?>
              <? if ($badges['donor'] == 1): ?>
                <span title="Dador" class="badge badge-donor"></span>
              <? endif; ?>
              <? if ($badges['contributor'] == 1): ?>
                <span title="Contribuidor" class="badge badge-contributor"></span>
              <? endif; ?>
              <? if ($badges['premium'] == 1): ?>
                <span title="Premium" class="badge badge-premium"></span>
              <? endif; ?>
              <? if ($badges['active'] != 1): ?>
                <span title="Conta Desactivada" class="badge badge-deactivated"></span>
              <? endif; ?>

          </span>
      </h1>
    </a>

    <div class="inside">  
      <div id="skin">
        <img id="skinDisplay" style="display:none" src="<?= $profileSkin ?>" data-playerid="<?= $profileId ?>" alt="Skin" />
      </div>

      <table class="pretty">
        <tbody>
          <tr>
            <td colspan="2">
              <div class="health">
              <? for ($i = 0, $h = ($inquisitor) ? $inquisitor['health'] : 0; $i < 10; $i++, $h-=2): ?>
                <span class="<?= ($h > 1)? "full" : (($h <= 0)? "empty" : "half") ?>"></span>
              <? endfor; ?>
              </div>
              <div class="hunger">
              <? for ($i = 0, $f = $h = ($inquisitor) ? $inquisitor['foodLevel'] : 0; $i < 10; $i++, $f-=2): ?>
                <span class="<?= ($f > 1)? "full" : (($f <= 0)? "empty" : "half") ?>"></span>
              <? endfor; ?>
            </td>
          </tr>

          <? if ($inquisitor): ?>
          <tr><th>Status</th><td class="<?= $inquisitor['online'] == 1 ? 'online' : 'offline' ?>"><?= $inquisitor['online'] == 1 ? 'online' : 'offline' ?></td></tr>
          <? endif; ?>
      
          <? if ($own): ?> 
          <tr>
            <th>Email</th><td><?= $profile['email'] ?></td>
          </tr>
          <? endif; ?>

          <tr>
            <th>Registo</th>
            <td><?= $profile['registerdate'] ?></td>
          </tr>

          <? if ($profile['logintime'] != null): ?>
          <tr>
            <th>Activo</th>
            <td><?= $profile['logintime'] ?></td>
          </tr>
          <? endif; ?>

        </tbody>
      </table>
    </div>
  </div>

  <? if ($inquisitor) : ?>
  <div id="playerstats" class="collapsible section">
    <a href="#playerstats">
      <h1>Estatísticas</h1>
    </a>
    <div class="inside">
      <table class="pretty">
        <tbody>
          <tr><th>Level</th><td><?= $inquisitor['level'] ?></td></tr>
          <tr><th>XP</th><td><?= $inquisitor['totalExperience'] ?>/<?= $inquisitor['lifetimeExperience'] ?></td></tr>
          <tr><th>Tempo total</th><td> <?= secs_to_h($inquisitor['totalTime']) ?></td></tr>
          <tr><th>Ultima sessão</th><td> <?= secs_to_h($inquisitor['sessionTime']) ?></td></tr>
          <tr><th>KMs Percorridos</th><td> <?= round($inquisitor['totalDistanceTraveled']/1000,2) ?> km</td></tr>
          <tr><th>Modo de Jogo</th><td> <?= $inquisitor['gameMode'] ?></td></tr>
          <tr><th>World</th><td> <?= $inquisitor['world'] ?></td></tr>
          <tr><th colspan="2">Entradas</th></tr>
          <tr><th>Total</th><td> <?= $inquisitor['joins'] ?></td></tr>
          <tr><th>Primeira</th><td> <?= $inquisitor['firstJoin'] ?></td></tr>
          <tr><th>Última</th><td> <?= $inquisitor['lastJoin'] ?></td></tr>
        <? if ($inquisitor['kicks'] > 0): ?>
          <tr><th colspan="2">Kicks</th></tr>
          <tr><th>Total</th><td> <?= $inquisitor['kicks'] ?></td></tr>
          <tr><th>Ultimo</th><td> <?= $inquisitor['lastKick'] ?></td></tr>
        <? endif; ?>
        <? if ($inquisitor['quits'] > 0): ?>
          <tr><th colspan="2">Quits</th></tr>
          <tr><th>Total</th><td> <?= $inquisitor['quits'] ?></td></tr>
          <tr><th>Ultimo</th><td> <?= $inquisitor['lastQuit'] ?></td></tr>
        <? endif; ?>
          <tr><th colspan="2">Blocos</th></tr>
          <tr><th>Destruidos</th><td> <?= $inquisitor['totalBlocksBroken'] ?></td></tr>
          <tr><th>Colocados</th><td> <?= $inquisitor['totalBlocksPlaced'] ?></td></tr>
          <tr><th colspan="2">Mortes</th></tr>
          <tr><th>Morreu</th><td> <?= $inquisitor['deaths'] ?></td></tr>
        <? if ($inquisitor['totalPlayersKilled'] > 0): ?>
          <tr><th>Matou</th><td> <?= $inquisitor['totalPlayersKilled'] ?></td></tr>
          <tr><th>Último Morto</th><td> <?= $inquisitor['lastPlayerKilled'] ?></td></tr>
          <tr><th>Em</th><td> <?= $inquisitor['lastPlayerKill'] ?></td></tr>
        <? endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  
  <div id="playerinventory" class="collapsible section">
    <a href="#playerinventory">
      <h1>Inventário</h1>
    </a>
    <div class="inside">
      <div class="inventory">
        <table class="pretty">
          <tbody>
          <? for ($j = 0; $j < 4; $j++): ?>
            <tr class="line<?= $j ?>">
            <? for ($i = 0; $i < 9; $i++): ?>
            <td>
            <? $pi = $playerinv[$i + 9 * $j]; ?>
              <span class="item" data-item="<?= $pi['itemdata'] ?>" data-enchantments="<?= $pi['enchantments'] ?>"></span>
            </td>
            <? endfor; ?>
            </tr>
          <? endfor; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <? endif; ?>

  <? if (($own and $total_drops > 0) or $admin): ?>
  <div id="itemdrops" class="collapsible section">
    <a href="#itemdrops" ><h1>Drops</h1></a>
    <div class="inside">
      <div class="section">
      <? if ($total_drops > 0): ?>
        <form name="delete_drops" action="/users/delete_drops" method="POST" autocomplete="off">
        <table class="admin drops alt-rows">
          <thead>
            <tr>
              <th class="cella" style="width: 24px;"><h2 title="Item">Item</h2></th>
              <th class="cella" style="width: 50%;"></th>
              <th class="cella" style="width: 50%;"><h2 title="Data Dropped/Recebido"><i>Dropped</i>/Recebido</h2></th>
            <? if ($admin): ?>
              <th class="cellz"><h2 id="select-all-delete-drops">X</h2></th>
            <? endif; ?>
            </tr>
          </thead>
          <tbody>
          <? foreach((array)$itemdrops as $i): ?>
            <tr>
              <td class="cella" style="width: 30px;" title="Item ID #<?= $i['itemdrop'] ?>">
                <span class="item" data-item="<?= $i['itemdrop'] ?> 0 <?= $i['itemnumber']?>" data-enchantments=""></span>
              </td>
              <td class="cella" title="Item ID #<?= $i['itemdrop'] ?>">
                <span class="itemname" data-item="<?= $i['itemdrop'] ?>" data-enchantments=""></span>
              </td>
            <? if (isset($i['takendate'])): ?>
              <td class="cella" title="Recebido a <?= $i['dropdate'] ?>"><?= $i['takendate'] ?></td>
            <? else: ?>
              <td class="cella"><i><?= $i['dropdate'] ?></i></td>
            <? endif; ?>
            <? if ($admin): ?>
              <td class="cellz">
                <input class="check-delete-drops" name="delete[]" value="<?= $i["id"] ?>" type="checkbox" />
              </td>
            <? endif; ?>
            </tr>
          <? endforeach; ?>
         </tbody>
        </table>
        <table>
          <tr><td colspan="3" class="nav"><?= $drops_page_navigation ?></td></tr>
        </table>
        <? if ($admin): ?>
        <table>
          <tr>
            <td colspan="4" class="center">
              <input type="submit" value="apagar" />
              <input type="hidden" name="xsrf_token" value="<?= getXSRFToken() ?>" />
              <input type="hidden" name="id" value="<?= $profile['id'] ?>" />
            </td>
          </tr>
        </table>
        <? endif; ?>
        </form>
      <? endif; ?>
        <? if ($admin): ?>
        <h2 <?= ($total_drops > 0) ? 'class="pushu"' : '' ?>>Associar Drop</h2>
        <form name="drop_items" action="/users/drop_items" method="POST" autocomplete="off">
          <table class="form">
            <tr>
              <td class="w25"><label for="itemid"><h2>Item ID</h2></label></td>
              <td class="w25"><input id="itemid" name="itemid" type="number" min="1" value="1" /></td>
              <td class="w25"><label for="itemqt"><h2>Qtd.</h2></label></td>
              <td class="w25"><input id="itemqt" name="itemqt" type="number" min="1" max="64" value="1" /></td>
            </tr>
            <tr>
              <td colspan="4" class="center">
                <input type="submit" value="drop" />
                <input type="hidden" name="xsrf_token" value="<?= getXSRFToken() ?>" />
                <input type="hidden" name="id" value="<?= $profile['id'] ?>" />
              </td>
            </tr>
          </table>
        </form>
        <? endif; ?>
       </div>
    </div>
  </div>
  <? endif; ?> 

  <? if ($admin): ?>
  <div id="resetpw" class="collapsible section">
    <a href="#resetpw" ><h1>Reenviar Password</h1></a>
    <div class="inside">
      <div class="section">
        <form name="reset_password" action="/reset_password" method="POST" autocomplete="off">
          <table class="form">
            <tr>
              <td><h2>Reenviar Password</h2></td>
              <td>
                <input id="reset_pass_check" type="checkbox" name="reset_pass_check" value="1" />
                <label class="checkbox" for="reset_pass_check">Confirmar</label>
                <input type="hidden" name="id" value="<?= $profile['id'] ?>" />
              </td>
            </tr>
            <tr>
              <td colspan="2"  class="center">
                <input type="submit" value="OK" />
                <input type="hidden" name="xsrf_token" value="<?= getXSRFToken() ?>" />
              </td>
            </tr>
          </table>
        </form>
       </div>
    </div>
  </div>

  <div id="adminactions" class="collapsible section">
    <a href="#adminactions">
      <h1>Gestão</h1>
    </a>
    <div class="inside">
      <form name="manage_users" action="/users/configure" method="POST" autocomplete="off">
      <table class="form">
        <tbody>
          <tr><th><h2>Reg. IP</h2></th><td><a href="/admin?ipaddress=<?= $profile["registerip"] ?>"><?= $profile['registerip'] ?></a></td></tr>
          <? if (isset($profile['lastloginip'])): ?>
            <tr><th><h2>Login IP</h2></th><td><a href="/admin?ipaddress=<?= $profile["lastloginip"] ?>"><?= $profile['lastloginip'] ?></a></td></tr>
          <? endif; ?>
            <tr><th><h2>Sessão</h2></th><td><?= $profile['logintime'] != "" ? $profile['logintime'] : "Sem Sessão" ?></td></tr>
            <tr><th><h2>Email</h2></th><td><a href="/admin?emailaddress=<?= $profile["email"] ?>"><?= $profile['email'] ?></a></td></tr>
          <? if ($inquisitor): ?>
            <tr><th><h2>Inq. IP</h2></th><td><a href="/admin?ipaddress=<?= $inquisitor['address'] ?>"><?= $inquisitor['address'] ?></a></td></tr>
            <tr><th><h2>Servidor</h2></th><td><?= $inquisitor['server'] ?></td></tr>
            <tr><th><h2>Entrada</h2></th><td><?= date('M d H:i Y', strtotime($inquisitor['lastJoin'])) ?></td></tr>
            <tr><th><h2 title="">Blocos/Hr</h2></th><td><?= $total ?>/<?= $hours ?> (<?= round($total/$hours, 2) ?>)</td></tr>
            <tr><th><h2 title="">Dim/Hr</h2></th><td><?= $diamond ?>/<?= $hours ?> (<?= round($diamond/$hours, 2) ?>)</td></tr>
            <? if ($total > 0): ?>
              <tr><th><h2 title="">Dim/Blocos</h2></th><td><?= $diamond ?>/<?= $total ?> (<?= round($diamond/$total, 2) ?>)</td></tr>
            <? endif; ?>
          <? endif; ?>
            <tr><th rowspan="6"><h2>Atributos</h2></th>
            <td>
              <input id="chk_admin" type="checkbox" name="admin" value="1" <?= $profile['admin'] == 1 ? 'checked="checked"' : '' ?> />
              <label class="checkbox" for="chk_admin">administrador
            </td>
          </tr>
          <tr>
            <td>
              <input id="chk_operator" type="checkbox" name="operator" value="1" <?= $profile['operator'] == 1 ? 'checked="checked"' : '' ?> />
              <label class="checkbox" for="chk_operator">operador
            </td>
          </tr>
          <tr>
            <td>
              <input id="chk_active" type="checkbox" name="active" value="1" <?= $profile['active'] == 1 ? 'checked="checked"' : '' ?> />
              <label class="checkbox" for="chk_active">activo
            </td>
          </tr>
          <tr>
            <td>
              <input id="chk_contributor" type="checkbox" name="contributor" value="1" <?= $badges['contributor'] == 1 ? 'checked="checked"' : '' ?> />
              <label class="checkbox" for="chk_contributor">contribuidor
            </td>
          </tr>
          <tr>
            <td>
              <input id="chk_donor" type="checkbox" name="donor" value="1" <?= $badges['donor'] == 1 ? 'checked="checked"' : '' ?> />
              <label class="checkbox" for="chk_donor">dador
            </td>
          </tr>
          <tr>
            <td>
              <input id="chk_delete" type="checkbox" name="delete" value="1" />
              <label class="checkbox" for="chk_delete">apagar
            </td>
          </tr>
          <tr class="padup" >
            <td colspan="2" class="center">
              <input type="hidden" name="xsrf_token" value="<?= getXSRFToken() ?>" />
              <input type="hidden" name="id" value="<?= $profile['id'] ?>" />
              <input type="submit" value="OK" />
            </td>
          </tr>
        </tbody>
      </table>
      </form>
    </div>
  </div>
  <? endif; ?>

  <? if ($own): ?>
  <div id="irc" class="collapsible section">
    <a href="#irc" ><h1>Configurar  IRC</h1></a>
    <div class="inside">
      <div class="section">
        <form name="irc_settings" action="/users/update_irc" method="POST" autocomplete="off">
          <table class="form">
            <tr>
              <th><label for="irc_nickname"><h2>Nickname IRC</h2></label></th>
              <td><input id="irc_nickname" type="text" name="irc_nickname" value="<?= $profile['ircnickname'] ?>" placeholder="irc nickname"></td>
            </tr>
            <tr>
              <th><label for="irc_password"><h2>Password Nickname</h2></label></th>
              <td><input id="irc_password" type="password" name="irc_password" value="<?= $profile['ircpassword'] ?>" placeholder="nickserv password"></td>
            </tr>
            <tr>
              <th><label><h2>Opções</h2></label></th>
              <td>
                <input id="irc_auto" type="checkbox" name="irc_auto" value="1" <?= $profile['ircauto'] == 1 ? 'checked="checked"' : '' ?> />
                <label class="checkbox" for="irc_auto">ligação automática</label>
              </td>
            </tr>
            <tr class="padup" >
              <td colspan="2" class="center">
                <input type="hidden" name="xsrf_token" value="<?= getXSRFToken() ?>" />
                <input type="submit" value="OK" />
              </td>
            </tr>
          </table>
        </form>
      </div>
    </div>
  </div>

  <div id="changepw" class="collapsible section">
    <a href="#changepw" ><h1>Alterar Password</h1></a>
    <div class="inside">
      <div class="section">
        <form name="change_password" action="/users/update_password" method="POST" autocomplete="off">
          <table class="form">
            <tr>
              <th><label for="current_password"><h2>Password Actual</h2></label></th>
              <td><input id="current_password" type="password" name="password" placeholder="password actual"></td>
            </tr>
            <tr>
              <th><label for="new_password"><h2>Nova Password</h2></label></th>
              <td><input id="new_password" type="password" name="new_password" placeholder="nova password"></td>
            </tr>
            <tr>
              <th><label for="confirm_password"><h2>Confirmar Password</h2></label></th>
              <td><input id="confirm_password" type="password" name="confirm_password" placeholder="confirmar password"></td>
            </tr>
            <tr class="padup">
              <td colspan="2" class="center">
                <input type="hidden" name="xsrf_token" value="<?= getXSRFToken() ?>" />
                <input type="submit" value="OK" />
              </td>
            </tr>
        </form>
        </div>
    </div>
  </div>
<? endif; ?>  



  </div>
</body>
</html>
