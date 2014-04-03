<script type="text/javascript" src="/scripts/skin3d.js"></script>
<link rel="stylesheet" href="/styles/page-presentation-profile.css" media="screen" type="text/css">

<div id="widget-show-<?= $player['playername'] ?>">

    <div class="layout-row">

        <div class="layout-col layout-col-1">
            <div class="layout-col-title">
                <span class="pull-left">
                  <?= \helpers\minotar\MinotarHelper::head($player['playername'], 16, 3) ?>
                </span>
                <span class="pull-left">
                  <?= $player['playername'] ?>
                </span>
            </div>

            <div class="layout-col-sec">
                <div>

                </div>
            </div>

            <div class="text-center layout-col-sec">
                <? require(__DIR__."/../partials/skin3d.php"); ?>
            </div>

            <div class="text-center layout-col-sec">
                <? require(__DIR__."/../partials/badges.php"); ?>
            </div>

            <div class="layout-col-sec">
                Registo: <?= $player['registerdate'] ?>

                <? if ($player['lastlogindate'] != null): ?>
                    Activo: <?= $player['lastlogindate'] ?>
                <? endif; ?>

            </div>

        </div>

        <div class="layout-col layout-col-2 iframe">
            <div class="layout-col-title">
                <h1>Posição</h1>
            </div>

            <?= $v_dynmap_widget ?>

        </div>

        <div class="layout-col layout-col-3">
            <div class="layout-col-title">
                <h1>Posição</h1>
            </div>

            <div class="widget-dynmap">

            </div>

            <pre> <?= var_dump($player); ?> </pre>

        </div>

    </div>


</div>















<div class="widget-show" style="display: none;">

<div class="health">
    <? for ($i = 0, $h = (is_array($player['health'])) ? $player['health'] : 0; $i < 10; $i++, $h-=2): ?>
        <span class="<?= ($h > 1)? "full" : (($h <= 0)? "empty" : "half") ?>"></span>
    <? endfor; ?>
</div>

<div class="hunger">
    <? for ($i = 0, $f = $h = ($player) ? $player['foodLevel'] : 0; $i < 10; $i++, $f-=2): ?>
        <span class="<?= ($f > 1)? "full" : (($f <= 0)? "empty" : "half") ?>"></span>
    <? endfor; ?>
