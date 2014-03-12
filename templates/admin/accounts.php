  <div id="widget-accounts" c>
    <h1><a href="#widget-accounts-f" class="noajax collapsible"> Utilizadores (<?= $total ?>)</a></h1>
    
    <div class="listing-filters" id="widget-accounts-f" style="display: none;" >
      <form name="manage_users_filters" action="/admin/accounts" method="GET" autocomplete="off">
        <table class="admin options">
          <thead>
            <tr>
              <th class="center" style="width:35%;">
                <h2>Nome</h2>
              </th>
              <td>
                 <input type="text" name="playername" placeholder="steve" value="<?= $p['playername'] ?>">
               </td>
            </tr>
            <tr>
              <th class="center">
                <h2>Endereço de Email</h2>
              </th>
              <td>
                <input type="text" name="emailaddress" placeholder="mail@minecraft.pt" value="<?= $p['emailaddress'] ?>">
              </td>
            </tr>
            <tr>
              <th class="center">
                <h2>Endereço IP</h2>
              </th>
              <td>
                <input type="text" name="ipaddress" placeholder="192.168.0.1" value="<?= $p['ipaddress'] ?>">
              </td>
            </tr>
            <tr>
              <th class="center">
                <h2>Data de Login</h2>
              </th>
              <td>
                <input type="date" name="login_date_begin" value="<?= $p['login_date_begin'] ?>">
                <span title="Apenas serão mostradas contas onde houve um login após esta data">(Após)</span>
              </td>
            </tr>
            <tr>
              <td></td>
              <td>
                <input type="date" name="login_date_end" value="<?= $p['login_date_end'] ?>">
                <span title="Apenas serão mostradas contas onde houve um login até esta data">(Até)</span>
              </td>
            </tr>
            <tr>
              <th class="center"><h2>Data de Registo</h2></th>
              <td>
                <input type="date" name="register_date_begin" value="<?= $p['register_date_begin'] ?>">
                <span title="Apenas serão mostradas contas registadas após esta data">(Após)</span>
              </td>
            </tr>
            <tr>
              <td></td>
              <td>
                <input type="date" name="register_date_end" value="<?= $p['register_date_end'] ?>">
                <span title="Apenas serão mostradas registadas até esta data">(Até)</span>
              </td>
            </tr>
            <tr>
              <th class="center"><h2>Critérios</h2></th>
              <td>
                <input id="nologin" type="checkbox" name="nologin" value="1" <?= $p['nologin'] == 1 ? 'checked="checked"' : '' ?> />
                <label class="checkbox" for="nologin">nunca fez login</label>
              </td>
            </tr>
            <tr>
              <td></td>
              <td>
                <input id="yeslogin" type="checkbox" name="yeslogin" value="1" <?= $p['yeslogin'] == 1 ? 'checked="checked"' : '' ?> />
                <label class="checkbox" for="yeslogin">já fez login</label>
              </td>
            </tr>
            <tr>
              <td></td>
              <td>
                <input id="nogame" type="checkbox" name="nogame" value="1" <?= $p['nogame'] == 1 ? 'checked="checked"' : '' ?> />
                <label class="checkbox" for="nogame">nunca jogou</label>
              </td>
            </tr>
            <tr>
              <td></td>
              <td>
                <input id="yesgame" type="checkbox" name="yesgame" value="1" <?= $p['yesgame'] == 1 ? 'checked="checked"' : '' ?> />
                <label class="checkbox" for="yesgame">já jogou</label>
              </td>
            </tr>
            <tr>
              <td></td>
              <td>
                <input id="inactive" type="checkbox" name="inactive" value="1" <?= $p['inactive'] == 1 ? 'checked="checked"' : '' ?> />
                <label class="checkbox" for="inactive">inactivo</label>
              </td>
            </tr>
            <tr>
              <td></td>
              <td>
                <input id="admin" type="checkbox" name="admin" value="1" <?= $p['admin'] == 1 ? 'checked="checked"' : '' ?> />
                <label class="checkbox" for="admin">admin</label>
              </td>
            </tr>
            <tr>
              <td></td>
              <td>
                <input id="operator" type="checkbox" name="operator" value="1" <?= $p['operator'] == 1 ? 'checked="checked"' : '' ?> />
                <label class="checkbox" for="operator">operador</label>
              </td>
            </tr>
            <tr>
              <td></td>
              <td>
                <input id="contributor" type="checkbox" name="contributor" value="1" <?= $p['contributor'] == 1 ? 'checked="checked"' : '' ?> />
                <label class="checkbox" for="contributor">contribuidor</label>
              </td>
            </tr>
            <tr>
              <td></td>
              <td>
                <input id="donor" type="checkbox" name="donor" value="1" <?= $p['donor'] == 1 ? 'checked="checked"' : '' ?> />
                <label class="checkbox" for="donor">dador</label>
              </td>
            </tr>
            <tr>
              <td></td>
              <td>
                <input id="premium" type="checkbox" name="premium" value="1" <?= $p['premium'] == 1 ? 'checked="checked"' : '' ?> />
                <label class="checkbox" for="premium">premium</label>
              </td>
            </tr>
            <tr>
              <td></td>
              <td>
                <input id="isonline" type="checkbox" name="online" value="1" <?= $p['online'] == 1 ? 'checked="checked"' : '' ?> />
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
    </div>
    <div class="admin-form-body w100 pull-right">
      <form name="manage_users" action="/admin/configure" method="POST" autocomplete="off">
        <table class="admin alt-rows">
          <thead>
            <tr>
              <th class="cella"><h2 title="Nome do Jogador">Nome<h2></th>
              <th class="cellb"><h2 title="Ultima entrada no servidor">Ultima Entrada no servidor</h2></th>
              <th class="cellb"><h2 title="Ultimo IP (não actualizado se entrar não registado/logado)">Ultimo IP</h2></th>
              <th class="cellc"><h2 title="Administrador">@</h2></th>
              <th class="cellc"><h2 id="select-all-active" title="Conta Activa">A</h2></th>
              <th class="cellc"><h2 id="select-all-delete" title="APAGAR A CONTA!">X</h2></th>
              <th class="celld"></th>
            </tr>
          </thead>
          <tbody>
          <? foreach((array)$page as $r): ?>
            <tr>
              <td class="shortcell cella">
                <a data-online="<?= $r['online'] ? 'true' : 'false' ?>"
                   href="/profile?id=<?= $r['id'] ?>"
                   title="<?= $r["email"] ?>"
                   class="noajax"
                   data-widget-action="open"
                   data-widget-name="profile-<?= $r['playername'] ?>">
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
            <tr><td colspan="5" class="nav"><?= $navigation ?></td></tr>
          </tbody>
        </table>
      </form>
    </div>
  </div>