</div>

  <div id="player" class="section default">

          <span style="float: left; height: 20px; padding-top: 4px;" class="playername">
            <span class="stevehead">
              <img class="pixels" src="/images/steve.png" data-src="<?= $playerSkin ?>" alt="Skin" />
            </span>
            <?= $player["playername"] ?>
          </span>
          
          <span class="badges">

                <?
                  $badges = \models\account\AccountModel::badges($player['id']);
                  require(__DIR__."/../partials/badges.php"); 
                ?>

          </span>




    <div class="inside">  



    </div>
  </div>

  <? if ($player) : ?>
  <div id="playerstats" class="section">
    <a href="#playerstats" class="noajax">
      <h1>Estatísticas</h1>
    </a>
    <div class="inside">
      <table class="pretty">
        <tbody>
          <tr><th>Level</th><td><?= $player['level'] ?></td></tr>
          <tr><th>XP</th><td><?= $player['totalExperience'] ?>/<?= $player['lifetimeExperience'] ?></td></tr>
          <tr><th>Tempo total</th><td> <?= secs_to_h($player['totalTime']) ?></td></tr>
          <tr><th>Ultima sessão</th><td> <?= secs_to_h($player['sessionTime']) ?></td></tr>
          <tr><th>KMs Percorridos</th><td> <?= round($player['totalDistanceTraveled']/1000,2) ?> km</td></tr>
          <tr><th>Modo de Jogo</th><td> <?= $player['gameMode'] ?></td></tr>
          <tr><th>World</th><td> <?= $player['world'] ?></td></tr>
          <tr><th colspan="2">Entradas</th></tr>
          <tr><th>Total</th><td> <?= $player['joins'] ?></td></tr>
          <tr><th>Primeira</th><td> <?= $player['firstJoin'] ?></td></tr>
          <tr><th>Última</th><td> <?= $player['lastJoin'] ?></td></tr>
        <? if ($player['kicks'] > 0): ?>
          <tr><th colspan="2">Kicks</th></tr>
          <tr><th>Total</th><td> <?= $player['kicks'] ?></td></tr>
          <tr><th>Ultimo</th><td> <?= $player['lastKick'] ?></td></tr>
        <? endif; ?>
        <? if ($player['quits'] > 0): ?>
          <tr><th colspan="2">Quits</th></tr>
          <tr><th>Total</th><td> <?= $player['quits'] ?></td></tr>
          <tr><th>Ultimo</th><td> <?= $player['lastQuit'] ?></td></tr>
        <? endif; ?>
          <tr><th colspan="2">Blocos</th></tr>
          <tr><th>Destruidos</th><td> <?= $player['totalBlocksBroken'] ?></td></tr>
          <tr><th>Colocados</th><td> <?= $player['totalBlocksPlaced'] ?></td></tr>
          <tr><th colspan="2">Mortes</th></tr>
          <tr><th>Morreu</th><td> <?= $player['deaths'] ?></td></tr>
        <? if ($player['totalPlayersKilled'] > 0): ?>
          <tr><th>Matou</th><td> <?= $player['totalPlayersKilled'] ?></td></tr>
          <tr><th>Último Morto</th><td> <?= $player['lastPlayerKilled'] ?></td></tr>
          <tr><th>Em</th><td> <?= $player['lastPlayerKill'] ?></td></tr>
        <? endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  
  <div id="playerinventory" class="section">
    <a href="#playerinventory"  class="noajax">
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
  <div id="itemdrops" class="section">
    <a href="#itemdrops" class="noajax"><h1>Drops</h1></a>
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
                <span class="item" data-item="<?= $i['itemdrop'] ?> <?= $i['itemaux'] ?> <?= $i['itemnumber']?>" data-enchantments=""></span>
              </td>
              <td class="cella" title="Item ID #<?= $i['itemaux'] != 0 ? $i['itemdrop'].":".$i['itemaux'] : $i['itemdrop'] ?>">
                <span style="width: 120px;" class="itemname" data-item="<?= $i['itemdrop'] ?> <?= $i['itemaux'] ?>" data-enchantments=""></span>
              </td>
            <? if (isset($i['takendate'])): ?>
              <td class="cella" title="Dropped a <?= $i['dropdate'] ?> (<?= $i['idledroptime'] ?>)"><?= $i['takendate'] ?></td>
            <? else: ?>
              <td class="cella" title="Não Entregue"><i><?= $i['dropdate'] ?></i></td>
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
              <input type="hidden" name="id" value="<?= $player['id'] ?>" />
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
              <td class="w5"><label for="itemid_sel"><h2>Item</h2></label></td>
              <td class="w100" colspan="6">
                <select id="itemid_sel">
                </select>
              </td>
            </tr>
            <tr>
              <td class="w5"><label for="itemid"><h2>Id</h2></label></td>
              <td class="w5"><input id="itemid" name="itemid" type="number" min="0" value="" /></td>
              <td class="w5"><label for="itemaux"><h2>Aux</h2></label></td>
              <td class="w5"><input id="itemaux" name="itemaux" type="number" min="0" value="" /></td>
              <td class="w5"><label for="itemqt"><h2>Qtd.</h2></label></td>
              <td class="w5"><input id="itemqt" name="itemqt" type="number" min="1" max="64" value="1" /></td>
            </tr>
            <tr>
              <td colspan="6" class="center">
                <input type="submit" value="drop" />
                <input type="hidden" name="xsrf_token" value="<?= getXSRFToken() ?>" />
                <input type="hidden" name="id" value="<?= $player['id'] ?>" />
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
  <div id="resetpw" class="section">
    <a href="#resetpw" class="noajax"><h1>Reenviar Password</h1></a>
    <div class="inside">
      <div class="section">
        <form name="reset_password" action="/reset_password" method="POST" autocomplete="off">
          <table class="form">
            <tr>
              <td><h2>Reenviar Password</h2></td>
              <td>
                <input id="reset_pass_check" type="checkbox" name="reset_pass_check" value="1" />
                <label class="checkbox" for="reset_pass_check">Confirmar</label>
                <input type="hidden" name="id" value="<?= $player['id'] ?>" />
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

  <div id="adminactions" class="section">
    <a href="#adminactions" class="noajax">
      <h1>Gestão</h1>
    </a>
    <div class="inside">
      <form name="manage_users" action="/users/configure" method="POST" autocomplete="off">
      <table class="form">
        <tbody>
          <tr><th><h2>Reg. IP</h2></th><td><a href="/admin/accounts/?ipaddress=<?= $player["registerip"] ?>"><?= $player['registerip'] ?></a></td></tr>
          <? if (isset($player['lastloginip'])): ?>
            <tr><th><h2>Login IP</h2></th><td><a href="/admin/accounts?ipaddress=<?= $player["lastloginip"] ?>"><?= $player['lastloginip'] ?></a></td></tr>
          <? endif; ?>
            <tr><th><h2>Sessão</h2></th><td><?= $player['logintime'] != "" ? $player['logintime'] : "Sem Sessão" ?></td></tr>
            <tr><th><h2>Email</h2></th><td><a href="/admin/accounts?emailaddress=<?= $player["email"] ?>"><?= $player['email'] ?></a></td></tr>
          <? if ($player): ?>
            <tr><th><h2>Inq. IP</h2></th><td><a href="/admin/accounts?ipaddress=<?= $player['address'] ?>"><?= $player['address'] ?></a></td></tr>
            <tr><th><h2>Servidor</h2></th><td><?= $player['server'] ?></td></tr>
            <tr><th><h2>Entrada</h2></th><td><?= date('M d H:i Y', strtotime($player['lastJoin'])) ?></td></tr>
            <tr><th><h2 title="">Blocos/Hr</h2></th><td><?= $total ?>/<?= $hours ?> (<?= round($total/$hours, 2) ?>)</td></tr>
            <tr><th><h2 title="">Dim/Hr</h2></th><td><?= $diamond ?>/<?= $hours ?> (<?= round($diamond/$hours, 2) ?>)</td></tr>
            <? if ($total > 0): ?>
              <tr><th><h2 title="">Dim/Blocos</h2></th><td><?= $diamond ?>/<?= $total ?> (<?= round($diamond/$total, 2) ?>)</td></tr>
            <? endif; ?>
          <? endif; ?>
            <tr><th rowspan="6"><h2>Atributos</h2></th>
            <td>
              <input id="chk_admin" type="checkbox" name="admin" value="1" <?= $player['admin'] == 1 ? 'checked="checked"' : '' ?> />
              <label class="checkbox" for="chk_admin">administrador
            </td>
          </tr>
          <tr>
            <td>
              <input id="chk_operator" type="checkbox" name="operator" value="1" <?= $player['operator'] == 1 ? 'checked="checked"' : '' ?> />
              <label class="checkbox" for="chk_operator">operador
            </td>
          </tr>
          <tr>
            <td>
              <input id="chk_active" type="checkbox" name="active" value="1" <?= $player['active'] == 1 ? 'checked="checked"' : '' ?> />
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
              <input type="hidden" name="id" value="<?= $player['id'] ?>" />
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
  <div id="irc" class="section">
    <a href="#irc" class="noajax"><h1>Configurar  IRC</h1></a>
    <div class="inside">
      <div class="section">
        <form name="irc_settings" action="/users/update_irc" method="POST" autocomplete="off">
          <table class="form">
            <tr>
              <th><label for="irc_nickname"><h2>Nickname IRC</h2></label></th>
              <td><input id="irc_nickname" type="text" name="irc_nickname" value="<?= $player['ircnickname'] ?>" placeholder="irc nickname"></td>
            </tr>
            <tr>
              <th><label for="irc_password"><h2>Password Nickname</h2></label></th>
              <td><input id="irc_password" type="password" name="irc_password" value="<?= $player['ircpassword'] ?>" placeholder="nickserv password"></td>
            </tr>
            <tr>
              <th><label><h2>Opções</h2></label></th>
              <td>
                <input id="irc_auto" type="checkbox" name="irc_auto" value="1" <?= $player['ircauto'] == 1 ? 'checked="checked"' : '' ?> />
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

  <div id="changepw" class="section">
    <a href="#changepw" class="noajax"><h1>Alterar Password</h1></a>
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